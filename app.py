#!/home/server/.envs/tensorflow/bin/python3

import os
import sys
import requests
from flask import Flask
import cv2
import numpy
import time

from Snapshot import snap
from nomeroffnet import detection
from nomeroffnet.NomeroffNet import Detector, RectDetector, OptionsDetector, TextDetector, filters, textPostprocessingAsync

nnet = '1'
rectDetector = '1'
textDetector = '1'
optionsDetector = '1'

class FlaskApp(Flask):

    def __init__(self, *args, **kwargs):
        super(FlaskApp, self).__init__(*args, **kwargs)
        

app = Flask(__name__)

@app.route('/')
def index():
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
    return "Hello, World!"

@app.route('/get_plate')
def get_plate_number():
    img = cv2.imread('./img.jpg')
    plate_number = detection.first(img,rectDetector, textDetector, nnet, optionsDetector)[0]
    return str(plate_number)

if __name__ == '__main__':
    app.run(host='0.0.0.0',debug=True)