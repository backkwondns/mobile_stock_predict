import mongo

dateStr = '2021-05-01T00:00:00.000Z'
target_stock = "NASDAQ_PRED" 
x = mongo.upsert_DB_holly(dateStr, target_stock)
#print(x)
