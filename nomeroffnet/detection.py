# Import all necessary libraries.
import sys
import os
import cv2
import numpy as np
import sys
import json
import matplotlib.image as mpimg
from matplotlib import pyplot as plt
import warnings

sys.path.append('./NomeroffNet')

from .NomeroffNet import Detector, RectDetector, OptionsDetector, TextDetector, filters, textPostprocessingAsync
import asyncio


def first(img, rectDetector, textDetector, nnet, optionsDetector):
    loop = asyncio.new_event_loop()
    asyncio.set_event_loop(loop)
    return loop.run_until_complete(third(rectDetector,textDetector,nnet,optionsDetector,img))
    

async def third(rectDetector,textDetector,nnet,optionsDetector,img):
    max_img_w = 1600
    img_w = img.shape[1]
    img_h = img.shape[0]
    img_w_r = 1
    img_h_r = 1
    if img_w > max_img_w:
        resized_img = cv2.resize(img, (max_img_w, int(max_img_w/img_w*img_h)))
        img_w_r = img_w/max_img_w
        img_h_r = img_h/(max_img_w/img_w*img_h)
    else:
        resized_img = img
        
    NP = nnet.detect([resized_img]) 
    
    # Generate image mask.
    cv_img_masks = await filters.cv_img_mask_async(NP)
        
    # Detect points.
    arrPoints = await rectDetector.detectAsync(cv_img_masks, outboundHeightOffset=3-img_w_r, fixGeometry=True, fixRectangleAngle=10)
    arrPoints[..., 1:2] = arrPoints[..., 1:2]*img_h_r
    arrPoints[..., 0:1] = arrPoints[..., 0:1]*img_w_r
    
    # cut zones
    zones = await rectDetector.get_cv_zonesBGR_async(img, arrPoints)
    regionNames = ["kz"]

    # find text with postprocessing by standart  
    textArr = textDetector.predict(zones, regionNames)
    textArr = await textPostprocessingAsync(textArr, regionNames)
    return (textArr)