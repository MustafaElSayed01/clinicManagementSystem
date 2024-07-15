const switcher = document.querySelectorAll('.switcher li');
const trs = document.querySelectorAll('table tr');
const trsArray = Array.from(trs);


switcher.forEach((li) => {
    li.addEventListener('click', removeActive);
    li.addEventListener('click', managetrs);

})

function removeActive() {
    switcher.forEach((li) => {
        li.classList.remove('active');
        this.classList.add('active')
    })
}

function managetrs() {
    trs.forEach((tr) => {
        tr.style.display = 'none';
    })
    console.log(this.dataset.cat);
    document.querySelectorAll(this.dataset.cat).forEach((el) => {
        el.style.display = '';
    })
}