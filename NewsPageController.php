<?php
    require_once("PageController.php");
    require_once("NewsPageView.php");

    class NewsPageController extends PageController
    {
        private ?News $news = null;
        private int $error = 0;
        private string $title = 'Ошибка';

        public function __construct(
            DI $di
            )
        {
            parent::__construct($di);

            $this->error = $this->verifyPage();

            if (!$this->error)
            {
                $this->news = $this->prepareContent();
                $this->title = $this->news->getTitle();
            }
        }

        public function printPage() : void
        {   
            $page = new NewsPageView($this->news, $this->title, $this->error);
            $page->printPage();
        }

        private function prepareContent() : News
        {
            $num = $_GET['num'];
            $page = $_GET['page'];
            $href = "index.php?page=$page";

            $news = $this->prepareNews($this->conn->getRow($num), $href);

            return $news;
        }

        private function verifyPage() : int
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
    }
?>