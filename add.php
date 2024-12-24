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
            'display_order' => (int)($database->getReference('currencies')->getSnapshot()->numChildren() + 1)
        ]);
        header("Location: index.php");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Currency</title>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Urbanist', sans-serif;
            background: linear-gradient(to bottom, white, #89cdf1);
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            max-width: 600px;
            width: 100%;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 700;
        }
        .form-group input[type="text"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background: #1d1b23;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 700;
        }
    </style>
</head>
<body>

<div class="container mx-auto">
    <div class="form-container">
        <h2 class="text-center text-2xl mb-4 font-bold">Add Currency</h2>
        <form action="add.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="currency_image">Currency Flag</label>
                <input type="file" name="currency_image" id="currency_image" required>
            </div>
            <div class="form-group">
                <label for="country_name">Currency Name</label>
                <input type="text" name="country_name" id="country_name" required>
            </div>
            <div class="form-group">
                <label for="denomination">Denomination</label>
                <input type="text" name="denomination" id="denomination" required>
            </div>
            <div class="form-group">
                <label for="buying">Buying</label>
                <input type="text" name="buying" id="buying" required>
            </div>
            <div class="form-group">
                <button type="submit" name="add">Add Currency</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
