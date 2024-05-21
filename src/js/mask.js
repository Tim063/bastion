document.addEventListener("DOMContentLoaded", function() {

    function initializeInputMaskAndStyles(inputSelector, buttonSelector) {
        var inputElement = document.querySelector(inputSelector);
        var button = document.querySelector(buttonSelector);

        var im = new Inputmask("+7 (999) 999-99-99");
        im.mask(inputElement);

        inputElement.addEventListener("input", function() {
            updateButtonStyles(inputElement, button);
        });


        function updateButtonStyles(element, button) {
            if (element.inputmask && element.inputmask.isComplete()) {
                button.style.backgroundColor = '#1E1F1E';
                button.style.cursor = 'pointer'; 
                button.style.pointerEvents = 'auto';
            } else {
                button.style.backgroundColor = '#c8c8c8';
                button.style.cursor = 'not-allowed'; 
                button.style.pointerEvents = 'none';
            }
        }
  
        updateButtonStyles(inputElement, button);
    }


    initializeInputMaskAndStyles("input[name='telQuestion']", ".form__question__button_dis3");
    initializeInputMaskAndStyles("input[name='telPrice']", ".form__question__button_dis4");
 
});



