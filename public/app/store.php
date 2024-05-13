<?php

include_once 'db.php';

// Provera da li je zahtev HTTP POST metodom
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Čitanje JSON payload-a iz HTTP zahteva
    $json_payload = file_get_contents('php://input');

    // Dekodiranje JSON podataka u PHP asocijativni niz
    $data = json_decode($json_payload, true);

    // Provera da li je dekodiranje uspelo
    if ($data === null) {
        // Greška u dekodiranju JSON-a
        echo json_encode(['success' => false, 'message' => 'Greška prilikom dekodiranja JSON-a.']);
        exit;
    }

    // 2. Validacija 
    // Obavezna polja
    $required = ['ime_prezime', 'datum_rodjenja', 'broj_pasosa', 'email', 'datum_putovanja_od', 'datum_putovanja_do'];
    foreach ($required as $field) {
        // Provera da li polje postoji i da li je prazno
        if (!isset($data[$field]) || empty($data[$field])) {
            $greske[] = ['input' => $field, 'poruka' => 'Polje ' . $field . ' ne sme biti prazno.'];
        }
    }
    // Ako postoje greške, vraćamo odgovor sa greškama
    if (!empty($greske)) {
        echo json_encode(['success' => false, 'errors' => $greske]);
        exit;
    }


    // 3 Objekat konekcije i kreiranje konekcije ka bazi
    $db = new DB();
    $conn = $db->getConnection();

    try {
        // Priprema SQL upita sa PDO prepared statement
        $stmt = $conn->prepare("INSERT INTO nosioci_osiguranja (ime_prezime, datum_rodjenja, broj_pasosa, telefon, email, datum_putovanja_od, datum_putovanja_do, vrsta_polise) 
                                VALUES (:ime_prezime, :datum_rodjenja, :broj_pasosa, :telefon, :email, :datum_putovanja_od, :datum_putovanja_do, :vrsta_polise)");

        // Bindovanje vrednosti parametara sa odgovarajućim ključevima u nizu podataka
        $stmt->bindParam(':ime_prezime', $data['ime_prezime']);
        $stmt->bindParam(':datum_rodjenja', $data['datum_rodjenja']);
        $stmt->bindParam(':broj_pasosa', $data['broj_pasosa']);
        $stmt->bindParam(':telefon', $data['telefon']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':datum_putovanja_od', $data['datum_putovanja_od']);
        $stmt->bindParam(':datum_putovanja_do', $data['datum_putovanja_do']);
        $stmt->bindParam(':vrsta_polise', $data['vrsta_polise']);

        // Izvršavanje prepared statementa
        $stmt->execute();

        // Vraćanje uspešnog odgovora na front-end
        echo json_encode(['success' => true, 'message' => 'Podaci uspešno upisani u bazu.']);

    } catch (PDOException $e) {
        // Uhvatanje grešaka koje se mogu pojaviti tokom upisa u bazu
        echo json_encode(['success' => false, 'message' => 'Došlo je do greške prilikom upisa u bazu podataka: ' . $e->getMessage()]);
    }

} else {
    // Zahtev nije HTTP POST, vraćamo grešku
    echo json_encode(['success' => false, 'message' => 'Ovaj endpoint podržava samo POST zahteve.']);
}
