$(document).ready(function() {
    $('.section-services__icon').on('keydown', function(event) {
      if (event.which === 13) {
        var listItem = $(this).closest('.section-services__list__item');
        // Находим блок .section-services__mean внутри этого родительского элемента
        var answer = listItem.find('.section-services__mean');
        
        if ($(this).hasClass('question_active')) {
          // Закрываем текущий элемент, если он уже активен
          answer.slideUp();
          $(this).removeClass('question_active');
        } else {
          // Закрываем предыдущий активный элемент и открываем текущий
          $('.section-services__mean').slideUp();
          $('.section-services__icon').removeClass('question_active');
          answer.slideDown();
          $(this).addClass('question_active');
        }
      }
    });


    $('.section-services__icon').click(function() {
        // Находим родительский блок .section-services__list__item
        var listItem = $(this).closest('.section-services__list__item');
        // Находим блок .section-services__mean внутри этого родительского элемента
        var answer = listItem.find('.section-services__mean');

        if ($(this).hasClass('question_active')) {
          // Закрываем текущий элемент, если он уже активен
          answer.slideUp();
          $(this).removeClass('question_active');
        } else {
          // Закрываем предыдущий активный элемент и открываем текущий
          $('.section-services__mean').slideUp();
          $('.section-services__icon').removeClass('question_active');
          answer.slideDown();
          $(this).addClass('question_active');
        }
    });
  });