<?php

global $wpdb;
$tablename = $wpdb->prefix."cases";

if(isset($_GET['delete_id'])){
    $delid = $_GET['delete_id'];
    $wpdb->query("DELETE FROM ".$tablename." WHERE id=".$delid);
}
?>
<h1>Все кейсы</h1>

<table width='100%' border='1' style='border-collapse: collapse;'>
    <tr>
        <th>№</th>
        <th>Категория</th>
        <th>Что случилось</th>
        <th>Проведенная работа</th>
        <th>Результат</th>
        <th>&nbsp;</th>
    </tr>
    <?php
    $casesList = $wpdb->get_results("SELECT * FROM ".$tablename." order by id desc");
    if(count($casesList) > 0){
        $count = 1;
        foreach($casesList as $case){
            $id = $case->id;
            $category = $case->category;
            $happen = $case->happen;
            $activity = $case->activity;
            $result = $case->result;

            echo "<tr>
      <td>".$count."</td>
      <td>".$category."</td>
      <td>".$happen."</td>
      <td>".$activity."</td>
      <td>".$result."</td>
      <td><a href='?page=deleteCases&delete_id=".$id."'>Удалить</a></td>
      </tr>
      ";
            $count++;
        }
    }else{
        echo "<tr><td colspan='5'>Нет кейсов</td></tr>";
    }
    ?>
</table>