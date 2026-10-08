<?php

require "db.php";

$result = $conn->query(
    "SELECT
        bills.*,
        farmers.name AS farmer_name
     FROM bills
     INNER JOIN farmers
     ON bills.farmer_id = farmers.id
     ORDER BY bills.id DESC"
);

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>JM PADDY | Bill History</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="app">

    <aside class="sidebar">

        <h2>🌾 JM PADDY</h2>

        <a href="dashboard.php">
            🏠 Dashboard
        </a>

        <a href="bill.php">
            🧾 Create Bill
        </a>

        <a href="history.php">
            📋 Bill History
        </a>

    </aside>


    <main class="main">

        <h1>Bill History</h1>


        <section class="panel">

            <div style="overflow-x:auto;">

                <table
                    border="1"
                    cellpadding="10"
                    cellspacing="0"
                    width="100%">

                    <tr>

                        <th>Bill No</th>
                        <th>Date</th>
                        <th>Farmer</th>
                        <th>District</th>
                        <th>Paddy</th>
                        <th>Total Weight</th>
                        <th>Net Weight</th>
                        <th>Amount</th>

                    </tr>


                    <?php while (
                        $row = $result->fetch_assoc()
                    ): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                $row["bill_no"]
                            ) ?>
                        </td>

                        <td>
                            <?= $row["bill_date"] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $row["farmer_name"]
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $row["district"]
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $row["paddy_type"]
                            ) ?>
                        </td>

                        <td>
                            <?= number_format(
                                $row["total_weight"],
                                2
                            ) ?>
                        </td>

                        <td>
                            <?= number_format(
                                $row["net_weight"],
                                2
                            ) ?>
                        </td>

                        <td>
                            Rs.
                            <?= number_format(
                                $row["total_amount"],
                                2
                            ) ?>
                        </td>

                    </tr>

                    <?php endwhile; ?>

                </table>

            </div>

        </section>

    </main>

</div>

</body>

</html>