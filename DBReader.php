<?php
    abstract class DBReader
    {
        private int $connection;

        function __construct()
        {
            
        }

        abstract function getData(array &$data) : int;
    }
?>