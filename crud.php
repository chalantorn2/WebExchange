<?php
include 'config.php';

if (isset($_POST['add'])) {
    $country_name = $_POST['country_name'];
    $denomination = $_POST['denomination'];
    $buying = $_POST['buying'];
    $currency_image = $_FILES['currency_image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["currency_image"]["name"]);

    if (move_uploaded_file($_FILES["currency_image"]["tmp_name"], $target_file)) {
        $database->getReference('currencies')->push([
            'currency_image' => $currency_image,
            'country_name' => $country_name,
            'denomination' => $denomination,
            'buying' => $buying,
            'display_order' => (int)$_POST['display_order']
        ]);
        header("Location: index.php");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

if (isset($_POST['update_all'])) {
    $ids = $_POST['id'];
    $country_names = $_POST['country_name'];
    $denominations = $_POST['denomination'];
    $buyings = $_POST['buying'];
    $display_orders = $_POST['display_order'];
    $currency_images = $_FILES['currency_image'];

    foreach ($ids as $id) {
        $country_name = $country_names[$id];
        $denomination = $denominations[$id];
        $buying = $buyings[$id];
        $display_order = (int)$display_orders[$id];
        $currency_image = $currency_images['name'][$id];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($currency_images["name"][$id]);

        $data = [
            'country_name' => $country_name,
            'denomination' => $denomination,
            'buying' => $buying,
            'display_order' => $display_order
        ];

        if (move_uploaded_file($currency_images["tmp_name"][$id], $target_file)) {
            $data['currency_image'] = $currency_image;
        }

        $database->getReference('currencies/' . $id)->update($data);
    }

    header("Location: manage.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $database->getReference('currencies/' . $id)->remove();
    header("Location: manage.php");
}
?>
