<?php
    class News
    {
        public function __construct(
            private array $data
            )
        {}

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
        public function getHref()
        {
            return $this->data['href'];
        }
    }    
?>