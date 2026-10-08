let columnCount = 1;

let weights = [];


// ==============================
// CREATE FIRST 10 WEIGHTS
// ==============================

window.onload = function () {

    addWeightColumn();

};


// ==============================
// ADD COLUMN
// ==============================

function addWeightColumn() {

    const container =
        document.getElementById(
            "weightContainer"
        );


    const column =
        document.createElement("div");

    column.className =
        "weight-column";


    const start =
        (columnCount - 1) * 10 + 1;

    const end =
        columnCount * 10;


    let html =
        `<h3>Weights ${start} - ${end}</h3>`;


    for (let i = start; i <= end; i++) {
    html += `
        <div class="weight-row">
            <label>${i}</label>
            <input
                type="number"
                step="0.01"
                min="0"
                class="weight-input"
                data-number="${i}"
                oninput="weightChanged(this)"
            >
        </div>
    `;
}


    html += `

        <div class="subtotal">

            Column Total:

            <strong>
                <span class="column-total">
                    0.00
                </span>
                kg
            </strong>

        </div>

    `;


    column.innerHTML = html;

    container.appendChild(column);


    columnCount++;

}



// ==============================
// WHEN WEIGHT CHANGES
// ==============================

function weightChanged(input) {

    calculateColumnTotal(
        input.closest(".weight-column")
    );


    autoAddNextColumn();

}



// ==============================
// COLUMN TOTAL
// ==============================

function calculateColumnTotal(column) {

    let total = 0;


    const inputs =
        column.querySelectorAll(
            ".weight-input"
        );


    inputs.forEach(input => {

        const value =
            parseFloat(input.value) || 0;

        total += value;

    });


    column.querySelector(
        ".column-total"
    ).textContent =
        total.toFixed(2);


    calculateGrandTotal();

}



// ==============================
// AUTOMATIC NEXT COLUMN
// ==============================

function autoAddNextColumn() {

    const columns =
        document.querySelectorAll(
            ".weight-column"
        );


    const lastColumn =
        columns[columns.length - 1];


    const inputs =
        lastColumn.querySelectorAll(
            ".weight-input"
        );


    let allFilled = true;


    inputs.forEach(input => {

        if (
            input.value === "" ||
            parseFloat(input.value) <= 0
        ) {

            allFilled = false;

        }

    });


    if (allFilled) {

        addWeightColumn();

    }

}



// ==============================
// GRAND TOTAL
// ==============================

function calculateGrandTotal() {

    let total = 0;


    document
        .querySelectorAll(".weight-input")
        .forEach(input => {

            total +=
                parseFloat(input.value) || 0;

        });


    document.getElementById(
        "grandTotal"
    ).textContent =
        total.toFixed(2);


    document.getElementById(
        "total_weight"
    ).value = total;

}



// ==============================
// DISTRICT RATE
// ==============================

function updateRate() {

    const district =
        document.getElementById(
            "district"
        ).value;


    let rate = 0;


    if (district === "Vavuniya") {

        rate = 72;

    } else if (district !== "") {

        rate = 73;

    }


    document.getElementById(
        "district_rate"
    ).value = rate;


    document.getElementById(
        "displayRate"
    ).textContent = rate;


    calculateBill();

}



// ==============================
// PADDY PRICE
// ==============================

function updatePrice() {

    const select =
        document.getElementById(
            "paddy_type"
        );


    const option =
        select.options[
            select.selectedIndex
        ];


    const price =
    parseFloat(document.getElementById("price").value) || 0;

    const amount = netWeight * price;


    document.getElementById(
        "price"
    ).value = price;


    calculateBill();

}



// ==============================
// CALCULATE BILL
// ==============================

function calculateBill() {

    calculateGrandTotal();


    const total =
        parseFloat(
            document.getElementById(
                "total_weight"
            ).value
        ) || 0;


    const rate =
        parseFloat(
            document.getElementById(
                "district_rate"
            ).value
        ) || 0;


    const price =
        parseFloat(
            document.getElementById(
                "price"
            ).value
        ) || 0;


    let netWeight = 0;

    let amount = 0;


    if (rate > 0) {

        netWeight =
            total / rate;

    }


    amount =
        netWeight * price;


    document.getElementById(
        "netWeight"
    ).textContent =
        netWeight.toFixed(2);


    document.getElementById(
        "totalAmount"
    ).textContent =
        amount.toFixed(2);


    document.getElementById(
        "net_weight"
    ).value =
        netWeight.toFixed(4);


    document.getElementById(
        "total_amount"
    ).value =
        amount.toFixed(2);



    // Store weights

    let weightData = [];


    document
        .querySelectorAll(".weight-input")
        .forEach(input => {

            if (input.value !== "") {

                weightData.push({

                    number:
                        input.dataset.number,

                    weight:
                        input.value

                });

            }

        });


    document.getElementById(
        "weightsData"
    ).value =
        JSON.stringify(weightData);

}



// ==============================
// RESET
// ==============================

function resetWeights() {

    setTimeout(() => {

        document.getElementById(
            "weightContainer"
        ).innerHTML = "";

        columnCount = 1;

        addWeightColumn();


        document.getElementById(
            "grandTotal"
        ).textContent = "0.00";


        document.getElementById(
            "netWeight"
        ).textContent = "0.00";


        document.getElementById(
            "totalAmount"
        ).textContent = "0.00";

    }, 10);

}