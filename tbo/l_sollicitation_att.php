<?php
session_start();
include 'connexion.php';

?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des sollicitations</title>
    <?php include 'css.php'; ?>
</head>

<body>
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe absent -->
        <section class="mb-5">

            <!-- Card -->
            <div class="row">
                <a href="sollicitation.php" class="btn col-2 blue-gradient btn-rounded waves-effect">Ajouter +</a>
            </div>
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Liste des sollicitations en attente de traitement</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <div class="row">
                            <div class="col-4 sm-4">
                                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                    <input class="form-control form-control-sm ml-3 w-75" name="search" type="text" placeholder="Recherche" aria-label="Search">
                                </form>
                            </div>
                        </div>
                        <table class="table table-hover " id="">
                            <thead class="black ">
                                <tr>
                                    <td class="white-text">#</td>
                                    <td class="white-text">Date </td>
                                    <td class="white-text">Client / Prospect</td>
                                    <td class="white-text">Sollicitation</td>
                                    <td class="white-text">Département(s)</td>
                                    <td class="white-text">Date limite</td>
                                    <td class="white-text">Détail(s)</td>
                                    <td class="white-text">PJ</td>
                                    <td class="white-text"></td>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                            </tbody>
                        </table>
                    </div>
                    <!-- Card content -->

                </div>
            </div>
            <!-- Card -->

        </section>
        <!-- Section -->
    </div>
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>

</body>
<style type="text/css">
    body {
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #999;
    }

    table {
        font-family: "times new roman";
        font-size: "28px";
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('.mdb-select').materialSelect();

        function l_abs_remp(search) {

            var search = $('input:first').val();
            $.ajax({
                type: 'POST',
                url: 'l_sollicitation_att_ajax.php',
                data: 'search=' + search,
                success: function(html) {
                    $('tbody').html(html);
                }
            });
        }

        l_abs_remp();
        $('select').change(function() {
            l_abs_remp();
        });
        $('input:first').keyup(function() {
            l_abs_remp()
        });
    })
</script>

</html>