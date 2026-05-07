<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "vozea2";
$conn = null;
try {
    $conn = new PDO("mysql:host=$servername;port=3306;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['name_tp'])) {
        $name_tp         = $_POST['name_tp'];
        $description     = $_POST['description'];
        $id_promotion    = $_POST['id_classe'];
        $beginning_date  = $_POST['beginning_date'];
        $ending_date     = $_POST['ending_date'];

        // Insertion du TP
        $req = $conn->prepare(
            'INSERT INTO tp (name_tp, description) VALUES (:name_tp, :description)'
        );
        $req->execute([
            ':name_tp'     => $name_tp,
            ':description' => $description,
        ]);

        $id_tp = $conn->lastInsertId();

        // Insertion dans promotions_tp avec les dates
        $req2 = $conn->prepare(
            'INSERT INTO promotions_tp (id_promotions, id_tp, beginning_date, ending_date) 
             VALUES (:id_promotions, :id_tp, :beginning_date, :ending_date)'
        );
        $req2->execute([
            ':id_promotions'  => $id_promotion,
            ':id_tp'          => $id_tp,
            ':beginning_date' => $beginning_date,
            ':ending_date'    => $ending_date,
        ]);

        header('Location: createtp.php');
        exit();
    }
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>