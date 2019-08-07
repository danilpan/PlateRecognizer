import urllib.request
import cv2
from nomeroffnet import detection
import numpy as np


def snap():
    url = "rtsp://admin:EastProject@192.168.0.102/shot.jpg"
    vidcap = cv2.VideoCapture(url)
    c, img = vidcap.read()
    if c:
        return detection.first(img)
