<?php
    require_once("PageController.php");
    require_once("MainPageView.php");

    class MainPageController extends PageController
    {
        private int $newsPerPage = 0;
        private int $currentPage = 1;
        private int $maxPage = 0;

        public function __construct(DI $di)
        {
            parent::__construct($di);

            $this->newsPerPage = $di->get('newsPerPage');           
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