import pandas as pd
import numpy as np
from tensorflow.keras import models
import mongo
from datetime import date
today = date.today()
str_today = today.strftime("%m%d")

def make_dataset(data, label, window_size=5):
    feature_list = []
    label_list = []

    for i in range(len(data) - window_size):
        feature_list.append(np.array(data.iloc[i:i+window_size]))
        label_list.append(np.array(label.iloc[i:i+window_size]))
    return np.array(feature_list), np.array(label_list)

test_df = pd.read_csv(f"./data_dir/test_NASDAQ_{str_today}.csv")
test_df["Medium"] = test_df[["High", "Low"]].mean(axis = 1)
start_date = test_df["Date"][0]
feature_test = test_df[["High", "Low", "Open", "Medium"]]
target_test = test_df["Close"]
test_Feature, test_Label = make_dataset(feature_test, target_test)

loaded_Model = models.load_model("my_model_NASDAQ")
pred = loaded_Model.predict(test_Feature)

df = {"Date":list(test_df["Date"][5:]), "values":[int(x) for x in pred.reshape(1,-1)[0].tolist()]}
info = pd.DataFrame(df)
info = info.reset_index(drop=True)
mongo.upsert_nasdaq_pred(info.to_dict("records"))
