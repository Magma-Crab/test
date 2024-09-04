<?php
    require_once("DBReader.php");

    class MySqlReader extends DBReader
    {
        public function __construct(
            string $host,
            string $dbname,
            string $user,
            string $password
         )
        {
            $this->conn = new PDO("mysql:host=$host; dbname=$dbname;", $user, $password);
        }

        public function getRow(int $n) : array
        {
            $q = "SELECT * FROM news ORDER BY date DESC LIMIT 1 OFFSET $n;";
            $q = $this->conn->prepare($q);
            $q->execute();

            $data = $q->fetch(PDO::FETCH_ASSOC);
            
            return $data;
        }

        public function countRows() : int
        {
            $q = 'SELECT COUNT(*) FROM news;';
            $q = $this->conn->prepare($q);
            $q->execute();

            $ret = $q->fetch(PDO::FETCH_ASSOC);
            return $ret['COUNT(*)'];
        }
    }
?>