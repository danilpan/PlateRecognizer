import serial

def readCom():
    s = serial.Serial('COM3')
    weight=''
    res = s.read()
    while('xb' not in str(res)):
        res = s.read()
    res = s.read()
    while('k' not in str(res)):
        if(res.isdigit()):
            weight+=str(res)
        res = s.read()
    weight=weight.replace('b','')
    weight=weight.replace("'",'')
    return weight