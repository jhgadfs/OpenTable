console.log("OpenTable website loaded successfully!");

let quantityInput = document.getElementById("quantity");
const price = parseFloat(document.getElementById("price").textContent);

quantityInput.addEventListener("change", function() {
    let quantity = parseInt(quantityInput.value);
    let totalPrice = price * quantity;
    document.getElementById("price").textContent = totalPrice.toFixed(2) + " €";
});