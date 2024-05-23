function addRoomToCart(roomId, button) {
    const urlParams = new URLSearchParams(window.location.search);
    const checkIn = urlParams.get("checkIn");
    const checkOut = urlParams.get("checkOut");

    let cartRooms = getCookie("cartRooms");
    cartRooms = cartRooms ? JSON.parse(cartRooms) : [];

    const roomReservation = { id: roomId, checkIn, checkOut };
    const roomExists = cartRooms.some(
        (room) =>
            room.id === roomId &&
            room.checkIn === checkIn &&
            room.checkOut === checkOut
    );
    if (!roomExists) {
        cartRooms.push(roomReservation);
        setCookie("cartRooms", JSON.stringify(cartRooms), 7);
        button.classList.add("hidden");
        button
            .closest(".actions")
            .querySelector(".unreserve-btn")
            .classList.remove("hidden");
    } else {
        button.classList.add("hidden");
        button
            .closest(".actions")
            .querySelector(".unreserve-btn")
            .classList.remove("hidden");
    }
    checkForRoomsInCart();
}
function updateRooms() {
    let cartRooms = getCookie("cartRooms");
    cartRooms = cartRooms ? JSON.parse(cartRooms) : [];
    document.querySelectorAll(".reserve-btn").forEach((button) => {
        const roomId = parseInt(button.dataset.roomId);
        const isRoomReserved = cartRooms.some((room) => room.id === roomId);

        if (isRoomReserved) {
            button.classList.add("hidden");
            button
                .closest(".actions")
                .querySelector(".unreserve-btn")
                .classList.remove("hidden");
        } else {
            button.classList.remove("hidden");
            button
                .closest(".actions")
                .querySelector(".unreserve-btn")
                .classList.add("hidden");
        }
    });
}

window.addEventListener("pageshow", updateRooms);
