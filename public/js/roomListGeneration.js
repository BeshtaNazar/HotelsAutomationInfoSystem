const childrenNumElem = document.getElementById("childrenNum");
const adultNumElem = document.getElementById("adultNum");
const adultSelectElem = document.getElementById("adultSelect");
const childrenSelectElem = document.getElementById("childrenSelect");
const roomList = document.getElementById("roomList");
const closeRoomListButton = roomList.querySelector(".close-room-list-button");
const roomSelect = document.getElementById("roomSelect");
const roomListSpan = roomList.querySelector("span");
const roomListElems = Array.from(roomList.children);
function getElementAbsoluteHeight(element) {
    const height = element.offsetHeight,
        style = window.getComputedStyle(element);

    return ["top", "bottom", "right", "left"]
        .map((side) => parseInt(style[`margin-${side}`], 10))
        .reduce((total, side) => total + side, height);
}
function getRoomListHeight() {
    let roomListHeight = 0;
    roomListElems.forEach((element) => {
        roomListHeight += getElementAbsoluteHeight(element);
    });
    return roomListHeight;
}
function showRoomList() {
    roomList.style.height = roomListHeight + 10 + "px";
}
function closeRoomList() {
    roomList.style.height = "0px";
}
function getAdultsNum() {
    let sum = 0;
    for (
        let i = 1;
        i <= roomListSpan.querySelectorAll(".room-info-group").length;
        i++
    ) {
        sum += parseInt(document.getElementById(`adults${i}`).value);
    }
    return sum;
}
function getChildrenNum() {
    let sum = 0;
    for (
        let i = 1;
        i <= roomListSpan.querySelectorAll(".room-info-group").length;
        i++
    ) {
        sum += parseInt(document.getElementById(`children${i}`).value);
    }
    return sum;
}
function createRoomDiv(roomIndex) {
    let div = document.createElement("div");
    div.className = "room-info-group";
    div.innerHTML = `
<div class="room-list-row">
    <div class="col col-room-name">
        <label>Room: ${roomIndex}</label>
    </div>
    <div class="col col-adults">
        <label for="adults${roomIndex}">Adults:</label>
        <select id="adults${roomIndex}" name="adults${roomIndex}" class="custom-select">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
        </select>
    </div>
    <div class="col col-children">
        <label for="children${roomIndex}">Children:</label>
        <select id="children${roomIndex}" name="children${roomIndex}" class="custom-select">
            <option>0</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
        </select>
    </div>
`;

    div.querySelector(`#adults${roomIndex}`).addEventListener("change", () => {
        adultNumElem.value = getAdultsNum();
    });
    div.querySelector(`#children${roomIndex}`).addEventListener(
        "change",
        () => {
            childrenNumElem.value = getChildrenNum();
        }
    );

    return div;
}
let roomListHeight = getRoomListHeight();
roomSelect.addEventListener("change", () => {
    const roomSelectedValue = roomSelect.value;
    if (roomSelectedValue > 1) {
        if (adultNumElem.style.display == "none") {
            adultNumElem.style.display = "block";
            adultSelectElem.style.display = "none";
            childrenNumElem.style.display = "block";
            childrenSelectElem.style.display = "none";
        }
    } else {
        adultNumElem.style.display = "none";
        adultSelectElem.style.display = "block";
        childrenNumElem.style.display = "none";
        childrenSelectElem.style.display = "block";
        closeRoomList();
    }

    let roomListLength =
        roomListSpan.querySelectorAll(".room-info-group").length;
    while (roomListLength < roomSelectedValue) {
        roomListSpan.appendChild(createRoomDiv(roomListLength + 1));
        roomListLength++;
    }
    while (roomListLength > roomSelectedValue) {
        roomListSpan.removeChild(roomListSpan.lastChild);
        roomListLength--;
    }
    adultNumElem.value = getAdultsNum();
    roomListHeight = getRoomListHeight();
    if (roomSelectedValue == 1) closeRoomList();
    else if (roomList.style.height != "0px") showRoomList();
});

childrenNumElem.addEventListener("click", showRoomList);
adultNumElem.addEventListener("click", showRoomList);
closeRoomListButton.addEventListener("click", closeRoomList);
document.getElementById("adults1").addEventListener("change", () => {
    adultNumElem.value = getAdultsNum();
});
document.getElementById("children1").addEventListener("change", () => {
    childrenNumElem.value = getChildrenNum();
});
