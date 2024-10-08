<?php
    require_once("News.php");

    abstract class PageView
    {
        public function __construct()
        {}

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