import yfinance as yf
import mongo
import json

kospi = yf.Ticker("^KS11")
info = kospi.history(period='10000d')
info["Date"] = info.index
#print(info.dtypes)
info = info.reset_index(drop=True)
mongo.upsert_DB(info.to_dict("records"), "KOSPI")
