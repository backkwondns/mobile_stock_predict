import yfinance as yf
import mongo
import json

#KOSPI == "^KS11"
#NASDAQ == "^IXIC"
#APPLE = "AAPL"
#AMAZON = "AMZN"
#SAMSUNG_ELECTRONICS = "005930.KS"
#SAMSUNG_SDI = "006400.KS"
stock_code = "006400.KS"
stock_name = "SAMSUNG_SDI"

data_stock = yf.Ticker(stock_code)
info = data_stock.history(period='10000d')
info["Date"] = info.index
#print(info.dtypes)
info = info.reset_index(drop=True)
mongo.upsert_DB(info.to_dict("records"), stock_name)
