<?php

require "db.php";

if (!isset($_GET["id"])) {
    die("Bill ID not found.");
}

$id = (int)$_GET["id"];

$sql = "
SELECT 
    bills.*,
    farmers.name AS farmer_name,
    farmers.phone,
    farmers.address
FROM bills
INNER JOIN farmers
    ON bills.farmer_id = farmers.id
WHERE bills.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Bill not found.");
}

$bill = $result->fetch_assoc();


$weightSql = "
SELECT weight_no, weight
FROM bill_weights
WHERE bill_id = ?
ORDER BY weight_no
";

$weightStmt = $conn->prepare($weightSql);
$weightStmt->bind_param("i", $id);
$weightStmt->execute();

$weights = $weightStmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>
JM PADDY | <?= htmlspecialchars($bill["bill_no"]) ?>
</title>

<style>

body {
    margin: 0;
    padding: 30px;
    background: #f2f4f3;
    font-family: Arial, sans-serif;
}

.bill {
    max-width: 850px;
    margin: auto;
    background: white;
    padding: 35px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.12);
}

.header {
    text-align: center;
    border-bottom: 2px solid #126b3a;
    padding-bottom: 20px;
}

.header h1 {
    margin: 0;
    color: #126b3a;
}

.header p {
    margin: 5px 0;
}

.info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-top: 25px;
}

.info-box {
    padding: 12px;
    background: #f5f7f6;
    border-radius: 6px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
}

th,
td {
    padding: 10px;
    border: 1px solid #ddd;
}

th {
    background: #126b3a;
    color: white;
}

.summary {
    margin-top: 25px;
    margin-left: auto;
    max-width: 350px;
}

.summary div {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.grand {
    font-size: 20px;
    font-weight: bold;
    background: #e4f3e8;
}

.print-btn {
    display: block;
    width: 180px;
    margin: 25px auto;
    padding: 12px;
    border: none;
    border-radius: 7px;
    background: #126b3a;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

@media print {

    body {
        background: white;
        padding: 0;
    }

    .bill {
        box-shadow: none;
        max-width: none;
    }

    .print-btn {
        display: none;
    }

}

@media (max-width: 600px) {

    .view-dashboard-btn {
        display: block;
        margin: 10px 0 0;
        text-align: center;
    }

    body {
        padding: 10px;
    }

    .bill {
        padding: 20px;
    }

    .info {
        grid-template-columns: 1fr;
    }

}

</style>

</head>

<body>

<div class="bill">

    <div class="header">

    <h1>🌾 JM PADDY</h1>

    <p>Paddy & Farmer Billing System</p>

    <p>📞 070 115 8076</p>

    <p>📍 New Salambaikkulam, Vavuniya</p>

    <p><b>Simple • Fast • Accurate</b></p>

</div>


    <div class="info">

        <div class="info-box">
            <b>Bill No:</b>
            <?= htmlspecialchars($bill["bill_no"]) ?>
        </div>

        <div class="info-box">
            <b>Date:</b>
            <?= htmlspecialchars($bill["bill_date"]) ?>
        </div>

        <div class="info-box">
            <b>Farmer:</b>
            <?= htmlspecialchars($bill["farmer_name"]) ?>
        </div>

        <div class="info-box">
            <b>Phone:</b>
            <?= htmlspecialchars($bill["phone"]) ?>
        </div>

        <div class="info-box">
            <b>Address:</b>
            <?= htmlspecialchars($bill["address"]) ?>
        </div>

        <div class="info-box">
            <b>District:</b>
            <?= htmlspecialchars($bill["district"]) ?>
        </div>

        <div class="info-box">
            <b>Paddy Type:</b>
            <?= htmlspecialchars($bill["paddy_type"]) ?>
        </div>

        <div class="info-box">
            <b>District Rate:</b>
            <?= number_format($bill["district_rate"], 2) ?>
        </div>

    </div>


    <h3>Weight Details</h3>

    <table>

        <thead>

            <tr>
                <th>Weight No</th>
                <th>Weight (kg)</th>
            </tr>

        </thead>

        <tbody>

        <?php while ($weight = $weights->fetch_assoc()) { ?>

            <tr>

                <td>
                    Weight <?= htmlspecialchars($weight["weight_no"]) ?>
                </td>

                <td>
                    <?= number_format($weight["weight"], 2) ?> kg
                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>


    <div class="summary">

        <div>
            <span>Total Weight</span>

            <strong>
                <?= number_format($bill["total_weight"], 2) ?> kg
            </strong>
        </div>

        <div>
            <span>Net Weight</span>

            <strong>
                <?= number_format($bill["net_weight"], 2) ?> kg
            </strong>
        </div>

        <div>
            <span>Paddy Price</span>

            <strong>
                Rs. <?= number_format($bill["price"], 2) ?>
            </strong>
        </div>

        <div class="grand">

            <span>Total Amount</span>

            <strong>
                Rs. <?= number_format($bill["total_amount"], 2) ?>
            </strong>

        </div>

    </div>


    <button
        class="print-btn"
        onclick="window.print()">

        🖨️ Print Bill

    </button>

</div>

</body>

</html>