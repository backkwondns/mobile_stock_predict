<?php 
require_once("/var/www/html/header.php");
require_once("/var/www/html/mongo_conn.php");
$real = new stock();
$res = $real->get_real_Stock($_GET["category"]);
$stock_name = str_replace("_", " ", $_GET["category"]);
$stock_code = $real->stock_code_array[$stock_name];

?>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?php echo $stock_name." Real Data" ?></h1>
                <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><?php echo $stock_code?></li>
                </ol>  
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    <?php echo $stock_name." / ".$stock_code?>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Open</th>
                                <th>High</th>
                                <th>Low</th>
                                <th>Close</th>
                                <th>Volume</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Open</th>
                                <th>High</th>
                                <th>Low</th>
                                <th>Close</th>
                                <th>Volume</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach($res as $row){
                            echo "<tr>";
                            echo "<td>".$row->Date->toDateTime()->format('Y-m-d')."</td>";
                            echo "<td>".$row->Open."</td>";
                            echo "<td>".$row->High."</td>";
                            echo "<td>".$row->Low."</td>";
                            echo "<td>".$row->Close."</td>";
                            echo "<td>".$row->Volume."</td>";
                            echo "</tr>";
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

<?php require_once("footer.php")?>