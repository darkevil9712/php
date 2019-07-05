<?php
    include_once '../DAO/ChucVuDAO.php';
    include_once '../DTO/ChucVu.php';

    $flg = $_POST['flg'];
    $dao = new ChucVuDAO();
    // If only 1 object
    if(isset($_POST['id']) || isset($_POST['name'])){
        $chucVu = new ChucVu($_POST['id'], $_POST['name']);
    }
    // If have more than 1 object ( Delete multi)
    else if(isset($_POST['arrChucVu'])){
        $arr = json_decode($_POST['arrChucVu'],true);
    }

    switch ($flg){
        case 'I': // Insert
            if(!$dao->checkDuplicate($chucVu))
                echo $dao->addNew($chucVu);
            else
                echo 'D';
            break;
        case 'U': // Update
            echo $dao->update($chucVu);
            break;
        case 'D': // Delete
            $deleted = 0;
            if(sizeof($arr) > 1){
                foreach($arr as $chucVu){
                    if(isset($chucVu['id']))
                        $deleted = $dao->delete($chucVu['id']);
                }
            }
            if(isset($arr['id']))
                $deleted = $dao->delete($arr['id']);
            echo $deleted;
            break;
    }


?>