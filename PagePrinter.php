<?php
    require_once("MySqlReader.php");
    require_once("Row.php");

    abstract class PagePrinter
    {
        public function __construct(
            protected DBReader $conn
            )
        {}

        abstract public function printPage() : void; 

        protected function printHeader() : void
        {
            print <<< _HTML_
                <header class = "header">
                    <img src = "images\logo.png" />
                    <text>
                        ГАЛАКТИЧЕСКИЙ<br>
                        ВЕСТНИК
                    </text>
                </header>
            _HTML_;
        }

        protected function printFooter() : void
        {
            print <<< _HTML_
            <footer class = "footer">
                © 2023-2412 «Галактический вестник»
            </footer>
            _HTML_;
        }
    }
?>