<?php
global $wpdb;
$tablename = $wpdb->prefix . "cases";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_case'])) {
    $update_id = $_POST['update_id'];
    // Обновляем существующий кейс
    $category = sanitize_text_field($_POST['category_' . $update_id]);
    $happen = sanitize_text_field($_POST['happen_' . $update_id]);
    $activity = sanitize_text_field($_POST['activity_' . $update_id]);
    $result = sanitize_text_field($_POST['result_' . $update_id]);

    if (!empty($happen) && !empty($activity) && !empty($result)) {
        $wpdb->update(
            $tablename,
            array(
                'category' => $category,
                'happen' => $happen,
                'activity' => $activity,
                'result' => $result
            ),
            array('id' => $update_id),
            array('%s', '%s', '%s', '%s'),
            array('%d')
        );
    }
}

// Получаем список всех кейсов
$casesList = $wpdb->get_results("SELECT * FROM $tablename ORDER BY id DESC");
?>

<style>
    .edit-area {
        width: 100%;
    }

    .w30{
        width: 30%;
    }

    .edit-save {
        font-size: 20px;
        color: #1E1F1E;
        text-align: center;
        font-weight: bold;
        cursor: pointer; /* Добавлено */
        text-decoration: none; /* Добавлено */
        padding: 5px 10px;
        border: none;
        background-color: #f0f0f0;
    }

    .edit-row {
        display: table-row;
        margin-left: auto;
        margin-right: auto;
    }

    .edit-cell {
        display: table-cell;
        padding: 5px;
        border: 1px solid black;
        vertical-align: middle; /* Центрируем содержимое по вертикали */
        text-align: center; /* Центрируем содержимое по горизонтали */
    }
</style>

<h1>Редактировать кейсы</h1>

<div style="display: table; width: 100%;">
    <?php
    if (count($casesList) > 0) {
        $count = 1;
        foreach ($casesList as $case) {
            $id = $case->id;
            $category = $case->category;
            $happen = $case->happen;
            $activity = $case->activity;
            $result = $case->result;

            echo "<form method='post'>
                <div class='edit-row'>
                    <div class='edit-cell'>$count</div>
                    <div class='edit-cell' style='width:200px;'><input name='category_$id' value='$category'></div>
                    <div class='edit-cell w30'><textarea name='happen_$id' rows='15' cols='30' class='edit-area'>$happen</textarea></div>
                    <div class='edit-cell w30'><textarea name='activity_$id' rows='15' cols='30' class='edit-area'>$activity</textarea></div>
                    <div class='edit-cell w30'><textarea name='result_$id' rows='15' cols='30' class='edit-area'>$result</textarea></div>
                    <div class='edit-cell'>
                        <button type='submit' class='edit-save' name='update_case' data-id='$id'>Сохранить</button>
                        <input type='hidden' name='update_id' value='$id'>
                    </div>
                </div>
            </form>";
            $count++;
        }
    } else {
        echo "<div class='edit-row'><div class='edit-cell' colspan='5'>Нет кейсов</div></div>";
    }
    ?>
</div>
