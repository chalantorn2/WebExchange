<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)->withServiceAccount('path/to/your-serviceAccountKey.json');
$database = $factory->createDatabase();

try {
    $snapshot = $database->getReference('currencies')->getValue();
    echo "<pre>";
    print_r($snapshot);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
