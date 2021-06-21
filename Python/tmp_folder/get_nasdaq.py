import yfinance as yf
import mongo
import json

nasdaq = yf.Ticker("^IXIC")
info = nasdaq.history(period='10000d')
info["Date"] = info.index
#print(info.dtypes)
info = info.reset_index(drop=True)
mongo.upsert_nasdaq(info.to_dict("records"))
