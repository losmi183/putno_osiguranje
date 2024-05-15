<?php

include_once 'db.php';

// Provera da li je zahtev HTTP POST metodom
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Čitanje JSON payload-a iz HTTP zahteva i dekodiranje JSON podataka u PHP asocijativni niz
    $json_payload = file_get_contents('php://input');
    $data = json_decode($json_payload, true);
    // Provera da li je dekodiranje uspelo
    if ($data === null) {
        echo json_encode(['success' => false, 'message' => 'Greška prilikom dekodiranja JSON-a.']);
        exit;
    }

    // 1. Objekat konekcije i kreiranje konekcije ka bazi 
    $db = new DB();
    $conn = $db->getConnection();
    

    // 2. Brisanje reda iz tabele nosioci_osiguranja gde je id = data['id']
    $sql = "DELETE FROM nosioci_osiguranja WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $data['id'], PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Uspesno obrisan unos.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Greška prilikom brisanja unosa.']);
    }
}