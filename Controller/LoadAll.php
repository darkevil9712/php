<?php
    include_once '../DTO/ChucVu.php';
    include_once '../DAO/ChucVuDAO.php';

    $dao = new ChucVuDAO();

    $listResult = $dao->loadAll();

    //Parse json UTF-8
    foreach($listResult as $obj) {
        if($obj->getId() != null || $obj->getId() != ""){
            $listResultJSON[] = array(
                'id' => $obj->getId(),
                'name' => $obj->getName(),
            );
        }

    }

    echo json_encode($listResultJSON, JSON_UNESCAPED_UNICODE);

?>