<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Exchange</title>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Urbanist', sans-serif;
            background: linear-gradient(to bottom, white, #89cdf1);
            min-height: 100vh; /* ทำให้ background เต็มจอ */
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between; /* ทำให้ปุ่มอยู่ด้านล่างสุด */
        }
        .container {
            max-width: 1000px;
            width: 100%;
            flex-grow: 1; /* ขยาย container เพื่อให้เต็มพื้นที่ */
        }
        img.flag {
            width: 230px; /* ปรับขนาดความกว้างเป็น 230 พิกเซล */
            height: auto;
        }
        .table-auto {
            table-layout: fixed;
            width: 100%;
        }
        .w-40p {
            width: 40%;
        }
        .w-60p {
            width: 60%;
        }
        .font-32-bold {
            font-size: 32px;
            font-weight: 700;
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
            width: 100%; /* ทำให้ปุ่มกว้างเท่าตาราง */
            margin-bottom: 5px; /* เพิ่มการจัดการระยะห่างด้านล่างของปุ่ม */
        }
        .denomination-color {
            color: #ffba00;
        }
        .buying-color {
            color: #10db00;
        }
        .full-width-button {
            width: 100%; /* ทำให้ปุ่มกว้างเท่าตาราง */
        }
    </style>
</head>
<body>

<div class="container mx-auto">
    <div class="table-container">
        <table id="currencyTable" class="table-auto w-full bg-white shadow-md rounded mb-5 text-center">
            <thead>
                <tr class="header-bg">
                    <th class="px-4 py-2 w-40p">Currency Flag</th>
                    <th class="px-4 py-2 w-40p">Currency Name</th>
                    <th class="px-4 py-2 w-60p font-28-bold">Denomination</th>
                    <th class="px-4 py-2 w-60p font-28-bold">Buying</th>
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
                    </td>
                    <td class="border px-4 py-2 font-32-bold"><?php echo $row['country_name']; ?></td>
                    <td class="border px-4 py-2 font-32-bold denomination-color"><?php echo $row['denomination']; ?></td>
                    <td class="border px-4 py-2 font-32-bold buying-color"><?php echo $row['buying']; ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<div class="text-center button-container">
    <a href="manage.php" class="bg-blue-500 text-white font-bold px-4 py-2 rounded full-width-button" style="max-width: 1000px; margin: 0 auto;">Edit Currency</a>
</div>

</body>
</html>
