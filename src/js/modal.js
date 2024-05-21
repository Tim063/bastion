const scrollController = {
    scrollPosition: 0,
    disabledScroll() {
        scrollController.scrollPosition = window.scrollY;
        document.body.style.cssText = `
        overflow: hidden;
        position: fixed;
        top: -${scrollController.scrollPosition}px;
        left: 0;
        height: 100vh;
        width: 100vw;
        padding-right: ${window.innerWidth - document.body.offsetWidth}px;
        `;
        document.documentElement.style.scrollBehavior = 'unset';
    },
    enabledScroll(){
        document.body.style.cssText = '';
        window.scroll({top:scrollController.scrollPosition})
        document.documentElement.style.scrollBehavior = '';
    },
}
const modalController = ({modal, btnOpen, btnClose}) => {
    const buttonElem = document.querySelector(btnOpen);
    const modalElem = document.querySelector(modal);

    modalElem.style.cssText = `
        display: flex;
        visibility: hidden;
        opacity: 0;
        transition: opacity 300ms ease-in-out;
    `;

    const closeModal = event =>{
        const target = event.target;
        if(target === modalElem || (btnClose && target.closest(btnClose)) || event.code === 'Escape'){
            modalElem.style.opacity = 0;
            setTimeout(() => {
                modalElem.style.visibility = 'hidden';
                modalElem.classList.remove('modal_open');
                scrollController.enabledScroll();
            }, 300);
            window.removeEventListener ('keydown', closeModal);
        }
    }

    const openModal = () =>{
        modalElem.style.visibility = 'visible';
        modalElem.style.opacity = 1;
        modalElem.classList.add('modal_open');
        window.addEventListener('keydown', closeModal);
        scrollController.disabledScroll();
    };

    buttonElem.addEventListener('click', openModal);
    modalElem.addEventListener('click', closeModal);
};

modalController({
    modal: '.price__modal',
    btnOpen: '.price__modal_open',
    btnClose: '.modal__close'
});


