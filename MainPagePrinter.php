<?php
    require_once("PagePrinter.php");

    class MainPagePrinter extends PagePrinter
    {
        private int $maxRows = 0;
        private int $newsPerPage = 0;
        private int $currentPage = 0;
        private int $maxPage = 0;

        public function __construct(DI $di)
        {
            parent::__construct($di);
            $this->newsPerPage = $di->get('newsPerPage');

            $this->maxRows = $this->conn->countRows();
            $this->maxPage = ceil($this->maxRows / $this->newsPerPage);

            if (isset($_GET['page']))
            {
                $page = $_GET['page'];
                if (is_numeric($page) && ($page > 0) && $page <= $this->maxPage)
                {
                    $this->currentPage = $page - 1;
                }
            }
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
                $this->printBanner(0);
                $this->printNewsList();
                $this->printPageList();
                $this->printFooter();
            print <<< _HTML_
                </div>
                </body>
            </html>
            _HTML_;
        }

        public function printBanner(int $n) : void
        {
            $news = new Row($this->conn->getRow($n));
    
            $text = $news->getAnnounce();
            $img = $news->getImage();
            $title = $news->getTitle();
    
            print <<< _HTML_
                <div class = "banner">
                    <img src = "images/$img">
                    <div class = "banner-text">
                        <h1>$title</h1>
                        $text
                    </div>
                </div>
            _HTML_;
        }

        public function printNewsList() : void
        {    
            print <<< _HTML_
                <h2>Новости</h2>
                <div class = "news-list">
            _HTML_;
    
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
    
                print <<< _HTML_
                    <form action = "NewsPage.php" method = "GET">
                        <button class = "news" type = "submit" name = "num" value = "$num">
                            <div class = "date">$date</div>
                            <h3>$title</h3>
                            <div class = "announce">$announce</div>
                            <div class = "more">ПОДРОБНЕЕ →</div>
                        </button>
                    </form>
                _HTML_;
            }
            
            print <<< _HTML_
                </div>
            _HTML_;
        }

        public function printPageList() : void
        {    
            print <<< _HTML_
                <div class = "page-num-block">
            _HTML_;
    
            for ($i = 1; $i < $this->maxPage + 1; $i++)
            {
                print <<< _HTML_
                    <form action="index.php" method="GET">
                        <button class="page-num" type="submit" name = "page" value="$i">$i</button>
                    </form>
                _HTML_;
            }
            if ($this->currentPage * $this->newsPerPage + 1 < $this->maxRows)
            {
                $nextPage = $this->currentPage + 2;
                print <<< _HTML_
                    <form action="index.php" method="GET">
                        <button class="page-num" type="submit" name = "page" value="$nextPage">→</button>
                    </form>
                _HTML_;
            }
            print <<< _HTML_
                </div>
            _HTML_;
        }
    }
?>