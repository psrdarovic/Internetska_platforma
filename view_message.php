<?php
$db_path = __DIR__ . '/contact_messages.db';

try {
    $db = new PDO("sqlite:" . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
    $stmt = $db->query($query);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Saved Messages:</h2>";
    foreach ($messages as $row) {
        echo "<p><strong>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . 
             " (" . htmlspecialchars($row['email']) . ")</strong><br>";
        echo "From: " . htmlspecialchars($row['country']) . "<br>";
        echo "Message: " . nl2br(htmlspecialchars($row['message'])) . "<br>";
        echo "<small>Sent at: " . $row['created_at'] . "</small>";
        echo "<hr></p>";
    }
} catch (PDOException $e) {
    die("Greška pri dohvaćanju podataka: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled Poruka</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#1e1e1e;
            margin: 20px;
            padding: 20px;
        }
        p{
            color:#fff;
        }
        h2 {
            text-align: center;
            color:rgb(73, 73, 73);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background:rgb(255, 255, 255);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color:rgb(73, 73, 73);
            color: white;
        }
        tr:hover {
            background-color:rgb(129, 129, 129);
        }
        .message-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(248, 248, 248, 0.34);
        }
    </style>
</head>
<body>

<div class="message-container">
    <h2>Primljene Poruke</h2>
    <table>
        <tr>
            <th>Ime i Prezime</th>
            <th>E-mail</th>
            <th>Država</th>
            <th>Poruka</th>
            <th>Vrijeme slanja</th>
        </tr>
        <?php foreach ($messages as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['country']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>