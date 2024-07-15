const userInput = document.querySelector('[name="userID"]');
const userPass = document.querySelector('[name="userPW"]');
const form = document.querySelector(".form");
form.addEventListener('submit', function (e) {
    let userValid = false;
    let passValid = false;

    if (userInput.value !== "" && userInput.value.length == 14) {
        userValid = true;
    }

    if (userPass.value !== "" && userPass.value.length >= 8) {
        passValid = true;

    }

    if (userValid === false || passValid === false) {
        e.preventDefault();
        userPass.value = "";
    }
});