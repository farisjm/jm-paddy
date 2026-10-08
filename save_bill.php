<?php

require "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: bill.php");
    exit;
}

$bill_no = $_POST["bill_no"];
$bill_date = $_POST["bill_date"];
$farmer_name = $_POST["farmer_name"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$district = $_POST["district"];
$district_rate = $_POST["district_rate"];
$paddy_type = $_POST["paddy_type"];
$total_weight = $_POST["total_weight"];
$net_weight = $_POST["net_weight"];
$price = $_POST["price"];
$total_amount = $_POST["total_amount"];

$stmt = $conn->prepare(
    "INSERT INTO farmers
    (name, phone, address)
    VALUES (?, ?, ?)"
);

$stmt->bind_param(
    "sss",
    $farmer_name,
    $phone,
    $address
);

$stmt->execute();

$farmer_id = $conn->insert_id;


$stmt = $conn->prepare(
    "INSERT INTO bills
    (
        bill_no,
        farmer_id,
        bill_date,
        district,
        district_rate,
        paddy_type,
        total_weight,
        net_weight,
        price,
        total_amount
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "sissssdddd",
    $bill_no,
    $farmer_id,
    $bill_date,
    $district,
    $district_rate,
    $paddy_type,
    $total_weight,
    $net_weight,
    $price,
    $total_amount
);

if ($stmt->execute()) {

    $bill_id = $conn->insert_id;

    $weights =
        json_decode(
            $_POST["weights"],
            true
        );

    if (is_array($weights)) {

        $weightStmt = $conn->prepare(
            "INSERT INTO bill_weights
            (bill_id, weight_no, weight)
            VALUES (?, ?, ?)"
        );

        foreach ($weights as $item) {

            $weight_no =
                (int)$item["number"];

            $weight =
                (float)$item["weight"];

            $weightStmt->bind_param(
                "iid",
                $bill_id,
                $weight_no,
                $weight
            );

            $weightStmt->execute();
        }
    }

    echo "<h2>Bill Saved Successfully!</h2>";
    echo "<p>Bill No: " .
         htmlspecialchars($bill_no) .
         "</p>";

    echo "<p>Total Amount: Rs. " .
         number_format($total_amount, 2) .
         "</p>";

    echo '<a href="bill.php">Create Another Bill</a>';

} else {

    echo "Error: " . $stmt->error;

}

?>