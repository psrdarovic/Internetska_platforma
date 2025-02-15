<?php
$database = __DIR__ . "/contact_messages.db"; // Provjeri ispravnost baze!

try {
    $conn = new PDO("sqlite:" . $database);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Provjera podataka u tablici
    $query = "SELECT * FROM contact_messages";
    $stmt = $conn->query($query);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$result) {
        echo "⚠️ Tablica postoji, ali nema podataka!";
    } else {
        echo "<h2>Podaci iz tablice 'contact_messages':</h2>";
        foreach ($result as $row) {
            echo "ID: " . $row['id'] . " - Ime: " . $row['first_name'] . " " . $row['last_name'] . 
                 " - Email: " . $row['email'] . " - Poruka: " . $row['message'] . "<br>";
        }
    }
} catch (PDOException $e) {
    echo "❌ Greška pri dohvaćanju podataka: " . $e->getMessage();
}
?>
