/** Menu toggle */
let mobileBtn = document.querySelector('.toggle');
let navigation = document.querySelector('.navigation');
let main = document.querySelector('.main');

mobileBtn.onclick = function(){
    navigation.classList.toggle('active');
    main.classList.toggle('active');
}

/** list items */
let navLi = document.querySelectorAll('.navigation li');
function activeLink(){
    navLi.forEach((item) => item.classList.remove('hovered'));
    this.classList.add('hovered');
}
navLi.forEach((item) => item.addEventListener('mouseover', activeLink));
