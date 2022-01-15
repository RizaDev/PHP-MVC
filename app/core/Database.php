<?php 


class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;


    private $dbh;
    private $stmt;

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db_name";

        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

        ];

        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }
    //Filterisasi parameter database 
    //agar terhindar dari injeksi database
    public function bind($param, $value, $tipe = null){

        if (is_null($tipe)){
            switch(true){
                case is_int($value) :
                    $tipe = PDO::PARAM_INT;
                    break;
                case is_bool($value) :
                    $tipe = PDO::PARAM_BOOL;
                    break;
                case is_null($value) :
                    $tipe = PDO::PARAM_NULL;
                    break;
                default :
                    $tipe = PDO::PARAM_STR;
            }
        }


        $this->stmt->bindValue($param, $value, $tipe);

    }

    //Eksekusi database
    public function execute(){
        $this->stmt->execute();
    }


    //METHOD UNTUK MENDAPATKAN SEMUA DATA DARI DATABASE
    //Return Array Assosiative
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Return 1 array assosiative
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowChange(){
        return $this->stmt->rowCount();
    }




}