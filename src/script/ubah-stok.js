function changeStock(value, stock, price) {
    var currStock = parseInt(document.getElementById("nstock").value) + parseInt(value);

    if (currStock > 0 && currStock <= stock) {
        document.getElementById("nstock").value = currStock;
        document.getElementById("nstockfinal").innerHTML = "x" + document.getElementById("nstock").value;
        document.getElementById("finalprice").innerHTML = "Rp" + (document.getElementById("nstock").value * price);
        document.getElementById("errormsg").innerHTML = "";

        autoChangeStock(stock, price);
    }
}

function changeStockAdmin(value) {
    var currStock = parseInt(document.getElementById("nstockadmin").value) + parseInt(value);

    if (currStock >= 0) {
        document.getElementById("nstockadmin").value = currStock;
        document.getElementById("errormsg").innerHTML = "";
    }   
}

function autoChangeStock(stock, price) {
    var currStock = parseInt(document.getElementById("nstock").value);

    if (currStock >= 0 && currStock <= stock) {
        document.getElementById("nstockfinal").innerHTML = "x" + document.getElementById("nstock").value;
        document.getElementById("finalprice").innerHTML = "Rp" + (document.getElementById("nstock").value * price);
        document.getElementById("errormsg").innerHTML = "";
    } else {
        document.getElementById("nstockfinal").innerHTML = "x0";
        document.getElementById("finalprice").innerHTML = "Rp0";
        document.getElementById("errormsg").innerHTML = "Jumlah stok tidak valid!";
    }
}