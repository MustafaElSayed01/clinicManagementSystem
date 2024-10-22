function myDate(){
    const input = document.getElementById("fdate").value;
    const options = { weekday: "short" };
    var d = new Date(input);
    year = d.getFullYear();
    month = d.getMonth() + 1;
    day = d.getDate();
    var arDay = (d.toLocaleDateString("ar-EG", options));
    document.getElementById("fday").value = arDay;
}
function checkDayOfWeek(event) {
    var selectedDate = new Date(event.target.value);
    if (selectedDate.getDay() === 5) {
    event.target.value = "";
    alert("لا يمكن اختيار يوم الجمعة");
    }
}
const timeFrom = document.getElementById('timeFrom');
const timeTo = document.getElementById('timeTo');
const timeError = document.getElementById('timeError');
timeTo.addEventListener('blur', () => {
    const timeFromValue = timeFrom.value;
    const timeToValue = timeTo.value;
    const timeFromDate = new Date(`2000-01-01T${timeFromValue}`);
    const timeToDate = new Date(`2000-01-01T${timeToValue}`);
    const timeDifference = (timeToDate - timeFromDate) / (1000 * 60);

    if (timeDifference < 60) {
        timeError.textContent = 'يجب أن يكون الفرق بين الوقتين على الأقل ساعة واحدة';
        timeTo.setCustomValidity('يجب أن يكون الفرق بين الوقتين على الأقل ساعة واحدة');
    } else {
        timeError.textContent = '';
        timeTo.setCustomValidity('');
    }
});