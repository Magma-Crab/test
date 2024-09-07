<?php
    require_once("PagePrinter.php");

    class MainPagePrinter extends PagePrinter
    {
        private int $newsPerPage = 0;
        private int $currentPage = 0;
        private int $maxPage = 0;

        public function __construct(DI $di)
        {
            parent::__construct($di);
            $this->newsPerPage = $di->get('newsPerPage');
            $this->maxPage = ceil($this->maxRows / $this->newsPerPage);

            if (isset($_GET['page']))
            {
                $page = $_GET['page'];
                $page = htmlspecialchars($page);
                if (is_numeric($page) && ($page > 0) && $page <= $this->maxPage && (int)$page == $page)
                {
                    $this->currentPage = $page - 1;
                }
            }
        }

        public function printPage() : void
        {
            $page = 
                "<!DOCTYPE html>
                <html>".
                    $this->prepareHead().
                    "<body>
                        <div class = 'work-area'>".
                            $this->prepareHeader().
                            $this->prepareBanner(0).
                            $this->prepareNewsList().
                            $this->preparePageList().
                            $this->prepareFooter().
                        "</div>
                    </body>
                </html>";

            print $page;
        }

        public function prepareHead() : string
        {
            $title = 'Галактический Вестник';

            $ret = 
                "<head>
                    <link rel = 'stylesheet' type = 'text/css' href = 'styles.css'>
                    <link href='https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap' rel='stylesheet'>
                    <title>$title</title>
                </head>";

            return $ret;
        }

        public function prepareBanner(int $n) : string
        {
            $news = new Row($this->conn->getRow($n));
    
            $text = $news->getAnnounce();
            $img = $news->getImage();
            $title = $news->getTitle();
    
            $ret =
                "<div class = 'banner'>
                    <img src = 'images/$img'>
                    <div class = 'banner-text'>
                        <h1>$title</h1>
                        $text
                    </div>
                </div>";

            return $ret;
        }

        public function prepareNewsList() : string
        {    
            $ret =
                "<h2>Новости</h2>
                <div class = 'news-list'>";
    
            for ($i = 0; $i < $this->newsPerPage; $i++)
            {
                $num = $this->currentPage * $this->newsPerPage + $i;
    
                if ($num >= $this->maxRows)
                {
                    break;
                }
                
                $news = new Row($this->conn->getRow($num));
    
                $date = $news->getDate();
                $date = date('d.m.Y', strtotime($date));
                $title = $news->getTitle();
                $announce = $news->getAnnounce();
                
                $page = $this->currentPage + 1;

                $ret .=
                    "<a href = 'NewsPage.php?num=$num&page=$page' class = 'news'>
                        <div>
                            <div class = 'date'>$date</div>
                            <h3>$title</h3>
                            <div class = 'announce'>$announce</div>
                        </div>
                        <div class ='more-block'>
                            <div class = 'more'>ПОДРОБНЕЕ
                                <div class = 'more-arrow'><div></div></div>
                            </div>
                        </div>
                    </a>";
            }

            $ret .= 
                "</div>";

            return $ret;
        }

        public function preparePageList() : string
        {    
            $ret =
                "<div class = 'navigation'>";

            for ($i = 1; $i < $this->maxPage + 1; $i++)
            {
                $navigationNumStyle = 'navigation-num';
                if ($i == $this->currentPage + 1) $navigationNumStyle = 'navigation-current';

                $ret .=
                    "<a href = 'index.php?page=$i' class = '$navigationNumStyle'>$i</a>";
            }
            if ($this->currentPage * $this->newsPerPage + 1 < $this->maxRows)
            {
                $nextPage = $this->currentPage + 2;
                
                $ret .=
                    "<a href = 'index.php?page=$nextPage' class = 'navigation-arrow'><div></div></a>";
            }

            $ret .= 
                "</div>";

            return $ret;
        }
    }
?>