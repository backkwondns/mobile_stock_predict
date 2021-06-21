<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>STOCK</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" />
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">STOCK PREDICT</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Summary</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                STOCK INDEX
                            </a>

                            <!-- DOMESTIC STOCK PRICE START -->
                            <div class="sb-sidenav-menu-heading">STOCK PRICE</div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDomestic" aria-expanded="true" aria-controls="collapseDomestic">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Domestic Stock
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            
                            <?php $list_domestic = array("SAMSUNG_ELECTRONICS_PRED", "SAMSUNG_SDI_PRED")?>
                            <div class="collapse <?php foreach($list_domestic as $domestic){echo (strpos($_SERVER['REQUEST_URI'], $domestic)!==false)?' show':'';}?>" id="collapseDomestic" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="Chart.php?category=SAMSUNG_ELECTRONICS_PRED">Samsung Electronics</a>
                                    <a class="nav-link" href="Chart.php?category=SAMSUNG_SDI_PRED">Samsung SDI</a>
                                </nav>
                            </div>
                            <!-- DOMESTIC STOCK PRICE END -->

                            <!-- INTERNATIONAL STOCK PRICE START -->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInternational" aria-expanded="false" aria-controls="collapseInternational">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                International Stock
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                            <?php $list_international = array("APPLE_PRED", "AMAZON_PRED")?>
                            <div class="collapse <?php foreach($list_international as $international){echo (strpos($_SERVER['REQUEST_URI'], $international)!==false)?' show':'';}?>" id="collapseInternational" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link" href="Chart.php?category=APPLE_PRED">APPLE</a>
                                    <a class="nav-link" href="Chart.php?category=AMAZON_PRED">AMAZON</a>
                                </nav>
                            </div>
                            <!-- INTERNATIONAL STOCK PRICE END -->

                            <!-- STOCK INDEX START -->
                            <div class="sb-sidenav-menu-heading">STOCK INDEX</div>
                            <a class="nav-link" href="Chart.php?category=KOSPI_PRED">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                KOSPI
                            </a>
                            <a class="nav-link" href="Chart.php?category=NASDAQ_PRED">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                NASDAQ
                            </a>
                            <!-- STOCK INDEX END -->


                            <!-- REAL DATA MENU START -->
                            <div class="sb-sidenav-menu-heading">REAL DATA TABLE</div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRealstock" aria-expanded="true" aria-controls="collapseRealstock">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                STOCK
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            
                            <?php $list_real_stock = array("SAMSUNG_ELECTRONICS", "SAMSUNG_SDI", "APPLE", "AMAZON")?>
                            <div class="collapse <?php foreach($list_real_stock as $real_stock){echo (strpos($_SERVER['REQUEST_URI'], $real_stock)!==false && strpos($_SERVER['REQUEST_URI'], "Table")!==false)?' show':'';}?>" id="collapseRealstock" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="Table.php?category=SAMSUNG_ELECTRONICS">Samsung Electronics</a>
                                    <a class="nav-link" href="Table.php?category=SAMSUNG_SDI">Samsung SDI</a>
                                    <a class="nav-link" href="Table.php?category=APPLE">APPLE</a>
                                    <a class="nav-link" href="Table.php?category=AMAZON">AMAZON</a>
                                </nav>
                            </div>


                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRealindex" aria-expanded="false" aria-controls="collapseRealindex">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                STOCK INDEX
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                            <?php $list_real_index = array("KOSPI", "NASDAQ")?>
                            <div class="collapse <?php foreach($list_real_index as $real_index){echo (strpos($_SERVER['REQUEST_URI'], $real_index)!==false && strpos($_SERVER['REQUEST_URI'], "Table")!==false)?' show':'';}?>" id="collapseRealindex" aria-labelledby="headingFour" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link" href="Table.php?category=KOSPI">KOSPI</a>
                                    <a class="nav-link" href="Table.php?category=NASDAQ">NASDAQ</a>
                                </nav>
                            </div>

                            <!-- REAL DATA MENU END -->

                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">B589003</div>
                        HAN JUN KWON
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
</html>