const pName = document.querySelector('[name="pName"]');
const pPhone = document.querySelector('[name="pPhone"]');
const pNID = document.querySelector('[name="pNID"]');
const reservedDate = document.querySelector('[name="reservedDate"]');

const form = document.querySelector(".form");
form.addEventListener('submit', function (e) {
    let pNameValid = false;
    let pPhoneValid = false;
    let pNIDValid = false;
    let reservedDateValid = false;



    if (pName.value !== "") {
        pNameValid = true;
    }

    if (pPhone.value !== "" && pPhone.value.length == 11) {
        pPhoneValid = true;

    }
    if (pNID.value !== "") {
        pNIDValid = true;

    }

    if (reservedDate.value !== "") {
        reservedDateValid = true;

    }

    if (pNameValid === false || pPhoneValid === false || pNIDValid === false || reservedDateValid === false) {
        e.preventDefault();
    }
});
