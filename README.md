# 2021 / 06
# Stock Predcit Project

Jetson Nano (memory 4GB version)

linux kernel 4.9.201-tegra <br />
OS Ubuntu18.04.5 LTS <br />
MongoDB 3.6.3 <br />
Python 3.6.9 <br />

==============

numpy 1.19.5 <br />
pandas 1.1.5 <br />
tensorflow 2.4.0+nv21.5 <br />
scikit-learn 0.19.2 <br />
scikit-image 0.17.2 <br />
yfinance 0.1.59 <br />


=========

PHP 8.0.7 <br />
PHP-mongodb driver 1.9.1 <br />

<h2>Flow Chart</h2>
<h3>
  1. yfinance(yahoo finance 데이터 수집 모듈)을 통하여 주식 데이터를 받아와 DataFrame 형태로 저장<br />
  2. 저장된 DF를 MongoDB에 저장<br />
  3. MongoDB에 저장된 데이터를 가져와 train_csv, test_csv로 분리하여 저장<br />
  4. 저장된 csv파일들을 통하여 LSTM모델에 학습 과 예측을 진행<br />
  5. 예측된 데이터를 MongoDB에 {stock}_PRED collections에 저장<br />
  6. PHP로 구성을 하여 저장된 {stock}_PRED를 chart로 <br />
  
</h3>
