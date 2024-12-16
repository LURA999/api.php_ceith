<?php
//date_default_timezone_set('America/Tijuana');

class Database
{

    private $host;
    private $db;
    private $user;
    private $password;
    
    public function __construct()
    {
        $this->host = 'localhost';
        $this->db = 'ceith';
        $this->user = 'root';
        $this->password = '';
    }

    function connect()
    {
        try {
            $con = new PDO(
                "mysql:host=".$this->host.";port=3306;dbname=".$this->db.";",
                $this->user,
                $this->password
            );
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

        function getParams($input)
        {
            $filterParams = [];
            foreach ($input as $param => $value) {
                $filterParams[] = "$param=:$param";
            }
            return implode(", ", $filterParams);
        }
    }
}
