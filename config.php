<?php
$servername = getenv('DATABASE_HOST');
$username = getenv('DATABASE_USER');
$password = getenv('DATABASE_PASSWORD');
$dbname = getenv('DATABASE_NAME');

try {
    $conn = new PDO("pgsql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
