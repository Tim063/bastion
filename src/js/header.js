window.onscroll = function showHeader(){
    const modal = document.querySelector('.modal_open');
    let header = document.querySelector('.header');
    let hero = document.querySelector('.section-hero');
    if(window.pageYOffset > 200 || (modal && getComputedStyle(modal).visibility === 'visible')){
        header.classList.add('header_fixed')
        hero.style.marginTop = `${header.offsetHeight}px`
    }
    else{
        header.classList.remove('header_fixed');
        hero.style.marginTop = `0px`
    }
}