<?php
    require_once("MainPagePrinter.php");

    $a = new MainPagePrinter(new MySqlReader());
    $a->printPage();
?>