<?php
class Database{
    private $host = "localhost";
    private $db_name = "polis";
    private $username = "root";
    private $password = "";
    private $conn;

    public function __construct(){
        $this->conn = null;
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $this->conn;
    }
    public function closeConnection(){
        $this->conn->close();
    }
    
    public function query($queryString){
        $list = array();
        $result = $this->conn->query($queryString);
        if(!$result){
            return false;
        }
        else {
            if(is_bool($result)){
                return true;
            }
           while($obj = $result->fetch_object()){
                array_push($list, $obj);
           }
           return $list;  
        }
    }
   
}
?>