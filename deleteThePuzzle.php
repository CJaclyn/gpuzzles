<?php

include_once 'db_configuration.php';

if (isset($_POST['id'])){

    $id = mysqli_real_escape_string($db, $_POST['id']);
    $file1 = mysqli_real_escape_string($db, $_POST['puzz_img_name']);
    $file2 = mysqli_real_escape_string($db, $_POST['sol_img_name']);

    unlink($file1);
    unlink($file2);

    $sql = "DELETE FROM gpuzzles
            WHERE id = '$id'";

    if(mysqli_query($db, $sql)){
        header('location: puzzles_list.php?questionDeleted=Success');
    }else {
        echo "SQL: ".$sql." <br>ERROR:".mysqli_error($db);
    }
    
}//end if
?>

