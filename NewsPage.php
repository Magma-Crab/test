<?php
    require_once("NewsPagePrinter.php");

    $a = new NewsPagePrinter(new MySqlReader());
    $a->printPage();
?>
