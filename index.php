<?php
    require_once("MainPagePrinter.php");
    require_once("DI.php");

    $di = new DI();
    $di->configure("settings.xml");

    $a = new MainPagePrinter($di);
    $a->printPage();
?>