<?php

include_once 'db.php';

$db = new DB();
$conn = $db->getConnection();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$perPage = isset($_GET['perPage']) && is_numeric($_GET['perPage']) ? $_GET['perPage'] : 5;

$start = ($page - 1) * $perPage;

$sql = "SELECT * FROM movies LIMIT $start, $perPage";
$result = $conn->query($sql);

if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['title']}</td>";
        echo "<td>{$row['release_year']}</td>";
        echo "<td>{$row['description']}</td>";
        echo "<td>{$row['image_path']}</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No movies found</td></tr>";
}

$conn = null; // Zatvaranje veze sa bazom podataka

?>