const hotelNameInput = document.getElementById("hotelName");
const hotelNameError = document.getElementById("hotelNameError");
const arrivalTimeFromSelect = document.getElementById("arrivalTimeFrom");
const arrivalTimeToSelect = document.getElementById("arrivalTimeTo");
const arrivalError = document.getElementById("arrivalError");
const departureTimeFromSelect = document.getElementById("departureTimeFrom");
const departureTimeToSelect = document.getElementById("departureTimeTo");
const departureError = document.getElementById("departureError");
const buildingNumberInput = document.getElementById("buildingNumber");
const buildingNumberError = document.getElementById("buildingNumberError");
const streetInput = document.getElementById("street");
const streetError = document.getElementById("streetError");
const cityInput = document.getElementById("city");
const cityError = document.getElementById("cityError");
const postalCodeInput = document.getElementById("postalCode");
const postalCodeError = document.getElementById("postalCodeError");
const ibanInput = document.getElementById("iban");
const ibanError = document.getElementById("ibanError");
const listHotelForm = document.getElementById("listHotelForm");
const inputsBorderColor = hotelName.style.color;
const errorBorderColor = "#ff0000";
function validateTime(error, selectFrom, selectTo) {
    if (
        !(selectFrom.value == 0 && selectTo.value == 0) &&
        parseInt(selectFrom.value) >= parseInt(selectTo.value)
    ) {
        error.innerText = "Arrival from must be less than arrival to";
        selectFrom.style.borderColor = errorBorderColor;
        selectTo.style.borderColor = errorBorderColor;
    } else {
        error.innerText = "";
        selectFrom.style.borderColor = inputsBorderColor;
        selectTo.style.borderColor = inputsBorderColor;
    }
}

function validateInputNotEmpty(input, error, message) {
    if (input.value == "") {
        error.innerText = message;
        input.style.borderColor = errorBorderColor;
    } else {
        error.innerText = "";
        input.style.borderColor = inputsBorderColor;
    }
}
function validateHotelName() {
    validateInputNotEmpty(
        hotelNameInput,
        hotelNameError,
        "Please enter name of your hotel"
    );
}
function validateBuildingNumber() {
    validateInputNotEmpty(
        buildingNumberInput,
        buildingNumberError,
        "Please enter number of your hotel building"
    );
}
function validateStreet() {
    validateInputNotEmpty(
        streetInput,
        streetError,
        "Please enter street where your hotel is located"
    );
}
function validateCity() {
    validateInputNotEmpty(
        cityInput,
        cityError,
        "Please enter city where your hotel is located"
    );
}
function validatePostalCode() {
    validateInputNotEmpty(
        postalCodeInput,
        postalCodeError,
        "Please enter postal code of your hotel location"
    );
}
function validateIBAN() {
    validateInputNotEmpty(
        ibanInput,
        ibanError,
        "Please enter your IBAN account"
    );
}
function validateArrival() {
    validateTime(arrivalError, arrivalTimeFromSelect, arrivalTimeToSelect);
}
function validateDeparture() {
    validateTime(
        departureError,
        departureTimeFromSelect,
        departureTimeToSelect
    );
}

hotelNameInput.addEventListener("blur", validateHotelName);
arrivalTimeFromSelect.addEventListener("change", validateArrival);
arrivalTimeToSelect.addEventListener("change", validateArrival);
departureTimeFromSelect.addEventListener("change", validateDeparture);
departureTimeToSelect.addEventListener("change", validateDeparture);
buildingNumberInput.addEventListener("blur", validateBuildingNumber);
streetInput.addEventListener("blur", validateStreet);
cityInput.addEventListener("blur", validateCity);
postalCodeInput.addEventListener("blur", validatePostalCode);
ibanInput.addEventListener("blur", validateIBAN);
listHotelForm.addEventListener("submit", (e) => {
    e.preventDefault();
    validateHotelName();
    validateArrival();
    validateDeparture();
    validateBuildingNumber();
    validateStreet();
    validateCity();
    validatePostalCode();
    validateIBAN();
    let isRight = true;
    const errors = document.querySelectorAll(".error-message");
    for (const error of errors) {
        if (!error.innerText == "") {
            error.parentElement.scrollIntoView({
                behavior: "smooth",
                block: "nearest",
            });
            isRight = false;
            break;
        }
    }
    if (!isRight) return;
    listHotelForm.submit();
});
