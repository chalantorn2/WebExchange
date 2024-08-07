<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Currency</title>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Urbanist', sans-serif;
            background: linear-gradient(to bottom, white, #89cdf1);
            padding-top: 20px;
            box-sizing: border-box;
        }
        .container {
            max-width: 1000px;
            width: 100%;
            margin-top: 40px; /* ลดระยะห่างด้านบน */
        }
        img.flag {
            width: 230px; /* ปรับขนาดความกว้างเป็น 230 พิกเซล */
            height: auto;
        }
        .table-container {
            max-height: 80vh;
            overflow-y: auto;
        }
        .table-auto {
            table-layout: fixed;
            width: 100%;
        }
        .w-20p {
            width: 20%;
        }
        .font-regular {
            font-size: 16px;
            font-weight: 400;
            color: black;
        }
        .header-bg {
            background-color: #1d1b23;
            color: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .row-bg-1 {
            background-color: #3f3c51;
            color: white;
        }
        .row-bg-2 {
            background-color: #302c3a;
            color: white;
        }
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 10px; /* เพิ่มการจัดการระยะห่างด้านบนของปุ่ม */
        }
        .button-container a, .button-container button {
            margin: 0;
            padding: 0.5rem 1rem;
            white-space: nowrap;
        }
        .actions-cell {
            display: flex;
            flex-direction: column;
            gap: 5px;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .actions-cell a, .actions-cell button {
            display: block;
            width: 100px; /* ปรับขนาดตามต้องการ */
            text-align: center;
            padding: 0.5rem;
        }
        /* ซ่อน Scrollbar */
        .table-container::-webkit-scrollbar {
            display: none;
        }
        .table-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body>

<div class="container mx-auto">
    <div class="text-center mb-5">
        <a href="index.php">
            <img src="uploads/exchangeLogo.png" alt="Logo" class="mx-auto h-auto w-48">
        </a>
    </div>

    <div class="table-container">
        <form action="crud.php" method="post" enctype="multipart/form-data">
            <table class="table-auto w-full bg-white shadow-md rounded mb-5 text-center">
                <thead>
                    <tr class="header-bg">
                        <th class="px-4 py-2 w-20p">Currency Flag</th>
                        <th class="px-4 py-2 w-20p">Currency Name</th>
                        <th class="px-4 py-2 w-20p">Denomination</th>
                        <th class="px-4 py-2 w-20p">Buying</th>
                        <th class="px-4 py-2 w-20p">Order</th>
                        <th class="px-4 py-2 w-20p">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $conn = new PDO("pgsql:host=" . getenv('DATABASE_HOST') . ";dbname=" . getenv('DATABASE_NAME'), getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'));
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $result = $conn->query("SELECT * FROM currencies ORDER BY display_order ASC") or die($conn->errorInfo()[2]);
                $rowCount = 0;
                while ($row = $result->fetch(PDO::FETCH_ASSOC)): 
                    $rowClass = ($rowCount % 2 == 0) ? 'row-bg-1' : 'row-bg-2';
                    $rowCount++;
                ?>
                    <tr class="<?php echo $rowClass; ?>">
                        <td class="border px-4 py-2">
                            <img src="uploads/<?php echo $row['currency_image']; ?>" alt="Flag" class="flag mx-auto">
                            <input type="file" name="currency_image[<?php echo $row['id']; ?>]" class="mt-1 p-2 w-full border rounded">
                        </td>
                        <td class="border px-4 py-2 font-regular">
                            <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>">
                            <input type="text" name="country_name[<?php echo $row['id']; ?>]" value="<?php echo $row['country_name']; ?>" class="mt-1 p-2 w-full border rounded">
                        </td>
                        <td class="border px-4 py-2 font-regular">
                            <input type="text" name="denomination[<?php echo $row['id']; ?>]" value="<?php echo $row['denomination']; ?>" class="mt-1 p-2 w-full border rounded">
                        </td>
                        <td class="border px-4 py-2 font-regular">
                            <input type="text" name="buying[<?php echo $row['id']; ?>]" value="<?php echo $row['buying']; ?>" class="mt-1 p-2 w-full border rounded">
                        </td>
                        <td class="border px-4 py-2 font-regular">
                            <input type="number" name="display_order[<?php echo $row['id']; ?>]" value="<?php echo $row['display_order']; ?>" class="mt-1 p-2 w-full border rounded">
                        </td>
                        <td class="border px-4 py-2 actions-cell">
                            <a href="crud.php?delete=<?php echo $row['id']; ?>" class="bg-red-500 text-white rounded">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <div class="text-center button-container">
                <button type="submit" name="update_all" class="bg-blue-500 text-white px-4 py-2 rounded">Update All</button>
                <a href="index.php" class="bg-gray-500 text-white px-4 py-2 rounded">Back to List</a>
                <a href="add.php" class="bg-green-500 text-white px-4 py-2 rounded">Add Currency</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
