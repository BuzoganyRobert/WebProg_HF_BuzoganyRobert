<?php

class Database
{
    private $connection;

    public function __construct($servername, $username, $password, $dbname)
    {
        $this->connection = mysqli_connect($servername, $username, $password, $dbname);

        if (!$this->connection) {
            die("Kapcsolatsi hiba: " . mysqli_connect_error());
        }
    }

    public function getConnection(){
        return $this->connection;
    }
    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }

    public function query($sql){
        return mysqli_query($this->connection, $sql);
    }

    public function closeConnection(){
        mysqli_close($this->connection);
    }
}

class User
{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function closeConnection(){
        $this->db->closeConnection();
    }
}

$servername='localhost';
$username='root';
$password='';
$dbname='allaskereso';

$db=new Database($servername,$username,$password,$dbname);

$user=new User($db);

$user->closeConnection();
?>
