function getCookie(name) {
    let matches = document.cookie.match(
        new RegExp(
            "(?:^|; )" +
                name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") +
                "=([^;]*)"
        )
    );
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
function deleteCookie(name) {
    setCookie(name, "", -1);
}
function checkForRoomsInCart() {
    let cartRooms = getCookie("cartRooms");
    cartRooms = cartRooms ? JSON.parse(cartRooms) : [];
    cartIndicator = document.querySelector(".cart-indicator");
    if (cartRooms.length !== 0) {
        cartIndicator.classList.remove("hidden");
    } else {
        cartIndicator.classList.add("hidden");
    }
}
// cart
function deleteRoomFromCart(roomId, button, isCart = false) {
    let cartRooms = getCookie("cartRooms");
    cartRooms = cartRooms ? JSON.parse(cartRooms) : [];
    const index = cartRooms.findIndex((room) => room.id === roomId);
    if (index !== -1) {
        cartRooms.splice(index, 1);
        setCookie("cartRooms", JSON.stringify(cartRooms), 7);
        if (isCart) {
            let roomDiv = button.closest(".list-row");
            roomDiv.style.height = roomDiv.scrollHeight + "px";
            roomDiv.offsetHeight;
            roomDiv.style.height = 0;
            roomDiv.addEventListener("transitionend", () => {
                roomDiv.remove();
                calculateTotalPrice();
                if (checkIfCartEmpty()) {
                    const isEmptyDiv = document.createElement("div");
                    isEmptyDiv.innerText = "Cart is empty.";
                    isEmptyDiv.classList.add("not-found-message");
                    document.querySelector(".submit-cart").remove();
                    document
                        .querySelector(".container")
                        .appendChild(isEmptyDiv);
                }
            });
        } else {
            button.classList.add("hidden");
            button
                .closest(".actions")
                .querySelector(".reserve-btn")
                .classList.remove("hidden");
        }
    } else {
        if (!isCart) {
            button.classList.add("hidden");
            button
                .closest(".actions")
                .querySelector(".reserve-btn")
                .classList.remove("hidden");
        }
    }
    checkForRoomsInCart();
}
function checkIfCartEmpty() {
    let cartRooms = getCookie("cartRooms");
    cartRooms = cartRooms ? JSON.parse(cartRooms) : [];
    if (cartRooms.length === 0) return true;
    else return false;
}
function calculateDaysBetween(d1, d2) {
    const date1 = new Date(d1);
    const date2 = new Date(d2);
    const diffTime = Math.abs(date2 - date1);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays;
}
function calculateTotalPrice() {
    let total = 0;
    document.querySelectorAll(".item-room").forEach((room) => {
        const pricePerNight = parseFloat(room.getAttribute("data-room-price"));
        const checkIn = room.getAttribute("data-check-in");
        const checkOut = room.getAttribute("data-check-out");
        const numberOfNights = calculateDaysBetween(checkIn, checkOut);
        total += pricePerNight * numberOfNights;
    });

    document.getElementById("total-price").textContent = Intl.NumberFormat(
        "en-US",
        {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }
    ).format(total);
}
// cart
window.addEventListener("pageshow", checkForRoomsInCart);
