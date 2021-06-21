from pymongo import MongoClient
conn = MongoClient("mongodb://127.0.0.1:27017/")
db = conn.get_database("finance")

def make_coll(category):
    collections = db[f"{category}"]
    return collections

def upsert_DB(info, category):
    coll_category = make_coll(category)
    for i in info:
        coll_category.replace_one({"Date":i["Date"]}, i , upsert=True)

def get_DB(dateStr, category):
    coll_category = make_coll(category)
    dateISO = dateutil.parser.parse(dateStr)
    obj_train = coll_category.aggregate([{"$match":{"Date":{"$lt":dateISO}}},
                                {"$project":{"_id":0, "Date":1, "High":1, "Low":1, "Open":1, "Close":1}},
                                {"$sort":{"Date":1}}])

    obj_test = coll_category.aggregate([{"$match":{"Date":{"$lt":dateISO}}},
                                {"$project":{"_id":0, "Date":1, "High":1, "Low":1, "Open":1, "Close":1}},
                                {"$sort":{"Date":1}}])
    return (list(obj_train), list(obj_test))


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