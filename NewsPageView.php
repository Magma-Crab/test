<?php
    require_once("PageView.php");

    class NewsPageView extends PageView
    {
        public function __construct(
                private ?News $news, 
                private string $title, 
                private int $error
            )
        {}

        public function printPage() : void
        {
            $content = 0;

            if ($this->error)
            {
                $content = $this->prepareError($this->error);
            }
            else
            {
                $content = $this->prepareContent();
            }

            $page = 
                "<!DOCTYPE html>
                <html>".
                    $this->prepareHead().
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

        private function prepareHead() : string
        {
            $ret = 
                "<head>
                    <link rel = 'stylesheet' type = 'text/css' href = 'styles.css'>
                    <link href='https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap' rel='stylesheet'>
                    <title>$this->title</title>
                </head>";

            return $ret;
        }

        private function prepareContent() : string
        {
            $title = $this->news->getTitle();
            $date = $this->news->getDate();
            $announce = $this->news->getAnnounce();
            $content = $this->news->getContent();
            $img = $this->news->getImage();
            $href = $this->news->getHref();

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
                        <a href = '$href' class = 'back'><div class = 'back-arrow'><div></div></div>НАЗАД К НОВОСТЯМ </a>
                    </div>
                    <div class = 'content-right'>
                        <picture class ='content-image'>
                            <img src = 'images/$img' />
                        </picture>
                    </div>
                </div>";

            return $ret;
        }

        private function prepareError(int $error) : string
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