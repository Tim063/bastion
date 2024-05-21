<?php


function strategy_assets() {
    // Подключение стилей
    wp_enqueue_style( 'swiper', get_template_directory_uri() . '/assets/swiper.css' );
    wp_enqueue_style( 'simplebar', get_template_directory_uri() . '/assets/simplebar.css' );
    wp_enqueue_style( 'aos', get_template_directory_uri() . '/assets/aos.css' );
    wp_enqueue_style( 'maincss', get_template_directory_uri() . '/assets/main.css' );

    
    // Отключение встроенной версии jQuery
    wp_deregister_script('jquery');

    // Подключение версии jQuery
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/jquery.js', array(), null, true );
    // Подключение скриптов
    wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/swiper.js', array(), null, true );
    wp_enqueue_script( 'maskplugin', get_template_directory_uri() . '/assets/inputmask.min.js', array(), null, true );
    wp_enqueue_script( 'simplebar', get_template_directory_uri() . '/assets/simplebar.js', array(), null, true );
    wp_enqueue_script( 'aos', get_template_directory_uri() . '/assets/aos.js', array(), null, true );
    wp_enqueue_script( 'script-all', get_template_directory_uri() . '/assets/app.js', array(), null, true );

    
}

add_action( 'wp_enqueue_scripts', 'strategy_assets' );
function add_schema_markup() {
    $schema_url = get_template_directory_uri() . '/assets/schema.json';
    $schema = file_get_contents($schema_url);
    echo '<script type="application/ld+json">' . $schema . '</script>';
}
add_action('wp_head', 'add_schema_markup');

show_admin_bar(false);

// Функция для получения значения из таблицы по заданному ID
function get_value_by_id($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "count";
    $value = $wpdb->get_var($wpdb->prepare("SELECT value FROM $table_name WHERE id = %d", $id));
    return $value;
}

// Получаем значения из таблицы для каждой переменной
$opit = get_value_by_id(1);
$dela = get_value_by_id(2);
$otrasl = get_value_by_id(3);
$special = get_value_by_id(4);

// Функция для создания кейсов
function custom_cases_slider_shortcode() {
    global $wpdb;
    $tablename = $wpdb->prefix . "cases";

    // Получаем список всех кейсов
    $casesList = $wpdb->get_results("SELECT * FROM $tablename ORDER BY id DESC");

    ob_start(); // Начинаем буферизацию вывода

    ?>
    <div class="swiper swiperCases">
        <div class="swiper-wrapper">
            <?php
            if (count($casesList) > 0) {
                foreach ($casesList as $case) {
                    $category = $case->category;
                    $happen = $case->happen;
                    $activity = $case->activity;
                    $result = $case->result;
                    ?>
                    <div class="swiper-slide"><article class="case"><dfn class="case__category"><?php echo $category; ?></dfn><dl class="case__desc simplebar-scrollable-y" data-simplebar data-simplebar-auto-hide="false"><dt class="case__def">Что случилось:</dt><dd class="case__mean"><?php echo $happen; ?></dd><dt class="case__def">Проведенная работа:</dt><dd class="case__mean"><?php echo $activity; ?></dd><dt class="case__def">Результат:</dt><dd class="case__mean"><?php echo $result; ?></dd></dl></article></div>
                <?php
                }
            } else {
                echo "<div class='swiper-slide'>Нет кейсов</div>";
            }
            ?>
        </div>
    </div>
    <?php

    return ob_get_clean(); // Возвращаем содержимое буфера вывода
}
add_shortcode('cases_slider', 'custom_cases_slider_shortcode');
?>
<?php 
function quiz_shortcode(){
    
ob_start(); 

?>
<script>
jQuery(document).ready(function($) {
    $('.form__question__button_dis3').click(function(event) {
        // Отменяем стандартное поведение кнопки
        event.preventDefault();
        
        // Находим форму с id "form_quiz" и вызываем метод submit() для отправки формы
        $('#form_quiz').submit();
    });
    $('#form_quiz').submit(function(e) {
        e.preventDefault(); // Предотвращаем отправку формы по умолчанию
        var form_data = $(this).serialize(); // Получаем данные формы
        // Отправляем AJAX-запрос на обработчик формы
        $.ajax({
            type: 'POST',
            url: '<?php echo admin_url('admin-ajax.php'); ?>', // URL для обработчика AJAX
            data: form_data, // Добавляем действие для обработчика
            success: function(response) {
                // Обновляем содержимое последнего div с классом form__question
                $('.form__thanks').html('Спасибо, мы свяжемся c Вами в ближайшее время');
            },
            error: function(xhr, status, error) {
                $('.form__thanks').html('Что-то пошло не так');
            }
        });
    });
});
</script>
<?php
    return ob_get_clean();
}
add_shortcode('form_quiz', 'quiz_shortcode');
?>
<?php 
//форма с прайс листом
function price_shortcode(){
    
ob_start(); 

?>
<script>
jQuery(document).ready(function($) {

    $('#price_form').submit(function(e) {
        e.preventDefault(); // Предотвращаем отправку формы по умолчанию
        
        var form_dataPrice = $(this).serialize(); // Получаем данные формы
        
        // Отправляем AJAX-запрос на обработчик формы
        $.ajax({
            type: 'POST',
            url: '<?php echo admin_url('admin-ajax.php'); ?>', // URL для обработчика AJAX
            data: form_dataPrice, // Добавляем действие для обработчика
            success: function(response) {
               $('.price__modal__wrap').css('display', 'none'); // Скрываем модальное окно
               $('.price__modal__heading_thanks').html('Спасибо, мы с Вами свяжемся');
               $('.price__modal__heading_thanks')
                    .css('visibility', 'visible') 
                    .css('opacity', '1')
                    .css('max-height', 'none'); 
            },
            error: function(xhr, status, error) {
                $('.price__modal__wrap').css('display', 'none'); // Скрываем модальное окно
                $('.price__modal__heading_thanks').html('Что-то пошло не так');
                $('.price__modal__heading_thanks')
                    .css('visibility', 'visible') 
                    .css('opacity', '1'); 
            }
        });
    });
});
</script>
<?php
    return ob_get_clean();
}
add_shortcode('send_price', 'price_shortcode');
?>
<?php

add_action('wp_ajax_message_to_telegram', 'send_to_telegram');
add_action('wp_ajax_nopriv_message_to_telegram', 'send_to_telegram');
add_action('wp_ajax_price_to_telegram', 'send_to_telegram');
add_action('wp_ajax_nopriv_price_to_telegram', 'send_to_telegram');


// Функция для отправки сообщения в Телеграм
function send_to_telegram() {
    $bot_token = '7153944911:AAFCSoAtD8o9HhQVV7QxWlGHAdVbqT6OAG0';
    $chat_id = '-4183405504';
    
    if ( isset($_POST['action']) ) {
        // Проверяем тип запроса (авторизованный или неавторизованный)
        if ( 'message_to_telegram' === $_POST['action'] ) {
            // Обработка запроса для отправки сообщения из формы message_to_telegram
            $message="Новая форма отправлена! Данные:\n";
            $urStatus = sanitize_text_field($_POST['UrStatus']);
            $usluga = sanitize_text_field($_POST['usluga']);
            $opisanie = isset($_POST['opisanie']) ? sanitize_textarea_field($_POST['opisanie']) : '';
            $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
            $telQuestion = sanitize_text_field($_POST['telQuestion']);
            
            $message .= "Статус лица: $urStatus\n";
            $message .= "Услуга нужна: $usluga\n";
            $message .= "Описание: $opisanie\n";
            $message .= "Имя: $name\n";
            $message .= "Телефон: $telQuestion\n"; 
        } elseif ( 'price_to_telegram' === $_POST['action'] ) {
            // Обработка запроса для отправки сообщения из формы price_to_telegram
            $message="Новая заявка на прайс-лист данные:\n";
            $telPrice = sanitize_text_field($_POST['telPrice']);
            $message .= "Телефон: $telPrice\n"; 
        }
        
        // Отправка сообщения в Телеграм
        wp_remote_post(
            "https://api.telegram.org/bot{$bot_token}/sendMessage",
            array(
                'body' => json_encode(array('chat_id' => $chat_id, 'text' => $message)),
                'headers' => array('Content-Type' => 'application/json'),
            )
        );
        
        // Отправка ответа об успешной отправке
        wp_send_json_success(array('message' => 'Спасибо за отправку!'));
    }
    // Если не передана ни одна форма, возвращаем ошибку
    wp_send_json_error(array('message' => 'Ошибка: Неверный тип запроса!'));
    die;
}
?>