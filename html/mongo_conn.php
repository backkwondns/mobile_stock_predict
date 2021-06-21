<?php
/*
#require 'vendor/autoload.php'; // include Composer's autoloader
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

#$id = new MongoDB\BSON\ObjectId("60cadf9616bdce5368c44cfc");
#$filter      = ['_id' => $id];
$filter = ['values' => ['$gt' => 3000]];
#$options = [];
$query = new \MongoDB\Driver\Query($filter);
$rows   = $manager->executeQuery('finance.KOSPI_PRED', $query);
foreach ($rows as $document) {
    print_r($document);
  }

*/

class stock{

    public $manager;
    public $stock_code_array = array(
        "KOSPI"=>"^KS11",
        "NASDAQ"=>"^IXIC",
        "APPLE"=>"AAPL",
        "AMAZON"=>"AMZN",
        "SAMSUNG ELECTRONICS"=>"005930.KS",
        "SAMSUNG SDI"=>"006400.KS",
    );

    //__construct
    public function __construct(){
      try{
        $this->manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
      }catch(Exception $e){
          print_r($e);
      }
    }
    ################### 1개 씩 띄우는 chart.php ###################
    public function get_Stock($start_date, $end_date, $category){ 
        $return_array = array('Date' => array(), 'values' => array());
        try{
            $filter = ['Date' => ['$gte' => $start_date, '$lte' => $end_date]];
            $options = ['sort' => array('Date' => 1)]; #### 'limit' => 1 (1개만)
            $query = new MongoDB\Driver\Query($filter, $options);
            $rows   = $this->manager->executeQuery('finance.'.$category, $query);
            foreach($rows as $document){
                $document = json_decode(json_encode($document),true);
                array_push($return_array['Date'], $document['Date']);
                array_push($return_array['values'], $document['values']);
            }
            return $return_array;
        }catch(Exception $e){
            print_r($e);
        }
    }
    public function get_Stock_default($category){
        $return_array = array('Date' => array(), 'values' => array());
        try{
            $filter = ['Date' => ['$gte' => '1900-01-01']];
            $options = ['sort' => array('Date' => -1), 'limit' => 15]; #### 'limit' => 1 (1개만)
            $query = new MongoDB\Driver\Query($filter, $options);
            $rows   = $this->manager->executeQuery('finance.'.$category, $query);
            foreach($rows as $document){
                $document = json_decode(json_encode($document),true);
                array_push($return_array['Date'], $document['Date']);
                array_push($return_array['values'], $document['values']);
            }
            $return_array["Date"] = array_reverse($return_array["Date"]);
            $return_array["values"] = array_reverse($return_array["values"]);
            return $return_array;
        }catch(Exception $e){
            print_r($e);
        }
    }

    ################### 한번에 띄우는 index.php ###################

    public function get_Stock_total($start_date, $end_date){
        $return_array = array('Date_KOSPI' => array(), 'values_KOSPI' => array(), 'Date_NASDAQ' => array(), 'values_NASDAQ' => array() );
        try{
            $filter = ['Date' => ['$gte' => $start_date, '$lte' => $end_date]];
            $options = ['sort' => array('Date' => 1)]; #### 'limit' => 1 (1개만)
            $query = new MongoDB\Driver\Query($filter, $options);
            $rows   = $this->manager->executeQuery('finance.KOSPI_PRED', $query);
            foreach($rows as $document){
                $document = json_decode(json_encode($document),true);
                array_push($return_array['Date_KOSPI'], $document['Date']);
                array_push($return_array['values_KOSPI'], $document['values']);
            }
            $rows   = $this->manager->executeQuery('finance.NASDAQ_PRED', $query);
            foreach($rows as $document){
                $document = json_decode(json_encode($document),true);
                array_push($return_array['Date_NASDAQ'], $document['Date']);
                array_push($return_array['values_NASDAQ'], $document['values']);
            }

            return $return_array;
        }catch(Exception $e){
            print_r($e);
        }
    }

    public function get_Stock_total_default(){
        $return_array = array('Date_KOSPI' => array(), 'values_KOSPI' => array(), 'Date_NASDAQ' => array(), 'values_NASDAQ' => array() );
        try{
            $filter = ['Date' => ['$gte' => '1900-01-01']];
            $options = ['sort' => array('Date' => -1), 'limit' => 15]; #### 'limit' => 1 (1개만)
            $query = new MongoDB\Driver\Query($filter, $options);
            $rows   = $this->manager->executeQuery('finance.KOSPI_PRED', $query);
            foreach($rows as $document){
                $document = json_decode(json_encode($document),true);
                array_push($return_array['Date_KOSPI'], $document['Date']);
                array_push($return_array['values_KOSPI'], $document['values']);
            }
            $rows   = $this->manager->executeQuery('finance.NASDAQ_PRED', $query);
            foreach($rows as $document){
                $document = json_decode(json_encode($document),true);
                array_push($return_array['Date_NASDAQ'], $document['Date']);
                array_push($return_array['values_NASDAQ'], $document['values']);
            }
            $return_array["Date_KOSPI"] = array_reverse($return_array["Date_KOSPI"]);
            $return_array["values_KOSPI"] = array_reverse($return_array["values_KOSPI"]);
            $return_array["Date_NASDAQ"] = array_reverse($return_array["Date_NASDAQ"]);
            $return_array["values_NASDAQ"] = array_reverse($return_array["values_NASDAQ"]);
            return $return_array;
        }catch(Exception $e){
            print_r($e);
        }
    }

    ################### 실제 데이터 Table.php ###################

    public function get_real_Stock($category){
        try{
            $filter = [];
            $options = ['sort' => array('Date' => -1), 'limit' => 300];
            $query = new MongoDB\Driver\Query($filter, $options);
            $rows = $this->manager->executeQuery('finance.'.$category, $query);
            return $rows;
        }catch(Exception $e){
            print_r($e);
        }

    }
}
$x = new stock();
$res = $x->get_real_Stock("KOSPI");
#echo(json_encode($res['Date']));
?>