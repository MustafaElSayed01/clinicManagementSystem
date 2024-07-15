const reservationPrice = document.querySelector('[name="reservationPrice"]');
const perHour = document.querySelector('[name="perHour"]');
const form = document.querySelector(".form");
form.addEventListener("submit", function (e) {
	let reservationPriceValid = false;
	let perHourValid = false;

	if (reservationPrice.value !== "" && reservationPrice.value.length >= 8) {
		reservationPriceValid = true;
	}

	if (perHour.value !== "" && perHour.value.length >= 8) {
		perHourValid = true;
	}

	if (reservationPriceValid === false || perHourValid === false) {
		e.preventDefault();
	}
});