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

    function execQuery($query){
        $cn = $this->Connect() or die ('Không thể kết nối tới DataProviderMain');
        mysqli_set_charset($cn, 'UTF8');
        $result = $cn->query($query);
        if (!$result) {
            die ('Câu truy vấn bị sai');
        }
        return $result;
    }

    function execNonQuery($query){
        $cn = $this->Connect() or die ('Không thể kết nối tới DataProviderMain');
        mysqli_set_charset($cn, 'UTF8');
        if (!mysqli_query($cn, $query))
            die("Lỗi truy vấn: " . mysqli_error());
        $affected_rows = mysqli_affected_rows($cn);
        mysqli_close($cn);
        return $affected_rows;
    }

}