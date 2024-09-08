<?php
    require_once("DBReader.php");
    require_once("DI.php");
    require_once("PageView.php");
    require_once('News.php');

    abstract class PageController
    {
        protected DBReader $conn;
        protected int $maxRows = 0;

        public function __construct(
            DI $di
            )
        {
            $this->conn = $di->get(DBReader::class);
            $this->maxRows = $this->conn->countRows();
        }

        abstract public function printPage() : void; 

        protected function prepareNews(array $row, string $href = 'index.php') : News
        {
            $date = $row['date'];
            $date = date('d.m.Y', strtotime($date));
            $row['date'] = $date;

            $row['href'] = $href;

            return new News($row);
        }
    }
?>