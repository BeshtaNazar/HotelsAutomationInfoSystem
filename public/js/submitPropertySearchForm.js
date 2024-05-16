const searchPropertyForm = document.querySelector(
    ".home-search-property-bar form"
);
searchPropertyForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const actionUrl = searchPropertyForm.action;
    let formData = new FormData(searchPropertyForm);
    if (formData.get("rooms") == 1) {
        formData.delete("adults1");
        formData.delete("children1");
    } else {
        formData.delete("adults");
        formData.delete("children");
    }

    let url = actionUrl + "?" + new URLSearchParams(formData).toString();
    window.location.href = url;
});
