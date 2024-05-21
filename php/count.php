<?php

/*
   Plugin Name: Плагин для счетчика Бастион
   description: Плагин для обновления счётчика на сайте
   Version: 1.0.0
   Author: Тимофей
*/

// Создаем таблицу
function count_table()
{

    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $tablename = $wpdb->prefix . "count";

    $sql = "CREATE TABLE $tablename (
      id int(11) NOT NULL AUTO_INCREMENT,
      nameCount varchar(255) NOT NULL,
      value varchar(255) NOT NULL,
      PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

}

register_activation_hook(__FILE__, 'count_table');

// Добавляем меню
function count_menu()
{
    $parent_slug = "count"; // Идентификатор родительского меню

    add_menu_page(
        "Плагин счётчика", // Название страницы в меню
        "Плагин счётчика", // Название в боковой панели администратора
        "manage_options", // Роль, которой разрешено видеть меню
        $parent_slug, // Уникальный идентификатор для родительского меню
        "rewriteCountPlug", // Функция, которая будет вызвана для вывода страницы
        "dashicons-plus" // Иконка для меню
    );

    add_submenu_page(
        $parent_slug, // Идентификатор родительского меню
        "Изменить значение счётчика", // Название страницы в подменю
        "Изменить", // Название в боковой панели администратора
        "manage_options", // Роль, которой разрешено видеть страницу
        "rewriteCount", // Уникальный идентификатор для подменю
        "rewriteCountPlug" // Функция, которая будет вызвана для вывода страницы
    );

    remove_submenu_page($parent_slug, $parent_slug);
}

add_action("admin_menu", "count_menu");



// Создадим функции вывода списка подписчиков и добавления нового
function rewriteCountPlug()
{
    include "rewriteCount.php";
}
