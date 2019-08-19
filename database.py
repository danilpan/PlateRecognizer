from datetime import datetime

import psycopg2
import tkinter
from tkinter import messagebox

#QUERIES
create_table_cars = "CREATE TABLE CAR (car_id SERIAL PRIMARY KEY, plate character varying(8) NOT NULL);"
create_table_weight = 'CREATE TABLE LOG (log_id SERIAL PRIMARY KEY, plate character varying(8) NOT NULL, time_visited TIMESTAMPTZ, weight_initial integer, weight_final integer, weight_delta integer)'


#Connection fucntion
def connect():
    conn = psycopg2.connect(user="postgres", password="postgres", host="127.0.0.1", port="5432", database="postgres")
    return conn

#Create tables functions
def create_tables():
    connection = connect()
    print('Succesfully connected')
    cursor = connection.cursor()
    cursor.execute(create_table_weight)
    connection.commit()
    print('Table Log is successfully created')
    cursor.execute(create_table_cars)
    connection.commit()
    cursor.close()
    print('Table Car is successfully created')
    connection.close()
    print('succesfully disconnected')


#Check for the plate at database
def check_plate(number):
    try:
        now = datetime.now() #current time
        connection = connect()
        insert_plate_query = "INSERT INTO log(plate, time_visited, weight_initial, weight_final, weight_delta) VALUES ('"+number+"', TIMESTAMPTZ '"+str(now)+"', NULL, NULL, NULL);"
        check_plate_query = "SELECT plate FROM car WHERE PLATE=\'"+number+"\';"
        print('succesfully connected')
        cursor = connection.cursor()
        if(number!="Ошибка"):
            cursor.execute(insert_plate_query)
            connection.commit()  
        cursor.execute(check_plate_query)
        data = cursor.fetchall()
        if(len(data) > 0):
            cursor.close()
            connection.close()
            print('succesfully finished')
            return True
        else:
            return False

    except Exception as e:
        print(str(e))


#Set initial weight of last comen car
def set_weight_initial(number, weight):
    try:
        connection = connect()
        set_weight_query = "UPDATE log SET weight_initial=" + str(weight)+" WHERE plate='"+str(number)+"' AND id=(SELECT MAX(id) FROM log);"
        print('succesfully connected')
        cursor = connection.cursor()
        cursor.execute(set_weight_query)
        connection.commit()
        cursor.close()
        connection.close()
        print('succesfully finished')

    except Exception as e:
        print(str(e))


#Set final weight of last comen car and check for weight delta
def set_weight_final(number, weight):
    try:
        connection = connect()
        set_weight_query = "UPDATE log SET weight_final=" + str(weight)+" WHERE id=(SELECT MAX(id) FROM log WHERE plate='"+number+"');"
        print('succesfully connected')
        cursor = connection.cursor()
        cursor.execute(set_weight_query)
        connection.commit()

        get_data_query = "SELECT * FROM log WHERE id=(SELECT MAX(id) FROM log WHERE plate'"+number+"';"
        cursor.execute(get_data_query)
        data = cursor.fetchall()

        weight_initial = data[0][2]
        print(abs(weight-weight_initial))

        print('succesfully finished')
        if (abs(weight-weight_initial) == data[0][4]):
            root = tkinter.Tk()
            root.withdraw()
            messagebox.showinfo("Legal","Вес совпадает")
        else:
            root = tkinter.Tk()
            root.withdraw()
            messagebox.showinfo("Illegal","Вес не соответствует данным")
            
        cursor.close()
        connection.close()

    except Exception as e:
        print(str(e))