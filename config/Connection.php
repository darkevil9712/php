<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/06/24
 * Time: 13:33
 */

class Connection
{
    private $host="localhost:3306";
    private $username="root";
    private $password="";
    private $db="dienthoai";

    function Connect(){
        $connect = mysqli_connect($this->host, $this->username, $this->password, $this->db);
        return $connect;
    }

    function Disconnect(){
        if(Connect() != null)
            mysqli_close(Connect());
    }

    
}