<?php

include_once 'Models/NosiociOsiguranja.php';
include_once 'Models/DodatnaLica.php';

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
            $greske[] = ['inputId' => $field, 'message' => 'Polje ' . $field . ' ne sme biti prazno.'];
        }
    }

    // 2.2 Dodatni osiguranici - prikupljaju se greške u posebnu promenjivu kao string
    // Format povratne poruke je drugačiji i moguće ga je prikazati u alertu
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

    try {
        /**
         * 3.1 Upis glavnog osiguranika u bazu
         */
         // Kreiramo objekat / model NosiociOsiguranja
        $nosiociOsiguranja = new NosiociOsiguranja;
        try {
            $lastInsertedId = $nosiociOsiguranja->store($data);  
        } catch (PDOException $e) {
            // Hvatanje grešaka koje se mogu pojaviti tokom upisa u bazu
            $greske[] = 'Došlo je do greške prilikom upisa nosioca osiguranja: ';
        }
        

        /**
         * 3.2 Upis u bazu dodatnih osiguranika ako su poslati 
         */
        if (isset($data['dodatniOsiguranici']) && is_array($data['dodatniOsiguranici']) && count($data['dodatniOsiguranici']) > 0) {
            // Kreiramo objekat / model DodatnaLica 
            $dodatnaLica = new DodatnaLica();
            foreach ($data['dodatniOsiguranici'] as $osiguranik) {
                try {
                    $dodatnaLica->store($data, $lastInsertedId);   
                } catch (PDOException $e) {
                    // Hvatanje grešaka koje se mogu pojaviti tokom upisa u bazu
                    $greske[] = 'Došlo je do greške prilikom upisa dodatnog osiguranika: ';
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
