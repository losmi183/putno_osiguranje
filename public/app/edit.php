<?php

include_once 'db.php';

// Provera da li je prosleđen ID
if (!isset($_GET['id'])) {
    // Vrati odgovor da ne postoji ID
    echo json_encode(['success' => false, 'message' => 'Nije prosleđen ID.']);
    exit;
}

    // 3 Objekat konekcije i kreiranje konekcije ka bazi 
    $db = new DB();
    $conn = $db->getConnection();

// Dobijanje ID-a iz GET parametra
$id = $_GET['id'];

// Priprema SQL upita za dohvatanje nosioca osiguranja
$sql_nosioc = "SELECT * FROM nosioci_osiguranja WHERE id = :id";
$stmt_nosioc = $conn->prepare($sql_nosioc);
$stmt_nosioc->bindParam(':id', $id);
$stmt_nosioc->execute();
$nosilac_osiguranja = $stmt_nosioc->fetch(PDO::FETCH_ASSOC);

// Provera da li postoji nosilac osiguranja sa datim ID-om
if (!$nosilac_osiguranja) {
    // Vrati odgovor da ne postoji nosilac osiguranja sa datim ID-om
    echo json_encode(['success' => false, 'message' => 'Nosioc osiguranja nije pronađen za dati ID.']);
    exit;
}

// Priprema SQL upita za dohvatanje dodatnih lica
$sql_dodatna_lica = "SELECT * FROM dodatna_lica WHERE nosilac_osiguranja_id = :id";
$stmt_dodatna_lica = $conn->prepare($sql_dodatna_lica);
$stmt_dodatna_lica->bindParam(':id', $id);
$stmt_dodatna_lica->execute();
$dodatna_lica = $stmt_dodatna_lica->fetchAll(PDO::FETCH_ASSOC);

// Dodavanje dodatnih lica u nosioca osiguranja
$nosilac_osiguranja['dodatna_lica'] = $dodatna_lica;

// Vraćanje JSON odgovora na front
echo json_encode(['success' => true, 'nosilac_osiguranja' => $nosilac_osiguranja]);
