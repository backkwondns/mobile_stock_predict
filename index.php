<?php 
require_once("header.php");
require_once("/var/www/html/mongo_conn.php");

$pred = new stock();

if (isset($_POST["startdate"])){
    $res = $pred->get_Stock_total($_POST["startdate"], $_POST["enddate"]);
    $date_KOSPI = json_encode($res["Date_KOSPI"], true);
    $value_KOSPI = json_encode($res["values_KOSPI"], true);
    $date_NASDAQ = json_encode($res["Date_NASDAQ"], true);
    $value_NASDAQ = json_encode($res["values_NASDAQ"], true);
}else{
    $res = $pred->get_Stock_total_default();
    
    $start_KOSPI = strtotime($res["Date_KOSPI"][0]);
    $start_NASDAQ = strtotime($res["Date_NASDAQ"][0]);
    if ($start_KOSPI <= $start_NASDAQ){
        $_POST["startdate"] = $res["Date_KOSPI"][0];
    }else{
        $_POST["startdate"] = $res["Date_NASDAQ"][0];
    }

    $end_KOSPI = strtotime(end($res["Date_KOSPI"]));
    $end_NASDAQ = strtotime(end($res["Date_NASDAQ"]));
    if ($end_KOSPI >= $end_NASDAQ){
        $_POST["enddate"] = end($res["Date_KOSPI"]);
    }else{
        $_POST["enddate"] = end($res["Date_NASDAQ"]);
    }
    $date_KOSPI = json_encode($res["Date_KOSPI"], true);
    $value_KOSPI = json_encode($res["values_KOSPI"], true);
    $date_NASDAQ = json_encode($res["Date_NASDAQ"], true);
    $value_NASDAQ = json_encode($res["values_NASDAQ"], true);
    }
?>

    <div class="container-fluid px-4">
    <h1 class="mt-4">Total STOCK INDEX Chart</h1>
    <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active"></li>
    </ol>

    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="card mb-4">
        <div class="card-header">
            <div class="col-auto">
                <div class="form-group">
                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" value="<?= $_POST['startdate'] ?>" name=startdate>
                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker" style="height:100%;">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2" value="<?= $_POST['enddate'] ?>" name=enddate>
                        <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker" style="height:100%;">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-auto">
            <button type="submit" class="btn btn-success" style="width:100%;">Search</button>
            </div>
        </form>
        </div>
        <div class="card-body"><canvas id="STOCK_PRED" width="100%" height="30%"></canvas></div>
        <div class="card-footer small text-muted">TOTAL STOCK PRED</div>
    </div>

</div>
</div>


<!--  draw char script start -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById("STOCK_PRED")
    var myLineChart = new Chart(ctx, 
    {
    type: 'line',
    data: {
        labels: <?php echo $date_KOSPI; ?>,
        datasets: [{
        label: "KOSPI",
        lineTension: 0.3,
        backgroundColor: "rgba(2,117,216,0.2)",
        borderColor: "rgba(2,117,216,1)",
        pointRadius: 5,
        pointBackgroundColor: "rgba(2,117,216,1)",
        pointBorderColor: "rgba(255,255,255,0.8)",
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(2,117,216,1)",
        pointHitRadius: 50,
        pointBorderWidth: 2,
        data: <?php echo $value_KOSPI; ?>,
        }, {
        label: "NASDAQ",
        lineTension: 0.3,
        backgroundColor: "rgba(2,117,216,0.2)",
        borderColor: "rgba(2,117,216,1)",
        pointRadius: 5,
        pointBackgroundColor: "rgba(2,117,216,1)",
        pointBorderColor: "rgba(255,255,255,0.8)",
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(2,117,216,1)",
        pointHitRadius: 50,
        pointBorderWidth: 2,
        data: <?php echo $value_NASDAQ; ?>,
        }

        ],
    },
    options: {
        scales: {
        xAxes: [{
            time: {
            unit: 'date'
            },
            gridLines: {
            display: false
            },
            ticks: {
            maxTicksLimit: 7
            }
        }],
        yAxes: [{
            ticks: {
            min: 0,
            max: 40000,
            maxTicksLimit: 50
            },
            gridLines: {
            color: "rgba(0, 0, 0, .125)",
            }
        }],
        },
        legend: {
        display: false
        }
    }
}
);
</script>
<!-- draw chart script end -->

<!-- calendar datepicker script start -->
<script type="text/javascript">
$(function () { 
    $('#datetimepicker1').datetimepicker({ format: 'YYYY-MM-DD'});
    $('#datetimepicker2').datetimepicker({ format: 'YYYY-MM-DD', useCurrent: false });
    $("#datetimepicker1").on("change.datetimepicker", function (e) {
        $('#datetimepicker2').datetimepicker('minDate', e.date);
        });
    $("#datetimepicker2").on("change.datetimepicker", function (e) {
        $('#datetimepicker1').datetimepicker('maxDate', e.date);
        });
    }); 
</script>
<!-- calendar datepicker script end -->

<!--<script src="assets/demo/chart-area-demo.php"></script>-->


<?php require_once("footer.php")?>