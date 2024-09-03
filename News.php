<?php
    require_once("MySqlReader.php"); 

    class News
    {
        private array $data = array();

        public function __construct(int $n)
        {
            $r = new MySqlReader();

            $r->getRow($this->data, $n);
        }

        public function getDate()
        {
            return $this->data['date'];
        }
        public function getTitle()
        {
            return $this->data['title'];
        }
        public function getAnnounce()
        {
            return $this->data['announce'];
        }
        public function getContent()
        {
            return $this->data['content'];
        }
        public function getImage()
        {
            return $this->data['image'];
        }
    }    
?>