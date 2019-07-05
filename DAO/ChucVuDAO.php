<?php
include_once '../config/Connection.php';

class ChucVuDAO extends Connection
{
    public function loadAll(){
        try{
            $listChucVu = array();

            $query = "SELECT * FROM chuc_vu";

            $list = $this->execQuery($query);

            while ($row = $list->fetch_array()) {
                $id = $row[0];
                $name = $row[1];
                $chucVu = new ChucVu($id, $name);
                array_push($listChucVu, $chucVu);
            }

            return $listChucVu;
        }
        catch (Exception $e){
            echo $e;
        }
    }

    public function addNew(ChucVu $chucVu){
        try{
            $id = $chucVu->getId();
            $name = $chucVu->getName();

            $query = "INSERT INTO chuc_vu VALUES ($id, '$name')";

            $insert = $this->execNonQuery($query);

            return $insert;
        }
        catch (Exception $e){
            echo $e;
        }
    }

    public function checkDuplicate(ChucVu $chucVu){
        try{
            $id = $chucVu->getId();
            $name = $chucVu->getName();
            $query = "SELECT COUNT(ma_chuc_vu) FROM chuc_vu WHERE ma_chuc_vu = $id OR chuc_vu = '$name'";

            $result = $this->execQuery($query);
            $count = 0;
            while ($row = $result->fetch_array()){
                $count = $row[0];
            }

            return ($count == 0)? false : true;
        }
        catch (Exception $e){
            echo $e;
        }
    }

    public function update(ChucVu $chucVu){
        try{
            $id = $chucVu->getId();
            $name = $chucVu->getName();
            $query = "UPDATE chuc_vu SET chuc_vu = '$name' WHERE ma_chuc_vu = $id";
            return $this->execNonQuery($query);
        }
        catch (Exception $e){
            echo $e;
        }
    }

    public function delete($id){
        try{
            $query = "DELETE FROM chuc_vu WHERE ma_chuc_vu = $id";
            return $this->execNonQuery($query);
        }
        catch (Exception $e){
            echo $e;
        }
    }
}