<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $db_path = __DIR__ . '/contact_messages.db';
        $db = new PDO("sqlite:" . $db_path);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Priprema SQL upita
        $stmt = $db->prepare("INSERT INTO contact_messages (first_name, last_name, email, country, message, created_at) 
                              VALUES (:first_name, :last_name, :email, :country, :message, datetime('now'))");

        $stmt->bindParam(':first_name', $_POST["first-name"]);
        $stmt->bindParam(':last_name', $_POST["last-name"]);
        $stmt->bindParam(':email', $_POST["email"]);
        $stmt->bindParam(':country', $_POST["country"]);
        $stmt->bindParam(':message', $_POST["message"]);

        // Izvrši upit i preusmjeri ako je uspješno
        if ($stmt->execute()) {
            header("Location: thank_you.php");
            exit();
        } else {
            echo "Greška pri slanju poruke.";
        }

    } catch (PDOException $e) {
        die(" Greška pri povezivanju s bazom: " . $e->getMessage());
    }
}
?>

