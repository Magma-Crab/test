<?php
    require_once("MainPageController.php");

    function main() : void
    {
        $di = new DI();
        $di->configure("settings.xml");

        $a = new MainPageController($di);
        $a->printPage();
    }

    main();
?>