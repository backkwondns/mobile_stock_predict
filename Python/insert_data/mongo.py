from pymongo import MongoClient
from dateutil import parser
from datetime import datetime, timedelta

conn = MongoClient("mongodb://127.0.0.1:27017/")
db = conn.get_database("finance")

def make_coll(category):
    collections = db.get_collection(category)
    return collections

def upsert_DB(info, category):
    coll_category = make_coll(category)
    for i in info:
        coll_category.replace_one({"Date":i["Date"]}, i , upsert=True)

def get_DB(dateStr, category):
    coll_category = make_coll(category)
    dateISO = parser.parse(dateStr)
    obj_train = coll_category.aggregate([{"$match":{"Date":{"$lt":dateISO}}},
                                {"$project":{"_id":0, "Date":1, "High":1, "Low":1, "Open":1, "Close":1}},
                                {"$sort":{"Date":1}}])

    obj_test = coll_category.aggregate([{"$match":{"Date":{"$gte":dateISO}}},
                                {"$project":{"_id":0, "Date":1, "High":1, "Low":1, "Open":1, "Close":1}},
                                {"$sort":{"Date":1}}])
    return (list(obj_train), list(obj_test))

def upsert_DB_holly(dateStr, category):
    coll_category = make_coll(category)
    dateISO = parser.parse(dateStr)
    start_obj = coll_category.aggregate([{"$sort":{"Date":1}},
                                {"$limit":1}
                                ])

    end_obj = coll_category.aggregate([{"$sort":{"Date":-1}},
                                {"$limit":1}
                                ])
    list_data = list(start_obj)
    tmp_date = list_data[0]["Date"]
    tmp_value = list_data[0]["values"]
    to_date = list(end_obj)[0]["Date"]
    to_date = datetime.strptime(to_date, "%Y-%m-%d").date()
   
    for i in range(1,1000):
        date_obj = datetime.strptime(tmp_date, "%Y-%m-%d")
        if date_obj.date() == to_date:
            break
        
        res = coll_category.find_one({"Date":f"{tmp_date}"})
        if res != None:
            target_obj = date_obj + timedelta(days=1)
            next_day = datetime.strftime(target_obj, '%Y-%m-%d')
            tmp_date = next_day
            tmp_value = res["values"]
            
        else:
            target_obj = date_obj + timedelta(days=1)
            next_day = datetime.strftime(target_obj, '%Y-%m-%d')

            tmp_dict = {"Date":tmp_date, "values": tmp_value, "etc" : "HollyDay"}
            
            print(tmp_dict)
            
            coll_category.replace_one({"Date":tmp_date}, tmp_dict , upsert=True)
            


""" 
##############################################################################

    INSERT DATA
    upsert --> prevent overlap
    
    upsert_kospi  => insert all KOSPI data
    upsert_nasdaq => insert all NASDAQ data
    
    (after predict)
    upsert_kospi_pred  => insert predicted KOSPI data
    upsert_nasdaq_pred => insert predicted NASDAQ data

##############################################################################
"""

"""
##############################################################################
def upsert_kospi(info):
    for i in info:
        coll_kospi.replace_one({"Date":i["Date"]}, i , upsert=True)

def upsert_nasdaq(info):
    for i in info:
        coll_nasdaq.replace_one({"Date":i['Date']}, i, upsert=True)

def upsert_kospi_pred(info):
    for i in info:
        coll_kospi_pred.replace_one({"Date":i["Date"]}, i , upsert=True)

def upsert_nasdaq_pred(info):
    for i in info:
        coll_nasdaq_pred.replace_one({"Date":i['Date']}, i, upsert=True)

##############################################################################
###############################################################################
    
    GET DATA FROM MONGO
    (to make csv file)

    get_kospi  => get all KOSPI data from MONGO except {_id} and sorted by Date
    get_nasdaq =>    ''   NASDAQ  ''

    get_kospi_cond  => get specific period KOSPI data from MONGO except {_id} and sorted by Date
    get_nasdaq_cond => get specific period NASDAQ                     ''


def get_kospi():
    obj = coll_kospi.aggregate([{"$project":{"_id":0, "Date":1, "High":1, "Low":1, "Open":1, "Close":1}},
                                {"$sort":{"Date":1}}])
    return list(obj)

def get_nasdaq():
    obj = coll_nasdaq.aggregate([{"$project":{"_id":0, "Date":1, "High":1, "Low":1, "Open":1, "Close":1}},
                                {"$sort":{"Date":1}}])
    return list(obj)

def get_kospi_cond():
    dateStr = "2021-04-01T00:00.000Z"
    dateISO = dateutil.parser.parse(dateStr)
    obj = coll_kospi.aggregate([{"$match":{"Date":{"$lt":dateISO}}},
                                {"$project":{"_id":0, "Date":1, "High":1, "Low":1, "Open":1, "Close":1}},
                                {"$sort":{"Date":1}}])
    return list(obj)

def get_nasdaq_cond():
    dateStr = '2021-04-01T00:00:00.000Z'
    dateISO = dateutil.parser.parse(dateStr)
    obj = coll_nasdaq.aggregate([{"$match":{"Date":{"$lt":dateISO}}},
                                {"$project":{"_id":0, "Date":1, "High":1, "Low":1, "Open":1, "Close":1}},
                                {"$sort":{"Date":1}}])
    return list(obj)


###############################################################################
"""
