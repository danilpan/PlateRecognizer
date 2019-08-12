import sys
import os
import numpy as np
import sys
import json
import matplotlib.image as mpimg
from matplotlib import pyplot as plt
import warnings

from nomeroffnet.NomeroffNet import Detector, RectDetector, OptionsDetector, TextDetector, filters, textPostprocessingAsync
import asyncio

import PyQt5
import cv2
import PyQt5.QtCore as QtCore
import PyQt5.QtGui as QtGui
import PyQt5.QtWidgets as QtWidgets
import GUI
import COM
import Snapshot
import Snapshot2
import nomeroffnet.database as db
import threading
import time

nnet = ''
rectDetector = ''
textDetector = ''
optionsDetector = ''



def bytes_to_int(bytes):
    result = 0

    for b in bytes:
        result = result * 256 + int(b)

    return result


class Thread(QtCore.QThread):
    changePixmap = QtCore.pyqtSignal(QtGui.QImage)
    link = "http://192.168.0.107/live"

    def run(self):
        cap = cv2.VideoCapture(self.link)
        while True:
            ret, frame = cap.read()
            if (ret):
                rgbImage = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
                convertToQtFormat = QtGui.QImage(
                    rgbImage.data, rgbImage.shape[1], rgbImage.shape[0], QtGui.QImage.Format_RGB888)
                p = convertToQtFormat.scaled(
                    640, 480, QtCore.Qt.KeepAspectRatio)
                self.changePixmap.emit(p)


class App(QtWidgets.QMainWindow, GUI.Ui_MainWindow):

    th = Thread
    th2 = Thread

    def __init__(self):
        super().__init__()
        self.setupUi(self)
        self.load_models()
        self.initUI()

    def snap(self):
        number = ""
        start = time.time()
        try:
            print('Taking picture...')
            number = Snapshot.snap(rectDetector, textDetector, nnet, optionsDetector)[0]
            print('Snapped!')
        except Exception as e:
            print(str(e))
            number = "Ошибка"
        self.number_label.setText(number)
        end = time.time()
        print(end-start)
        return number

    def snap2(self):
        number = ""
        try:
            print('Taking picture...')
            number = Snapshot2.snap()[0]
            print('Snapped!')
        except Exception as e:
            # tkMessageBox.showwarning('Ошибка', e.message)
            print(str(e))
            number = "Ошибка"
        self.number_label.setText(number)
        return number

    def set_weight(self):
        num=COM.readCom()
        self.lcdNumber.display(num)

    @QtCore.pyqtSlot(QtGui.QImage)
    def setImage(self, image):
        self.label.setPixmap(QtGui.QPixmap.fromImage(image))

    def setImage2(self, image):
        self.number_label.setPixmap(QtGui.QPixmap.fromImage(image))

    def initUI(self):
        # create a label
        self.pushButton.clicked.connect(self.check_data)
        self.pushButton_2.clicked.connect(self.check_plate)
        self.pushButton_3.clicked.connect(self.set_weight)
        self.pushButton_4.clicked.connect(self.start_camera)
        self.label = QtWidgets.QLabel(self)
        self.label.move(0, -50)
        self.label.resize(561, 500)
        self.number_label = QtWidgets.QLabel(self)
        self.number_label.move(0, 300)
        self.number_label.resize(561, 500)
        self.th = Thread(self)
        self.th2 = Thread(self)
        self.th2.link = "http://192.168.0.107/live"
        self.th.changePixmap.connect(self.setImage)
        self.th2.changePixmap.connect(self.setImage2)
        self.th.start()
        self.th2.start()

    def start_camera(self):
        self.th.terminate()
        self.th = Thread()
        self.th.changePixmap.connect(self.setImage)
        self.th.start()
        self.th2.terminate()
        self.th2 = Thread()
        self.th2.link = "http://192.168.0.107/live"
        self.th2.changePixmap.connect(self.setImage2)
        self.th2.start()

    def check_plate(self):
        my_number = self.snap()
        print(my_number)
        try:
            db.create_table()
        except:
            pass
        response = db.check_plate(my_number)
        if(response == 'yes'):
            print('Number is in database')
            # win32api.MessageBox(0, 'Номер в базе данных', 'OK')
        else:
            print('Number is not detected')
            # win32api.MessageBox(0, 'Номер отсутствует в базе данных', 'SOS')

    def check_data(self):
        my_num = self.snap2()
        db.set_weight_final(my_num, float(COM.readCom))

    def load_models(self):
        global nnet
        global rectDetector
        global optionsDetector
        global textDetector

        # change this property
        NOMEROFF_NET_DIR = os.path.abspath('nomeroffnet/')
        print(NOMEROFF_NET_DIR)
        # specify the path to Mask_RCNN if you placed it outside Nomeroff-net project
        MASK_RCNN_DIR = os.path.join(NOMEROFF_NET_DIR, 'Mask_RCNN')

        MASK_RCNN_LOG_DIR = os.path.join(NOMEROFF_NET_DIR, 'logs')
        MASK_RCNN_MODEL_PATH = os.path.join(NOMEROFF_NET_DIR, "models/mask_rcnn_numberplate_0700.pb")
        OPTIONS_MODEL_PATH =  os.path.join(NOMEROFF_NET_DIR, "models/numberplate_options_simple_2019_03_29.pb")

        # If you use gpu version tensorflow please change model to gpu version named like *-gpu.pb
        mode = "gpu"
        OCR_NP_KZ_TEXT =  os.path.join(NOMEROFF_NET_DIR, "models/anpr_ocr_kz_4-{}.pb".format(mode))

        sys.path.append(NOMEROFF_NET_DIR)
        # Initialize npdetector with default configuration file.
        nnet = Detector(MASK_RCNN_DIR, MASK_RCNN_LOG_DIR)
        nnet.loadModel(MASK_RCNN_MODEL_PATH)

        rectDetector = RectDetector()

        optionsDetector = OptionsDetector({
            "class_region": ["kz"]
        })
        optionsDetector.load(OPTIONS_MODEL_PATH)

        # Initialize text detector.
        textDetector = TextDetector({
            "kz": {
                "for_regions": ["kz"],
                "model_path": OCR_NP_KZ_TEXT
            }
        })   
        

def main():
    app = QtWidgets.QApplication(sys.argv)  # Новый экземпляр QApplication
    window = App()  # Создаём объект класса ExampleApp
    window.show()  # Показываем окно
    app.exec_()


if __name__ == '__main__':
    main()
