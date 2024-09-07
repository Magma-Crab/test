<?php
    require_once("NewsPagePrinter.php");
    require_once("DI.php");

    main()
    {
        $di = new DI();
        $di->configure("settings.xml");

        $a = new NewsPagePrinter($di);
        $a->printPage();
    }

    main();
?>
