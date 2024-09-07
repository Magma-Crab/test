<?php
    require_once("DBReader.php");
    require_once("Row.php");
    require_once("DI.php");

    abstract class PagePrinter
    {
        protected $conn;
        protected int $maxRows = 0;

        public function __construct(
            DI $di
            )
        {
            $this->conn = $di->get(DBReader::class);
            $this->maxRows = $this->conn->countRows();
        }

        abstract public function printPage() : void; 

        protected function prepareHeader() : string
        {
            $logo = 'logo.png';

            $ret = 
                "<header class = 'header'>
                    <img src = 'images/$logo' />
                    <div class = 'header-text'>
                        ГАЛАКТИЧЕСКИЙ<br>
                        ВЕСТНИК
                    </div>
                </header>";

            return $ret;
        }

        protected function prepareFooter() : string
        {
            $ret = 
                "<footer class = 'footer'>
                    © 2023 — 2412 «Галактический вестник»
                </footer>";

            return $ret;
        }
    }
?>