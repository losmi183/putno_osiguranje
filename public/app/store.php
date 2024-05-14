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

    // 2. Validacija 
    // Obavezna polja 
    $required = ['ime_prezime', 'datum_rodjenja', 'broj_pasosa', 'email', 'datum_putovanja_od', 'datum_putovanja_do'];
    foreach ($required as $field) {
        // 2.1 Glavni korisnik - Provera da li polje postoji i da li je prazno 
        if (!isset($data[$field]) || empty($data[$field])) {
            $greske[] = ['input' => $field, 'poruka' => 'Polje ' . $field . ' ne sme biti prazno.'];
        }
    }

    // 2.2 Dodatni osiguranici - prikupljaju se greške u posebnu promenjivu kao string
    // Potrebno je dovršiti slanje i prikaz na frontu za ove greške
    if (isset($data['dodatniOsiguranici']) && is_array($data['dodatniOsiguranici']) && count($data['dodatniOsiguranici']) > 0) {
        $greske2 = '';
        foreach ($data['dodatniOsiguranici'] as $key => $osiguranik) {
            foreach($osiguranik as $naziv => $vrednost) {
                if (!isset($polje) || empty($polje)) {
                    $rbr = $key + 1;
                    $greske2 .= $rbr . '. osiguranik, polje ' . $field . ' ne sme biti prazno. ';
                }
            }
        }
    }

    // 2.3 Ako postoje greške, vraćamo odgovor sa greškama
    if (!empty($greske)) {        
        echo json_encode(['success' => false, 'errors' => $greske]);
        exit;
    }

    // 3 Objekat konekcije i kreiranje konekcije ka bazi 
    $db = new DB();
    $conn = $db->getConnection();

    try {
        /**
         * 3.1 Upis glavnog osiguranika u bazu
         */
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

        // Dobijanje ID poslednjeg dodatog reda
        $lastInsertedId = $conn->lastInsertId();

        /**
         * 3.2 Upis u bazu dodatnih osiguranika ako su poslati 
         */
        if (isset($data['dodatniOsiguranici']) && is_array($data['dodatniOsiguranici']) && count($data['dodatniOsiguranici']) > 0) {
            foreach ($data['dodatniOsiguranici'] as $osiguranik) {
                try {
                    // Priprema SQL upita sa PDO prepared statement
                    $stmt = $conn->prepare("INSERT INTO dodatna_lica (nosilac_osiguranja_id, ime_prezime, datum_rodjenja, broj_pasosa) 
                                            VALUES (:nosilac_osiguranja_id, :ime_prezime, :datum_rodjenja, :broj_pasosa)");

                    // Bindovanje vrednosti parametara sa odgovarajućim ključevima u nizu podataka
                    $stmt->bindParam(':nosilac_osiguranja_id', $lastInsertedId);
                    $stmt->bindParam(':ime_prezime', $osiguranik['ime_prezime']);
                    $stmt->bindParam(':datum_rodjenja', $osiguranik['datum_rodjenja']);
                    $stmt->bindParam(':broj_pasosa', $osiguranik['broj_pasosa']);

                    // Izvršavanje prepared statementa
                    $stmt->execute();

                } catch (PDOException $e) {
                    // Hvatanje grešaka koje se mogu pojaviti tokom upisa u bazu
                    $greske[] = ['input' => 'dodatniOsiguranici', 'poruka' => 'Došlo je do greške prilikom upisa dodatnog osiguranika: ' . $e->getMessage()];
                }
            }
        }

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
