import os
import sys
import time

import requests
from flask import Flask, request
import cv2
import numpy

from Snapshot import snap
from nomeroffnet import detection
from nomeroffnet.NomeroffNet import Detector, RectDetector, OptionsDetector, TextDetector, filters, textPostprocessingAsync

nnet = ''
rectDetector = ''
textDetector = ''
optionsDetector = ''

class FlaskApp(Flask):

    def __init__(self, *args, **kwargs):
        super(FlaskApp, self).__init__(*args, **kwargs)
        

app = Flask(__name__)

@app.route('/')
def index():
    return "Welcome to Plate Recognizer home page"

@app.route('/get_plate')
def get_plate_number():
    start = time.time()
    img = cv2.imread('./img.jpg')
    plate_number = detection.first(img,rectDetector, textDetector, nnet, optionsDetector)[0]
    end = time.time()
    calculation_time = end - start
    response = 'Plate Number: '+str(plate_number)+" , "+'Calculation Time: '+str(calculation_time)
    return response


@app.route('/processImage',methods=['GET','POST'])
def process_image():
    if request.method == 'POST':
        with open("image.jpg", "bw+") as f:
            chunk_size = 4096
            while True:
                chunk = request.stream.read(chunk_size)
                if len(chunk) == 0:
                    start = time.time()
                    img = cv2.imread('image.jpg')
                    plate_number = detection.first(img,rectDetector, textDetector, nnet, optionsDetector)[0]
                    end = time.time()
                    calculation_time = end - start
                    response = 'Plate Number: '+str(plate_number)+" , "+'Calculation Time: '+str(calculation_time)
                    return response
                f.write(chunk)
    return 'GET method'


def load_models():
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

if __name__ == '__main__':
    load_models()
    app.run(host='0.0.0.0',debug=True)