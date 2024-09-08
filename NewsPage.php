<?php
    require_once("NewsPageController.php");
    require_once("DI.php");

    function main() : void
    {
        $di = new DI();
        $di->configure("settings.xml");

        $a = new NewsPageController($di);
        $a->printPage();
    }

    main();
?>
