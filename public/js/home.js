// PARTIE REVEAL ON SCROLL
let navHome = document.getElementById('site-header');
let navItem = document.getElementsByClassName('navigation-link');

window.addEventListener('scroll', ()=>{
  const scrollPosition = window.scrollY;
  if(scrollPosition > 80){
    navHome.classList.add('active');
    for (let i = 0 ; i < navItem.length; i++){

      navItem[i].classList.add('active');
    }
  }else{
    navHome.classList.remove('active');
    for (let i = 0 ; i < navItem.length; i++){

      navItem[i].classList.remove('active');
    }
  }

 });



window.addEventListener("scroll", reveal);

function reveal() {
  let reveals = document.querySelectorAll(".reveal");
  for (let i = 0; i < reveals.length; i++) {
    let windowHeight = window.innerHeight;
    let revealTop = reveals[i].getBoundingClientRect().top;
    let revealPoint = 150;

    if (revealTop < windowHeight - revealPoint) {
      reveals[i].classList.add("active");
    } else {
      reveals[i].classList.remove("active");
    }
  }
}

