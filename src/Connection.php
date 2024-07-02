<?php

namespace App;

use \PDO;

class Connection
{

    public static function getPDO(): PDO
    {
        return new PDO('mysql:dbname=ptcnmeau_admin;host=localhost', 'toto', 'toto', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
    }
}
