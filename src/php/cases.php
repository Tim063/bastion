<?php

/*
   Plugin Name: Кейсы
   description: Плагин для создания, редактирования и удаления кейсов
   Version: 1.0.0
   Author: Timofey
*/

function cases()
{

    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $tablename = $wpdb->prefix . "cases";

    $sql = "CREATE TABLE $tablename (
        id int(11) NOT NULL AUTO_INCREMENT,
        happen TEXT,
        activity TEXT,
        result TEXT,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

}

register_activation_hook(__FILE__, 'cases');

function cases_menu()
{

    add_menu_page("Кейсы", "Редактор кейсов", "manage_options",
        "cases", "addCases", "dashicons-portfolio");
    add_submenu_page("cases", "Добавить кейс", "Добавить кейс", "manage_options",
        "addCases", "addCases");
    add_submenu_page("cases", "Реадктировать кейс", "Реадктировать кейс",
        "manage_options", "editCases", "editCases");
    add_submenu_page("cases", "Удалить кейс", "Удалить кейс",
    "manage_options", "deleteCases", "deleteCases");
    remove_submenu_page('cases','cases','cases');
}

add_action("admin_menu", "cases_menu");


function addCases()
{
    include "addCases.php";
}

function editCases()
{
    include "editCases.php";
}

function deleteCases()
{
    include "deleteCases.php";
}