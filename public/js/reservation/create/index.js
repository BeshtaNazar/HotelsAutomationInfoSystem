document.addEventListener("DOMContentLoaded", (event) => {
    const selectElement = document.getElementById("cardExpirationYear");
    const currentYear = new Date().getFullYear();
    const yearsToAdd = 10;

    for (let i = 0; i <= yearsToAdd; i++) {
        const year = currentYear + i;
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        selectElement.appendChild(option);
    }
});
