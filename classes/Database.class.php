<?php

class Database {

    protected $connect;
    protected $host = 'localhost';
    protected $user = 'root';
    protected $pass = '';
    protected $db = 'xmlimport';
    
    public function __construct(){
        $this->connect = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
    }

    public function db_insert_clients( $data ){
        
        try{
            if( !empty( $this->connect ) ){
                
                $query = "INSERT into tb_clientes (nome, documento, cep, endereco, bairro, cidade, uf, telefone, email, ativo) values (";

                foreach( $data as $key => $value ){
                    
                    if( $key == 'ativo' ){
                        $query .= " '". $value ."' ";
                    }else{
                        $query .= " '". $value ."', ";
                    }
                }
                $query .= ")";
                
                //return $query;
                // set the PDO error mode to exception
                $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connect->exec( $query );
            }
        }
        catch(PDOException $e){
            return 0;
        }
        
        return  1;
    }
        
}