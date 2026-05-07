<?php

include('databaseco.php');

if (isset($_POST['ajouter'])) {

    $promo = $_POST['name_promo'];

    $stmt = $conn->prepare("
        INSERT INTO PROMOTIONS(name_promo)
        VALUES (?)
    ");

    $stmt->execute([$promo]);

    header("Location: promotion.php");
    exit();
}
    if (isset($_GET['delete'])) {

    $stmt = $conn->prepare("ON DELETE CASCADEFROM PROMOTIONS WHERE id_promotion = ?");

    $stmt->execute([$_GET['delete']]);

    header("Location: promotion.php");

    exit();

}
 ?>