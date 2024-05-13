<?php

include_once 'db.php';

$db = new DB();
$conn = $db->getConnection();
$start = isset($_GET['start']) && is_numeric($_GET['start']) ? $_GET['start'] : 0; // Broj zapisa po stranici
$length = isset($_GET['length']) && is_numeric($_GET['length']) ? $_GET['length'] : 5; // Broj zapisa po stranici
if($length == -1) {
    $length = 10000;
}


// Ukupan broj filmova
$sqlTotal = "SELECT COUNT(*) AS total FROM movies";
$stmtTotal = $conn->query($sqlTotal);
$totalMovies = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

// Izvlačenje podataka sa straničenjem
$sql = "SELECT * FROM movies ORDER BY id LIMIT $length OFFSET $start";
$stmt = $conn->query($sql);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = array(
    "recordsTotal" => intval($totalMovies),
    "recordsFiltered" => intval($totalMovies),
    'data' => $movies
);

header('Content-Type: application/json');
echo json_encode($response);

$conn = null; // Zatvaranje veze sa bazom podataka