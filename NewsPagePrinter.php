<?php
    require_once("PagePrinter.php");

    class NewsPagePrinter extends PagePrinter
    {
        public function __construct(
            DI $di
            )
        {
            parent::__construct($di);
        }

        public function printPage() : void
        {
            print <<< _HTML_
            <html>
            <head>
                <link rel = "stylesheet" type = "text/css" href = "styles.css">
        
                <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
            </head>
            <body>
                <div class = "work-area">
            _HTML_;
                $this->printHeader();
                if($this->printContent())
                {
                    $this->printError();
                };
                $this->printFooter();
            print <<< _HTML_
                </div>
                </body>
            </html>
            _HTML_;
        }
        
        public function printContent() : int
        {
            $error = 0;

            if (!isset($_GET['num']))
            {
                $error = 1;
            }

            $num = $_GET['num'];

            if (!(is_numeric($num) && ($num >= 0) && $num <= $this->maxRows && (int)$num == $num))
            {
                $error = 1;
            }

            if ($error)
            {
                return $error;
            }

            $news = new Row($this->conn->getRow($num));
    
            $title = $news->getTitle();
            $date = date('d.m.Y', strtotime($news->getDate()));
            $announce = $news->getAnnounce();
            $content = $news->getContent();
            $img = $news->getImage();
    
            print <<< _HTML_
                <div class = "news-path"> 
                    <a href = "index.php">Главная /</a>
                    <span class = "current-news">$title</span>
                </div>
                <h1>$title</h1>
                <div class = "date">$date</div>
                <div class = "content">
                    <div class = "content-text">
                        <h3 class = "content-announce">$announce</h3>
                        <div>$content</div>
                    </div>
                    <picture class = "content-image">
                        <img src = "images/$img" /> 
                    </picture>
                </div>
                <a href = index.php class = "back"> ← Назад к новостям </a>
            _HTML_;

            return 0;
        }

        public function printError() : void
        {
            print <<< _HTML_
                <h1>
                    Страница не найдена
                </h1>
                <a href = index.php class = "back"> ← Назад к новостям </a>
            _HTML_;
        }
    }
?>