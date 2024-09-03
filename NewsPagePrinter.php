<?php
    require_once("PagePrinter.php");

    class NewsPagePrinter extends PagePrinter
    {
        public function __construct(
            DBReader $conn
            )
        {
            parent::__construct($conn);
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
                $this->printContent();
                $this->printFooter();
            print <<< _HTML_
                </div>
                </body>
            </html>
            _HTML_;
        }
        
        public function printContent() : void
        {
            $num = $_GET['num'];
            $news = $news = new Row($this->conn->getRow($num));
    
            $title = $news->getTitle();
            $date = date('d.m.Y', strtotime($news->getDate()));
            $announce = $news->getAnnounce();
            $content = $news->getContent();
            $img = $news->getImage();
    
            print <<< _HTML_
                <div> 
                    Главная \ $title
                </div>
                <div class = "title">$title</div>
                <div class = "date">$date</div>
                <div>
                    <div>$announce</div>
                    <div>$content</div>
                    <img src = "images/$img" />
                </div>
                <a href = index.php class = "more"> ← Назад к новостям </a>
            _HTML_;
        }
    }
?>