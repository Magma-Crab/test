<?php
    require_once("DI.php");
    require_once("MainPageView.php");
    require_once("News.php");   

    class MainPageController
    {
        private int $newsPerPage = 0;
        private int $currentPage = 1;
        private int $maxPage = 0;
        private int $maxRows = 0;
        private DBReader $conn;

        public function __construct(DI $di)
        {
            $this->conn = $di->get(DBReader::class);
            $this->newsPerPage = $di->get('newsPerPage');
            
            $this->maxRows = $this->conn->countRows();            
            $this->maxPage = ceil($this->maxRows / $this->newsPerPage);

            $this->currentPage = $this->verifyPage();
        }

        private function verifyPage() : int
        {
            if (isset($_GET['page']))
            {
                $page = $_GET['page'];
                $page = htmlspecialchars($page);

                if (is_numeric($page) && ($page > 0) && $page <= $this->maxPage && (int)$page == $page)
                {
                    return $page;
                }
            }

            return 1;
        }

        public function printPage() : void
        {
            $newsList = $this->prepareNewsList();
            $banner = $this->prepareBanner(0);
            $pageList = $this->preparePageList();

            $page = new MainPageView($newsList, $pageList, $banner, $this->currentPage);
            $page->printPage();
        }

        private function prepareNews(array $row, string $href = 'index.php') : News
        {
            $date = $row['date'];
            $date = date('d.m.Y', strtotime($date));
            $row['date'] = $date;

            $row['href'] = $href;

            return new News($row);
        }

        private function prepareBanner(int $n) : News
        {
            return $this->prepareNews($this->conn->getRow($n));
        }

        private function prepareNewsList() : array
        {    
            $newsList = array();
                        
            for ($i = 0; $i < $this->newsPerPage; $i++)
            {         
                $num = $this->newsPerPage * ($this->currentPage - 1) + $i;

                if ($num >= $this->maxRows)
                {
                    break; 
                }

                $href = "NewsPage.php?num=$num&page=$this->currentPage";

                $newsList[$i] = $this->prepareNews($this->conn->getRow($num), $href);
            }

            return $newsList;
        }

        private function preparePageList() : array
        {
            $pages = array();

            for ($i = 1; $i <= $this->maxPage; $i++)
            {
                $href = "index.php?page=$i";
                $pages[$i] = $href;
            }

            $ret[0] = $pages;
            
            if ($this->currentPage < $this->maxPage)
            {
                $nextPage = $this->currentPage + 1;
                $href = "index.php?page=$nextPage";
                $ret[1] = $href;
            }

            return $ret;
        }
    }
?>