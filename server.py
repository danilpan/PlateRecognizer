import os
import sys
import time
import json
import hashlib
import requests

from flask import Flask, request, abort
import cv2
import numpy

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


def is_authorized():
    hash_object = hashlib.md5('helloworld'.encode())
    md5_hash = hash_object.hexdigest()
    r = request.headers.get('x-api-key')
    if((r is None) or (r != md5_hash)):
        abort(403)


def process_image():
    start = time.time()
    img = cv2.imread('image.jpg')
    plate_number = detection.first(
        img, rectDetector, textDetector, nnet, optionsDetector)[0]
    end = time.time()
    calculation_time = end - start
    data = {'plateNumber': str(plate_number),
                               'calcTime': str(calculation_time)}
    response = json.dumps(data)
    return response


@app.route('/')
def index():
    return "Welcome to NPR System"


@app.route('/testRecognition')
def testRecognition():
    is_authorized()
    result = process_image()
    return result


@app.route('/recognition', methods=['POST'])
def recognition():
    is_authorized()
    try:
        with open("image.jpg", "bw+") as f:
            chunk_size = 4096
            while True:
                chunk = request.stream.read(chunk_size)
                if len(chunk) == 0:
                    result = process_image()
                    return result
                f.write(chunk)
    except Exception:
        return json.dumps({'plateNumber': 'N/I'})


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
    MASK_RCNN_MODEL_PATH = os.path.join(
        NOMEROFF_NET_DIR, "models/mask_rcnn_numberplate_0700.pb")
    OPTIONS_MODEL_PATH = os.path.join(
        NOMEROFF_NET_DIR, "models/numberplate_options_simple_2019_03_29.pb")

    # If you use gpu version tensorflow please change model to gpu version named like *-gpu.pb
    mode = "gpu"
    OCR_NP_KZ_TEXT = os.path.join(
        NOMEROFF_NET_DIR, "models/anpr_ocr_kz_4-{}.pb".format(mode))

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
    app.run(host='0.0.0.0', debug=True, port=5000)
