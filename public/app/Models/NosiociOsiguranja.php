<?php

include_once 'db.php';

class NosiociOsiguranja {

    private $db;
    private $conn;
    private $table = 'nosioci_osiguranja';

    public function __construct() {
        $this->db = new DB();
        $this->conn = $this->db->getConnection();
    }

    /**
     * @param mixed $id
     * 
     * @return array
     */
    public function get($id): array
    {
        $sql_nosioc = "SELECT * FROM $this->table WHERE id = :id";
        $stmt_nosioc = $this->conn->prepare($sql_nosioc);
        $stmt_nosioc->bindParam(':id', $id);
        $stmt_nosioc->execute();
        return $stmt_nosioc->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * store -  
     * @param array $data
     * 
     * @return int
     */
    public function store(array $data): ?int 
    {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (ime_prezime, datum_rodjenja, broj_pasosa, telefon, email, datum_putovanja_od, datum_putovanja_do, vrsta_polise) 
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

        // Vraća ID poslednjeg dodatog reda
        return intval($this->conn->lastInsertId());        
    }

    /**
     * update - izmene na nosioci_osiguranja
     * @param array $data
     * 
     * @return bool
     */
    public function update(array $data): bool
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET ime_prezime = :ime_prezime, datum_rodjenja = :datum_rodjenja, broj_pasosa = :broj_pasosa, telefon = :telefon, email = :email, datum_putovanja_od = :datum_putovanja_od, datum_putovanja_do = :datum_putovanja_do, vrsta_polise = :vrsta_polise WHERE id = :id");

        // Bindovanje vrednosti parametara sa odgovarajućim ključevima u nizu podataka
        $stmt->bindParam(':ime_prezime', $data['ime_prezime']);
        $stmt->bindParam(':datum_rodjenja', $data['datum_rodjenja']);
        $stmt->bindParam(':broj_pasosa', $data['broj_pasosa']);
        $stmt->bindParam(':telefon', $data['telefon']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':datum_putovanja_od', $data['datum_putovanja_od']);
        $stmt->bindParam(':datum_putovanja_do', $data['datum_putovanja_do']);
        $stmt->bindParam(':vrsta_polise', $data['vrsta_polise']);
        $stmt->bindParam(':id', $data['id']);

        // Izvršavanje prepared statementa
        $stmt->execute();
        return true;
    }

    /**
     * @param mixed $id
     * 
     * @return bool
     */
    public function delete($id): bool
    {
        try {
            $sql = "DELETE FROM $this->table WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return true;

    }
}