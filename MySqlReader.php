<?php
    class MySqlReader
    {
        private $conn;

        public function __construct()
        {
            $this->conn = new PDO('mysql:host=localhost; dbname=news;', 'root', 'admin');
        }

        public function getRow(array &$data, int $n) : int
        {
            $q = "SELECT * FROM news ORDER BY date DESC LIMIT 1 OFFSET $n;";
            $q = $this->conn->prepare($q);
            $q->execute();

            $data = $q->fetch(PDO::FETCH_ASSOC);
            
            return 0;
        }

        public function countRows() : int
        {
            $q = 'SELECT COUNT(*) FROM news;';
            $q = $this->conn->prepare($q);
            $q->execute();

            $ret = $q->fetch(PDO::FETCH_ASSOC);
            return $ret['COUNT(*)'];
        }

        public function execute(array &$data, string $query)
        {
            $query = $this->conn->prepare($query);
            $query->execute();

            $data = $query->fetch(PDO::FETCH_ASSOC);
        }
    }
?>