#!/home/server/.envs/tensorflow/bin/python3

import urllib.request
import cv2
from nomeroffnet import detection
import numpy as np


def snap(rectDetector, textDetector, nnet, optionsDetector):
    url = "http://192.168.0.126:8080/video"
    vidcap = cv2.VideoCapture(url)
    c, img = vidcap.read()
    if c:
        return detection.first(img, rectDetector, textDetector, nnet, optionsDetector)