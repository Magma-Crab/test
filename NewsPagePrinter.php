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
            if($this->verifyPage())
            {
                $this->printError();
                return;
            };
            
            $num = $_GET['num'];
            $news = new Row($this->conn->getRow($num));

            print <<< _HTML_
            <!DOCTYPE html>
            <html>
            _HTML_;
            $this->printHead($news);
            print <<< _HTML_
            <body>
                <div class = "work-area">
            _HTML_;
                $this->printHeader();
                $this->printContent($news);
                $this->printFooter();
            print <<< _HTML_
                </div>
                </body>
            </html>
            _HTML_;
        }
        
        public function printHead(Row $news) : void
        {
            $title = strip_tags($news->getAnnounce());
            print <<< _HTML_
            <head>
                <link rel = "stylesheet" type = "text/css" href = "styles.css">
                <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
                <title>$title</title>
            </head>
            _HTML_;
        }

        public function printContent(Row $news) : void
        {
            $title = $news->getTitle();
            $date = date('d.m.Y', strtotime($news->getDate()));
            $announce = $news->getAnnounce();
            $content = $news->getContent();
            $img = $news->getImage();
    
            print <<< _HTML_
                <div class = "line"></div>
                <div class = "news-path"> 
                    <a href = "index.php">Главная /</a>
                    <div class = "current-news">$title</div>
                </div>
                <h1>$title</h1>
                <div class = "date">$date</div>
                <div class = "content">
                    <div class = "content-left">
                        <h3 class = "content-announce">$announce</h3>
                        $content
                        <a href = index.php class = "back"><div class = "back-arrow"><div></div></div>НАЗАД К НОВОСТЯМ </a>
                    </div>
                    <div class = "content-right">
                        <picture class ="content-image">
                            <img src = "images/$img" />
                        </picture>
                    </div>
                </div>
            _HTML_;
        }

        public function verifyPage() : int
        {
            $error = 0;

            if (!isset($_GET['num']))
            {
                $error = 1;
            }
            else
            {
                $num = $_GET['num'];
                if (!(is_numeric($num) && ($num >= 0) && $num <= $this->maxRows && (int)$num == $num))
                {
                    $error = 1;
                }
            }

            return $error;
        }

        public function printError() : void
        {
            print <<< _HTML_
            <!DOCTYPE html>
            <html>
            <head>
                <link rel = "stylesheet" type = "text/css" href = "styles.css">
                <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
                <title>Ошибка</title>
            </head>
            <body>
                <div class = "work-area">
            _HTML_;
                $this->printHeader();
            print <<< _HTML_
                <h1>
                    Страница не найдена
                </h1>
                <a href = index.php class = "back"> ← НАЗАД К НОВОСТЯМ </a>
            _HTML_;
                $this->printFooter();
            print <<< _HTML_
                </div>
                </body>
            </html>
            _HTML_;
            
        }
    }
?>