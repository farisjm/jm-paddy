<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>JM PADDY | Create Bill</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="app">

    <aside class="sidebar">

        <h2>🌾 JM PADDY</h2>

        <p class="subtitle">
            Paddy Billing System
        </p>

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

        <header class="topbar">

            <h1>Create Paddy Bill</h1>

        </header>


        <form id="billForm"
              action="save_bill.php"
              method="POST">


            <!-- FARMER INFORMATION -->

            <section class="panel">

                <h2>Farmer Information</h2>

                <div class="grid">

                    <div>
                        <label>Bill No</label>

                        <input
                            type="text"
                            name="bill_no"
                            id="bill_no"
                            required
                        >
                    </div>


                    <div>

                        <label>Date</label>

                        <input
                            type="date"
                            name="bill_date"
                            value="<?php echo date('Y-m-d'); ?>"
                            required
                        >

                    </div>


                    <div>

                        <label>Farmer Name</label>

                        <input
                            type="text"
                            name="farmer_name"
                            required
                        >

                    </div>


                    <div>

                        <label>Phone</label>

                        <input
                            type="text"
                            name="phone"
                        >

                    </div>


                    <div class="full">

                        <label>Address</label>

                        <input
                            type="text"
                            name="address"
                        >

                    </div>


                    <div>

                        <label>District</label>

                        <select
                            name="district"
                            id="district"
                            onchange="updateRate()"
                            required
                        >

                            <option value="">
                                Select District
                            </option>

                            <option value="Vavuniya">
                                Vavuniya
                            </option>

                            <option value="Mannar">
                                Mannar
                            </option>

                            <option value="Mullaitivu">
                                Mullaitivu
                            </option>

                            <option value="Kilinochchi">
                                Kilinochchi
                            </option>

                            <option value="Jaffna">
                                Jaffna
                            </option>

                        </select>

                    </div>


                    <div>

                        <label>District Rate</label>

                        <input
                            type="number"
                            name="district_rate"
                            id="district_rate"
                            readonly
                        >

                    </div>

                </div>

            </section>



            <!-- PADDY INFORMATION -->

            <section class="panel">

                <h2>Paddy Information</h2>

                <div class="grid">

                    <div>

                        <div>
    <label>Paddy Type</label>

    <select name="paddy_type" id="paddy_type">
        <option value="">Select Paddy Type</option>
        <option value="Samba">Samba</option>
        <option value="Keeri Samba">Keeri Samba</option>
        <option value="Nadu">Nadu</option>
    </select>
</div>

<div>
    <label>Today's Price (Rs.)</label>

    <input
        type="number"
        name="price"
        id="price"
        step="0.01"
        min="0"
        placeholder="Enter price"
        oninput="calculateBill()"
        required
    >
</div>
            </section>



            <!-- WEIGHTS -->

            <section class="panel">

                <div class="weight-header">

                    <h2>Weight Entries</h2>

                    <button
                        type="button"
                        class="small-btn"
                        onclick="addWeightColumn()">
                        + Add 10 Weights
                    </button>

                </div>


                <div
                    id="weightContainer"
                    class="weight-container">
                </div>


                <input
                    type="hidden"
                    name="weights"
                    id="weightsData"
                >

            </section>



            <!-- CALCULATION -->

            <section class="panel">

                <h2>Calculation</h2>


                <div class="result-grid">

                    <div class="result-box">

                        <span>
                            Grand Total
                        </span>

                        <strong>
                            <span id="grandTotal">
                                0.00
                            </span>
                            kg
                        </strong>

                    </div>


                    <div class="result-box">

                        <span>
                            District Rate
                        </span>

                        <strong id="displayRate">
                            0
                        </strong>

                    </div>


                    <div class="result-box">

                        <span>
                            Net Weight
                        </span>

                        <strong>
                            <span id="netWeight">
                                0.00
                            </span>
                            kg
                        </strong>

                    </div>


                    <div class="result-box total">

                        <span>
                            Total Amount
                        </span>

                        <strong>
                            Rs.
                            <span id="totalAmount">
                                0.00
                            </span>
                        </strong>

                    </div>

                </div>


                <input
                    type="hidden"
                    name="total_weight"
                    id="total_weight">

                <input
                    type="hidden"
                    name="net_weight"
                    id="net_weight">

                <input
                    type="hidden"
                    name="total_amount"
                    id="total_amount">


                <div class="actions">

                    <button
                        type="button"
                        class="calculate"
                        onclick="calculateBill()">
                        Calculate
                    </button>


                   <button type="submit" class="save">
                    💾 Save Bill
                   </button>


                    <button
                        type="reset"
                        class="clear"
                        onclick="resetWeights()">
                        Clear
                    </button>

                </div>

            </section>

        </form>

    </main>

</div>


<script src="script.js"></script>

</body>
</html>