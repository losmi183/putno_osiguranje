<?php

class DodatnaLica {
    private $db;
    private $conn;
    private $table = 'dodatna_lica';    

    public function __construct() {
        $this->db = new DB();
        $this->conn = $this->db->getConnection();
    }

    /**
     * store - upisuje u dodatna_lica tabelu
     * @param array $data
     * @param int $id - id od nosioci_osiguranja za koji vezujemo dodatno lice
     * 
     * @return int|null
     */
    public function store(array $data, int $id): ?int 
    {
        // Priprema SQL upita sa PDO prepared statement
        $stmt = $this->conn->prepare("INSERT INTO $this->table (nosilac_osiguranja_id, ime_prezime, datum_rodjenja, broj_pasosa) 
        VALUES (:nosilac_osiguranja_id, :ime_prezime, :datum_rodjenja, :broj_pasosa)");

        // Bindovanje vrednosti parametara sa odgovarajućim ključevima u nizu podataka
        $stmt->bindParam(':nosilac_osiguranja_id', $id);
        $stmt->bindParam(':ime_prezime', $data['ime_prezime']);
        $stmt->bindParam(':datum_rodjenja', $data['datum_rodjenja']);
        $stmt->bindParam(':broj_pasosa', $data['broj_pasosa']);

        // Izvršavanje prepared statementa
        $stmt->execute();

        // Vraća ID poslednjeg dodatog reda
        return intval($this->conn->lastInsertId()); 
    }

    public function delete($id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE nosilac_osiguranja_id = :nosilac_osiguranja_id");
        $stmt->bindParam(':nosilac_osiguranja_id', $data['id']);
        $stmt->execute();
        return true;
    }
}