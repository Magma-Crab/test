<?php
    abstract class DBReader
    {
        protected $conn;

        abstract public function getRow(int $n) : array;

        abstract public function countRows() : int;
    }
?>