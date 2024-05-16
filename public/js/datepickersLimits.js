let checkinLimit = new Date();
let checkin = document.getElementsByName("checkin")[0];
checkin.setAttribute("min", checkinLimit.toISOString().split("T")[0]);
let checkoutLimit = new Date();
checkoutLimit.setDate(checkoutLimit.getDate() + 1);
let checkout = document.getElementsByName("checkout")[0];
checkout.setAttribute("min", checkoutLimit.toISOString().split("T")[0]);
checkin.addEventListener("input", () => {
    checkoutLimit = new Date(checkin.value);
    checkoutLimit.setDate(checkoutLimit.getDate() + 1);
    checkout.setAttribute("min", checkoutLimit.toISOString().split("T")[0]);
});
