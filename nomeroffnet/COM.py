import serial

def readCom():
    s = serial.Serial('COM4')
    res = s.read()
    return res