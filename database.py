import psycopg2
import tkinter
from tkinter import messagebox


def create_table():
    connection = psycopg2.connect(user="postgres",
                                  password="server",
                                  host="127.0.0.1",
                                  port="5432",
                                  database="postgres")
    create_table_query = 'CREATE TABLE Weight (ID SERIAL PRIMARY KEY, PLATE character varying(8) NOT NULL, WEIGHT_INITIAL double precision, WEIGHT_FINAL double precision, "WEIGHT_NORMAL" double precision)'
    print('succesfully connected')
    cursor = connection.cursor()
    cursor.execute(create_table_query)
    connection.commit()
    cursor.close()
    connection.close()
    print('succesfully finished')


def check_plate(number):
    try:
        connection = psycopg2.connect(user="postgres",
                                      password="server",
                                      host="127.0.0.1",
                                      port="5432",
                                      database="postgres")
        create_table_query = 'CREATE TABLE Weight (ID SERIAL PRIMARY KEY, PLATE character varying(8) NOT NULL, WEIGHT_INITIAL double precision, WEIGHT_FINAL double precision, "WEIGHT_NORMAL" double precision)'
        add_plate_query = "INSERT INTO weight VALUES (\'218DE02\', NULL, NULL, NULL, NULL);"
        check_plate_query = "SELECT PLATE FROM weight WHERE PLATE=\'"+number+"\';"
        print('succesfully connected')
        cursor = connection.cursor()
        cursor.execute(check_plate_query)
        # connection.commit()
        data = cursor.fetchall()
        if(len(data) > 0):
            cursor.close()
            connection.close()
            print('succesfully finished')
            return 'yes'
        else:
            return 'no'

    except Exception as e:
        print(str(e))


def set_weight_initial(number, weight):
    try:
        connection = psycopg2.connect(user="postgres",
                                      password="server",
                                      host="127.0.0.1",
                                      port="5432",
                                      database="postgres")
        set_weight_query = "UPDATE weight SET WEIGHT_INITIAL=" + \
            str(weight)+" WHERE PLATE=\'"+str(number)+"\';"
        print('succesfully connected')
        cursor = connection.cursor()
        cursor.execute(set_weight_query)
        connection.commit()
        cursor.close()
        connection.close()
        print('succesfully finished')

    except Exception as e:
        print(str(e))


def set_weight_final(number, weight):
    try:
        connection = psycopg2.connect(user="postgres",
                                      password="server",
                                      host="127.0.0.1",
                                      port="5432",
                                      database="postgres")
        set_weight_query = "UPDATE weight SET WEIGHT_FINAL=" + \
            str(weight)+" WHERE PLATE=\'"+str(number)+"\';"
        print('succesfully connected')
        cursor = connection.cursor()
        # cursor.execute(set_weight_query)
        # connection.commit()

        get_data_query = "SELECT * FROM weight WHERE PLATE=\'"+number+"\';"
        cursor.execute(get_data_query)
        data = cursor.fetchall()

        weight_initial = data[0][2]
        print(abs(weight-weight_initial))

        cursor.close()
        connection.close()
        print('succesfully finished')
        if (abs(weight-weight_initial) == data[0][4]):
            root = tkinter.Tk()
            root.withdraw()
            messagebox.showinfo("Legal","Вес совпадает")
        else:
            root = tkinter.Tk()
            root.withdraw()
            messagebox.showinfo("Illegal","Вес не соответствует данным")

    except Exception as e:
        print(str(e))