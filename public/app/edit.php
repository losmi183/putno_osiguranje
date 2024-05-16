<?php

include_once 'Models/NosiociOsiguranja.php';
include_once 'Models/DodatnaLica.php';

// Provera da li je prosleđen ID
if (!isset($_GET['id'])) {
    // Vrati odgovor da ne postoji ID
    echo json_encode(['success' => false, 'message' => 'Nije prosleđen ID.']);
    exit;
}

// Dobijanje ID-a iz GET parametra
$id = $_GET['id'];

// Kreiramo model
$nosiociOsiguranja = new NosiociOsiguranja;
$nosilac_osiguranja = $nosiociOsiguranja->get($id);

// Provera da li postoji nosilac osiguranja sa datim ID-om
if (!$nosilac_osiguranja) {
    // Vrati odgovor da ne postoji nosilac osiguranja sa datim ID-om
    echo json_encode(['success' => false, 'message' => 'Nosioc osiguranja nije pronađen za dati ID.']);
    exit;
}


// Kreiramo objekat / model DodatnaLica 
$dodatnaLica = new DodatnaLica();
$dodatna_lica = $dodatnaLica->get($id);

// Dodavanje dodatnih lica u nosioca osiguranja
$nosilac_osiguranja['dodatna_lica'] = $dodatna_lica;

// Vraćanje JSON odgovora na front
echo json_encode(['success' => true, 'nosilac_osiguranja' => $nosilac_osiguranja]);
