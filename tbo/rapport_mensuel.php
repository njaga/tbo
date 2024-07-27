<?php
session_start();
include 'connexion.php';

$req_vente_annuel = $db->query("SELECT MONTH(date_validation), SUM(montant) FROM `tache` WHERE date_validation is NOT NULL AND type_tache='Devis' GROUP BY date_validation");
$donnees_annuel = $req_vente_annuel->fetch();


$req_vente = $db->query("SELECT SUM(montant) 
FROM `tache` 
WHERE date_validation is NOT NULL  AND type_tache='Devis'");
$donnees = $req_vente->fetch();
$mnt_vente = $donnees['0'];


$req_devis = $db->prepare("SELECT SUM(montant) 
FROM `tache` 
WHERE date_validation is NULL  AND type_tache='Devis'");
$donnees = $req_devis->fetch();
$mnt_devis = $donnees['0'];

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Rapport </title>
    <?php include 'css.php'; ?>
    <!-- Your custom styles (optional) -->
    <style>

    </style>
</head>

<body class="fixed-sn white-skin">
    <?php
    include 'verif_menu.php';
    ?>
    <!-- Main layout -->
    <main>
        <div class="container-fluid">

            <!-- Section: Main panel -->
            <section class="mb-5">

                <!-- Card -->
                <div class="card card-cascade narrower">

                    <!-- Section: Chart -->
                    <section>

                        <!-- Grid row -->
                        <div class="row">

                            <!-- Grid column -->
                            <div class="col-xl-5 col-lg-12 mr-0">

                                <!-- Card image -->
                                <div class="view view-cascade gradient-card-header blue-gradient">
                                    <h2 class="h2-responsive mb-0">Tableau de bord</h2>
                                </div>
                                <!-- Card image -->

                                <!-- Card content -->
                                <div class="card-body card-body-cascade pb-0">

                                    <!-- Panel data -->
                                    <div class="row card-body pt-3">

                                        <!-- First column -->
                                        <div class="col-md-5">
                                            <!-- Date pickers -->
                                            <p class="lead mt-5"><span class="badge info-color p-2">Date(s)</span></p>
                                            <br>
                                            <div class="md-form">
                                                <input placeholder="Sélectionnez la date" type="date" id="from" class="form-control">
                                                <label for="date-picker-example">De</label>
                                            </div>
                                            <div class="md-form">
                                                <input placeholder="Sélectionnez la date" type="date" id="from" class="form-control">
                                                <label for="date-picker-example">A</label>
                                            </div>

                                        </div>
                                        <!-- First column -->

                                        <!-- Second column -->
                                        <div class="col-md-7 text-center">

                                            <!-- Summary -->
                                            <p>Ventes totales : <strong><?= number_format($mnt_vente, 0, '.', ' ') ?></strong>
                                                <button type="button" class="btn btn-info btn-sm p-2" data-toggle="tooltip" data-placement="top" title="Total sales in the given period"><i class="fas fa-question"></i></button>
                                            </p>
                                            <p>Ventes moyennes : <strong>000</strong>
                                                <button type="button" class="btn btn-info btn-sm p-2" data-toggle="tooltip" data-placement="top" title="Average daily sales in the given period"><i class="fas fa-question"></i></button>
                                            </p>

                                            <!-- Change chart -->
                                            <span class="min-chart my-4" id="chart-sales" data-percent="76"><span class="percent"></span></span>
                                            <h5>
                                                <span class="badge green p-2">Valider <i class="fas fa-arrow-circle-up ml-1"></i></span>
                                                <button type="button" class="btn btn-info btn-sm p-2" data-toggle="tooltip" data-placement="top" title="Percentage change compared to the same period in the past"><i class="fas fa-question"></i>
                                                </button>
                                            </h5>
                                        </div>
                                        <!-- Second column -->

                                    </div>
                                    <!-- Panel data -->

                                </div>
                                <!-- Card content -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-xl-7 col-lg-12 mb-4">

                                <!-- Card image -->
                                <div class="view view-cascade gradient-card-header indigo">

                                    <!-- Chart -->
                                    <canvas id="lineChart-main" height="175"></canvas>

                                </div>
                                <!-- Card image -->

                            </div>
                            <!-- Grid column -->

                        </div>
                        <!-- Grid row -->

                    </section>
                    <!-- Section: Chart -->

                </div>
                <!-- Card -->

            </section>
            <!-- Section: Main panel -->

            <!-- Section: Chart types -->
            <section>

                <!-- Grid row -->
                <div class="row mb-4">

                    <!-- Grid column -->
                    <div class="col-lg-6 col-md-12 mb-4">

                        <!-- Card -->
                        <div class="card card-cascade narrower">

                            <!-- Card image -->
                            <div class="view view-cascade gradient-card-header blue">
                                <h5 class="mb-0">Nouveau Client(s) / Prospect(s)</h5>
                            </div>
                            <!-- Card image -->

                            <!-- Card content -->
                            <div class="card-body card-body-cascade text-center">

                                <canvas id="lineChart" height="200px"></canvas>

                            </div>
                            <!-- Card content -->

                        </div>
                        <!-- Card -->

                    </div>
                    <!-- Grid column -->


                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-lg-6 col-md-6 mb-4">

                        <!-- Card -->
                        <div class="card card-cascade narrower">

                            <!-- Card image -->
                            <div class="view view-cascade gradient-card-header blue">
                                <h5 class="mb-0">Client par secteur d'activité</h5>
                            </div>
                            <!-- Card image -->

                            <!-- Card content -->
                            <div class="card-body card-body-cascade text-center">

                                <canvas id="barChart" height="200px"></canvas>

                            </div>
                            <!-- Card content -->

                        </div>
                        <!-- Card -->

                    </div>
                    <!-- Grid column -->

                </div>
                <!-- Grid row -->

                <!-- Grid row -->
                <div class="row mb-4">



                    <!-- Grid column -->
                    <div class="col-lg-6 col-md-6 mb-4">

                        <!-- Card -->
                        <div class="card card-cascade narrower">

                            <!-- Card image -->
                            <div class="view view-cascade gradient-card-header blue">
                                <h5 class="mb-0">CA des commerciaux</h5>
                            </div>
                            <!-- Card image -->

                            <!-- Card content -->
                            <div class="card-body card-body-cascade text-center">

                                <canvas id="pieChart" height="200px"></canvas>

                            </div>
                            <!-- Card content -->

                        </div>
                        <!-- Card -->

                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-lg-6 col-md-6 mb-4">

                        <!-- Card -->
                        <div class="card card-cascade narrower">

                            <!-- Card image -->
                            <div class="view view-cascade gradient-card-header blue">
                                <h5 class="mb-0">Type tâches</h5>
                            </div>
                            <!-- Card image -->

                            <!-- Card content -->
                            <div class="card-body card-body-cascade text-center">

                                <canvas id="doughnutChart" height="200px"></canvas>

                            </div>
                            <!-- Card content -->

                        </div>
                        <!-- Card -->

                    </div>
                    <!-- Grid column -->

                </div>
                <!-- Grid row -->

            </section>
            <!-- Section: Chart types -->


        </div>
    </main>
    <!-- Main layout -->

    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
    <!-- Custom scripts -->
    <script>
        // SideNav Initialization
        $(".button-collapse").sideNav();

        var container = document.querySelector('.custom-scrollbar');
        var ps = new PerfectScrollbar(container, {
            wheelSpeed: 2,
            wheelPropagation: true,
            minScrollbarLength: 20
        });

        // Data Picker Initialization
        $('.datepicker').pickadate({
            // Escape any “rule” characters with an exclamation mark (!).
            format: 'yyyy-mm-dd',
            formatSubmit: 'yyyy/mm/dd',
            hiddenPrefix: 'prefix__',
            hiddenSuffix: '__suffix'
        });
        // Material Select Initialization
        $(document).ready(function() {
            $('.mdb-select').material_select();
        });

        // Tooltips Initialization
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

    <!-- Charts -->
    <script>
        // Small chart
        $(function() {
            $('.min-chart#chart-sales').easyPieChart({
                barColor: "#4caf50",
                onStep: function(from, to, percent) {
                    $(this.el).find('.percent').text(Math.round(percent));
                }
            });
        });

        //Main chart
        var ctxL = document.getElementById("lineChart-main").getContext('2d');
        var myLineChart = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: ["Janvier", "Fébrier", "Mars", "Avril", "Mai", "Juin", "Juillet"],
                datasets: [{
                    label: "Progression des ventes",
                    fillColor: "#fff",
                    backgroundColor: 'rgba(255, 255, 255, .3)',
                    borderColor: 'rgba(255, 255, 255, .9)',
                    data: [0, 0, 0, 0, 0, 0, 0],
                }]
            },
            options: {
                legend: {
                    labels: {
                        fontColor: "#fff",
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true,
                            color: "rgba(255,255,255,.25)"
                        },
                        ticks: {
                            fontColor: "#fff",
                        },
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            display: true,
                            color: "rgba(255,255,255,.25)"
                        },
                        ticks: {
                            fontColor: "#fff",
                        },
                    }],
                }
            }
        });
    </script>

    <!-- Charts 2 -->
    <script>
        //line
        var ctxL = document.getElementById("lineChart").getContext('2d');
        var myLineChart = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: ["Janvier", "Fébrier", "Mars", "Avril", "Mai", "Juin", "Juillet"],
                datasets: [{
                        label: "Clients",
                        data: [0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: [
                            'rgba(105, 0, 132, .2)',
                        ],
                        borderColor: [
                            'rgba(200, 99, 132, .7)',
                        ],
                        borderWidth: 2
                    },
                    {
                        label: "Prospects",
                        data: [0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: [
                            'rgba(0, 137, 132, .2)',
                        ],
                        borderColor: [
                            'rgba(0, 10, 130, .7)',
                        ],
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true
            }
        });



        //bar
        var ctxB = document.getElementById("barChart").getContext('2d');
        var myBarChart = new Chart(ctxB, {
            type: 'bar',
            data: {
                labels: ["Secteur 1", "Secteur 2", "Secteur 3", "Secteur 4", "Secteur 5", "Secteur 6"],
                datasets: [{
                    label: 'Secteur',
                    data: [0, 0, 0, 0, 0, 0],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            optionss: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


        //pie
        var ctxP = document.getElementById("pieChart").getContext('2d');
        var myPieChart = new Chart(ctxP, {
            type: 'pie',
            data: {
                labels: ["Com 1", "Com 2", "Com 3", "Com 4", "Com 5"],
                datasets: [{
                    data: [0, 0, 0, 0, 0],
                    backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
                }]
            },
            options: {
                responsive: true
            }
        });

        //doughnut
        var ctxD = document.getElementById("doughnutChart").getContext('2d');
        var myLineChart = new Chart(ctxD, {
            type: 'doughnut',
            data: {
                labels: ["Email", "Devis", "Call", "Relance", "Facture"],
                datasets: [{
                    data: [0, 0, 0, 0, 0],
                    backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>

</html>