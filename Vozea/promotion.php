<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> promotions </title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>
<?php include ('data.php')?>
<body>
   <!-- Page Wrapper -->
    <div id="wrapper">
<?php include ('navbar.php')?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
<?php include ('topbar.php')?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
<!-- CSS -->
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form action="data.php" method="POST">

        <div class="modal-header">
          <h5 class="modal-title">Informations</h5>

          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <div class="row g-2">

            <div class="col-md-12">

              <select class="form-select"
                      id="name_promo"
                      name="name_promo"
                      required>

                <option selected disabled>
                  Promotions :
                </option>

                <option value="SIO 1 INI">SIO 1 INI</option>
                <option value="SIO 2 INI">SIO 2 INI</option>
                <option value="SIO 1 ALT">SIO 1 ALT</option>
                <option value="SIO 2 ALT">SIO 2 ALT</option>
                <option value="Licence">Licence</option>

              </select>

            </div>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal">
              Annuler
          </button>

          <button id="valider"
                  name="ajouter"
                  type="submit"
                  class="btn btn-primary">
              Valider
          </button>

        </div>

      </form>

    </div>
  </div>
</div>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 "> Promotions </h1>
                    <p class="mb-4"> <a target="_blank"></p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                            
                                <table class="table" id="table">
  <thead>
    <tr>
      <th scope="col">Promotions : </th>
      <th scope="col"> Eleves </th>
      <th scope="col"> Classe </th>
      <th scope="col"> Action</th>
    </tr>
  </thead>
  <tbody>
  <?php
// Récupération des promotions
$stmt = $conn->query("SELECT id_promotion, name_promo FROM PROMOTIONS");
$promotions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$i = 1;

foreach ($promotions as $promo) { ?>
    
<tr>
    <th scope="row"><?= $i++ ?></th>

    <td><?= $promo['id_promotion'] ?></td>

    <td><?= htmlspecialchars($promo['name_promo']) ?></td>

    <td>

        <button 
            onclick="ouvrirModifier(
                <?= $promo['id_promotion'] ?>,
                '<?= htmlspecialchars($promo['name_promo'], ENT_QUOTES) ?>'
            )"
            class="btn btn-warning btn-sm">
            Modifier
        </button>

        <a href="promotion.php?delete=<?= $promo['id_promotion']?>"
           onclick="return confirm('Supprimer cette promotion ?')"
           class="btn btn-danger btn-sm">
           Supprimer
        </a>
    </td>
</tr>

<?php } ?>
  </tbody>
</table>
                
             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">
  Ajouter une promotion
</button>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
            
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    
         <script src="/Final-Vozea/Vozea/myscript2.js"></script>
</body>

</html>