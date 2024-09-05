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

        protected function printHeader() : void
        {
            print <<< _HTML_
                <header class = "header">
                    <img src = "images\logo.png" />
                    <div>
                        ГАЛАКТИЧЕСКИЙ<br>
                        ВЕСТНИК
                    </div>
                </header>
            _HTML_;
        }

        protected function printFooter() : void
        {
            print <<< _HTML_
            <footer class = "footer">
                © 2023 — 2412 «Галактический вестник»
            </footer>
            _HTML_;
        }
    }
?>