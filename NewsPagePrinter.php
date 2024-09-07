<?php
    require_once('PagePrinter.php');

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
            $error = $this->verifyPage();

            $title = 0;
            $content = 0;
            $news = 0;

            if ($error)
            {
                $title = 'Ошибка';
                $content = $this->prepareError($error);
            }
            else
            {
                $num = $_GET['num'];
                $news = new Row($this->conn->getRow($num));

                $title = strip_tags($news->getAnnounce());
                $content = $this->prepareContent($news);
            }

            $page = 
                "<!DOCTYPE html>
                <html>".
                    $this->prepareHead($title).
                "<body>
                    <div class = 'work-area'>".
                        $this->prepareHeader().
                        $content.
                        $this->prepareFooter().
                    "</div>
                    </body>
                </html>";

            print $page;
        }
        
        public function prepareHead(string $title) : string
        {
            $ret = 
                "<head>
                    <link rel = 'stylesheet' type = 'text/css' href = 'styles.css'>
                    <link href='https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap' rel='stylesheet'>
                    <title>$title</title>
                </head>";

            return $ret;
        }

        public function prepareContent(Row $news) : string
        {
            $title = $news->getTitle();
            $date = date('d.m.Y', strtotime($news->getDate()));
            $announce = $news->getAnnounce();
            $content = $news->getContent();
            $img = $news->getImage();
            
            $ret =
                "<div class = 'line'></div>
                <div class = 'news-path'> 
                    <a href = 'index.php'>Главная /</a>
                    <div class = 'current-news'>$title</div>
                </div>
                <h1>$title</h1>
                <div class = 'date'>$date</div>
                <div class = 'content'>
                    <div class = 'content-left'>
                        <h3 class = 'content-announce'>$announce</h3>
                        $content
                        <a href = index.php class = 'back'><div class = 'back-arrow'><div></div></div>НАЗАД К НОВОСТЯМ </a>
                    </div>
                    <div class = 'content-right'>
                        <picture class ='content-image'>
                            <img src = 'images/$img' />
                        </picture>
                    </div>
                </div>";

            return $ret;
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
                $num = htmlspecialchars($num);
                if (!(is_numeric($num) && ($num >= 0) && $num <= $this->maxRows && (int)$num == $num))
                {
                    $error = 1;
                }
            }

            return $error;
        }

        public function prepareError(int $error) : string
        {
            $ret = 
                "<h1>
                    Страница не найдена
                </h1>
                <a href = index.php class = 'back'><div class = 'back-arrow'><div></div></div>НАЗАД К НОВОСТЯМ </a>";

            return $ret;
        }
    }
?>