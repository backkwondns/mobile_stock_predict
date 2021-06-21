<?php 
require_once("header.php");
require_once("/var/www/html/mongo_conn.php");

$pred = new stock();
$stock_name = str_replace("_", " ", substr($_GET["category"], 0, -5));
$stock_code = $pred->stock_code_array[$stock_name];

if (isset($_POST["startdate"])){
    $res = $pred->get_Stock($_POST["startdate"], $_POST["enddate"], $_GET["category"]);
    $date = json_encode($res["Date"], true);
    $value = json_encode($res["values"], true);
}else{
    $res = $pred->get_Stock_default($_GET["category"]);
    $_POST["startdate"] = $res["Date"][0];
    $_POST["enddate"] = end($res["Date"]);
    $date = json_encode($res["Date"], true);
    $value = json_encode($res["values"], true);
}
?>

    <div class="container-fluid px-4">
    <h1 class="mt-4"><?php echo $stock_name?></h1>
    <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active"><?php echo $stock_code?></li>
    </ol>

    <form action="<?php echo htmlentities($_SERVER['PHP_SELF'].'?category='.$_GET["category"]); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="category" value=<?php echo $stock_name?>>
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
        <div class="card-footer small text-muted"><?php echo $stock_name?> PRED</div>
    </div>

</div>
</div>

<!--  draw char script start -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
    var ctx = document.getElementById("STOCK_PRED").getContext('2d');
    var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo $date; ?>,
        datasets: [{
        label: '<?php echo $stock_name?>',
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
        data: <?php echo $value; ?>,
        }],
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
            //min: 0,
            //max: 40000,
            maxTicksLimit: 5
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
});
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