let checkinLimit = new Date();
let checkin = document.getElementsByName("checkIn")[0];
checkin.setAttribute("min", checkinLimit.toISOString().split("T")[0]);
let checkoutLimit = new Date();
checkoutLimit.setDate(checkoutLimit.getDate() + 1);
let checkout = document.getElementsByName("checkOut")[0];
checkout.setAttribute("min", checkoutLimit.toISOString().split("T")[0]);
checkin.addEventListener("input", () => {
    checkoutLimit = new Date(checkin.value);
    checkoutLimit.setDate(checkoutLimit.getDate() + 1);
    checkout.setAttribute("min", checkoutLimit.toISOString().split("T")[0]);
});

checkin.addEventListener("keydown", function (event) {
    event.preventDefault();
});

checkin.addEventListener("paste", function (event) {
    event.preventDefault();
});

checkin.addEventListener("contextmenu", function (event) {
    event.preventDefault();
});
checkout.addEventListener("keydown", function (event) {
    event.preventDefault();
});

checkout.addEventListener("paste", function (event) {
    event.preventDefault();
});

checkout.addEventListener("contextmenu", function (event) {
    event.preventDefault();
});
