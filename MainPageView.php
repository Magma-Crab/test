<?php
    require_once("PageView.php");

    class MainPageView extends PageView
    {
        public function __construct(
            private array $newsList,
            private array $pageList,
            private News $banner,
            private int $currentPage
        )
        {}
        
        public function printPage() : void
        {
            $page = 
                    "<!DOCTYPE html>
                    <html>".
                        $this->prepareHead().
                        "<body>
                            <div class = 'work-area'>".
                                $this->prepareHeader().
                                $this->prepareBanner().
                                $this->prepareNewsList().
                                $this->preparePageList().
                                $this->prepareFooter().
                            "</div>
                        </body>
                    </html>";

                print $page;
        }

        private function prepareHead() : string
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

        private function prepareBanner() : string
        {
            $news = $this->banner;

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

        private function prepareNewsList() : string
        {
            $ret =
                "<h2>Новости</h2>
                <div class = 'news-list'>";

            foreach ($this->newsList as $news)
            {
                $date = $news->getDate();
                $title = $news->getTitle();
                $announce = $news->getAnnounce();
                $href = $news->getHref();

                $ret .=
                    "<a href = '$href' class = 'news'>
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

        private function preparePageList() : string
        {
            $ret =
                    "<div class = 'navigation'>";
            
            $pageList = $this->pageList[0];

            foreach ($pageList as $pageNum => $pageHref)
            {
                $navigationNumStyle = 
                    $pageNum == $this->currentPage ? 'navigation-current': 'navigation-num';

                $ret .=
                        "<a href = '$pageHref' class = '$navigationNumStyle'>$pageNum</a>";
            }

            if (isset($this->pageList[1]))
            {
                $href = $this->pageList[1];

                $ret .=
                    "<a href = '$href' class = 'navigation-arrow'><div></div></a>";
            }

            $ret .= 
                    "</div>";

            return $ret;
        }
    }

?>