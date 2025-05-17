<?php

class Database
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/app/config/db.sqlite');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function getPDO() {
        return $this->db;
    }

}
