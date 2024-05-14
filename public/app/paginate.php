<?php

include_once 'db.php';

// 1. Objekat konekcije i kreiranje konekcije ka bazi
$db = new DB();
$conn = $db->getConnection();

// 2. Parametri paginacije
$start = isset($_GET['start']) && is_numeric($_GET['start']) ? $_GET['start'] : 0; // Broj zapisa po stranici
$length = isset($_GET['length']) && is_numeric($_GET['length']) ? $_GET['length'] : 5; // Broj zapisa po stranici
if($length == -1) {
    $length = 10000;
}


// 3.1 Ukupan broj redova - total
$sqlTotal = "SELECT COUNT(*) AS total FROM nosioci_osiguranja";
$stmtTotal = $conn->query($sqlTotal);
$totalData = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

// 3.2 Izvlačenje podataka sa straničenjem
/**
 * 3.2 Izvlačenje podataka sa straničenjem
 * Obzirom da jedan nosioci_osiguranja može imati više dodatna_lica, 
 * upotrebljen je GROUP_CONCAT kako bi na nivou baze u jedno polje sabrali sva polja iz dodatna_lica kao string
 * Ovim je sve svedeno na 1 poziv ka bazi i izbegnut N+1 problem
 */
$sql = "
    SELECT 
        n.*, 
        GROUP_CONCAT(CONCAT('Ime i prezime: ', d.ime_prezime, ', datum rodjenja: ', d.datum_rodjenja, ', br pasosa: ', d.broj_pasosa) SEPARATOR '\n') AS dodatna_lica 
    FROM nosioci_osiguranja AS n
    LEFT JOIN dodatna_lica AS d ON n.id = d.nosilac_osiguranja_id
    GROUP BY n.id
    ORDER BY n.id 
    LIMIT $length 
    OFFSET $start
";
$stmt = $conn->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prolazimo kroz redove i pretvaramo string dodatna_lica u niz
// Potrebno je da $row označimo kao referencu da bi mogli da menjamo vrednost
foreach($data as &$row) {
    if($row['dodatna_lica'] && $row['dodatna_lica'] != '') {
        $row['dodatna_lica'] = explode("\n", $row['dodatna_lica']);
    }
} 

$response = array(
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalData),
    'data' => $data
);

header('Content-Type: application/json');
echo json_encode($response);

$conn = null; // Zatvaranje veze sa bazom podataka