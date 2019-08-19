import urllib.request
import cv2
import numpy as np

from nomeroffnet import detection

def snap(rectDetector, textDetector, nnet, optionsDetector):
    url = "rtsp://admin:EastProject@192.168.0.102/shot.jpg"
    vidcap = cv2.VideoCapture(url)
    c, img = vidcap.read()
    if c:
        return detection.first(img, rectDetector, textDetector, nnet, optionsDetector)
