<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> TP </title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<?php include ('databaseco.php')?>

<?php
// Supprimer un TP
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id_tp = $_GET['id'];
    $req1 = $conn->prepare('DELETE FROM promotions_tp WHERE id_tp = :id_tp');
    $req1->execute([':id_tp' => $id_tp]);
    $req2 = $conn->prepare('DELETE FROM tp WHERE id_tp = :id_tp');
    $req2->execute([':id_tp' => $id_tp]);
    header('Location: createtp.php');
    exit();
}

// Modifier un TP
if (isset($_POST['action']) && $_POST['action'] == 'modifier') {
    $id_tp       = $_POST['id_tp'];
    $name_tp     = $_POST['name_tp'];
    $description = $_POST['description'];
    $req = $conn->prepare('UPDATE tp SET name_tp = :name_tp, description = :description WHERE id_tp = :id_tp');
    $req->execute([':name_tp' => $name_tp, ':description' => $description, ':id_tp' => $id_tp]);
    header('Location: createtp.php');
    exit();
}
?>

<body>
<div id="wrapper">
<?php include ('navbar.php')?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
<?php include ('topbar.php')?>
            <div class="container-fluid">

<!-- Modal Créer -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Informations</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="data_tp.php" method="POST" id="formTP">
          <div class="row g-2">
            <div class="col-md">
              <div class="input-group mb-3">
                <span class="input-group-text">Titre :</span>
                <input type="text" name="name_tp" class="form-control">
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Description :</span>
                <input type="text" name="description" class="form-control">
              </div>
            </div>
            <div class="li-md">
              <select class="form-select" name="id_classe" required>
                <option value="" disabled selected> Choisir une classe </option>
                <option value="1">SIO 1 INI</option>
                <option value="2">SIO 2 INI</option>
                <option value="3">SIO 1 ALT</option>
                <option value="4">SIO 2 ALT</option>
                <option value="5">Licence</option>
              </select>
              <div class="input-group mb-3 mt-3">
    <span class="input-group-text">Date début :</span>
    <input type="date" name="beginning_date" class="form-control" required>
</div>

<div class="input-group mb-3">
    <span class="input-group-text">Date fin :</span>
    <input type="date" name="ending_date" class="form-control" required>
</div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="btnSauvegarder">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<h1 class="h3 mb-2 text-gray-800">TP</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Description</th>
                        <th scope="col">Classe</th>
                        <th scope="col">Durée</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $requete = $conn->prepare('SELECT tp.*, promotions.name_promo, promotions_tp.beginning_date, promotions_tp.ending_date 
                                           FROM tp 
                                           INNER JOIN promotions_tp ON tp.id_tp = promotions_tp.id_tp 
                                           INNER JOIN promotions ON promotions_tp.id_promotions = promotions.id_promotions
                                           ORDER BY tp.id_tp ASC');
                $requete->execute();
                $resultats = $requete->fetchAll();

                foreach ($resultats as $tp) { ?>
                    <tr>
                        <td><?php echo $tp['id_tp']; ?></td>
                        <td><?php echo $tp['name_tp']; ?></td>
                        <td><?php echo $tp['description']; ?></td>
                        <td><?php echo $tp['name_promo']; ?></td>
                        <td>
                            <?php
                            if (!empty($tp['beginning_date']) && !empty($tp['ending_date'])) {
                                $debut = new DateTime($tp['beginning_date']);
                                $fin   = new DateTime($tp['ending_date']);
                                $duree = $debut->diff($fin);
                                echo $duree->days . " jour(s)";
                            } else {
                                echo "Non définie";
                            }
                            ?>
                        </td>
                        <td>
                            <a href="createtp.php?action=delete&id=<?php echo $tp['id_tp']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Voulez-vous vraiment supprimer ce TP ?')">
                                Supprimer
                            </a>
                            <button type="button" class="btn btn-warning btn-sm" 
                                    data-toggle="modal" 
                                    data-target="#modalModifier<?php echo $tp['id_tp']; ?>">
                                Modifier
                            </button>
                            <!-- Modal Modifier -->
                            <div class="modal fade" id="modalModifier<?php echo $tp['id_tp']; ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modifier le TP</h5>
                                        </div>
                                        <form action="createtp.php" method="POST">
                                            <input type="hidden" name="action" value="modifier">
                                            <input type="hidden" name="id_tp" value="<?php echo $tp['id_tp']; ?>">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Titre</label>
                                                    <input type="text" name="name_tp" class="form-control" 
                                                           value="<?php echo $tp['name_tp']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <input type="text" name="description" class="form-control" 
                                                           value="<?php echo $tp['description']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-warning">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Créer un nouveau TP
            </button>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ready to Leave?</h5>
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

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="js/demo/datatables-demo.js"></script>

<script>
document.getElementById('btnSauvegarder').addEventListener('click', function() {
    var name_tp     = document.querySelector('input[name="name_tp"]').value;
    var description = document.querySelector('input[name="description"]').value;
    var id_classe   = document.querySelector('select[name="id_classe"]').value;

    if (name_tp === '' || description === '' || id_classe === '') {
        alert('Veuillez remplir tous les champs !');
        return;
    }

    document.getElementById('formTP').submit();
});
</script>

</body>
</html>