<?php
    require_once("NewsPagePrinter.php");
    require_once("DI.php");

    function main() : void
    {
        $di = new DI();
        $di->configure("settings.xml");

        $a = new NewsPagePrinter($di);
        $a->printPage();
    }

    main();
?>
