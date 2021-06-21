import pandas as pd
import mongo
from datetime import date

dateStr = '2021-04-01T00:00:00.000Z'
target_stock = "SAMSUNG_SDI".replace(" ","_")

today = date.today()
str_today = today.strftime("%m%d")

stock_lt, stock_gte = mongo.get_DB(dateStr, target_stock) ###stock_lt == train 기준일 이전 데이터 , stock_gte == test 기준일 포함 후의 데이터
lt_df = pd.DataFrame(stock_lt)
gte_df = pd.DataFrame(stock_gte)

lt_df.to_csv(f"../data_dir/train_{target_stock}_{str_today}.csv")
gte_df.to_csv(f"../data_dir/test_{target_stock}_{str_today}.csv")
