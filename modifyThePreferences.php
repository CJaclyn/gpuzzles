<?php

include_once 'db_configuration.php';

if (isset($_POST['new_rows'])){
    $toshow = mysqli_real_escape_string($db, $_POST['new_show']);
    $rows = mysqli_real_escape_string($db, $_POST['new_rows']);
      
    $sql1 = "UPDATE `preferences` SET `value`= $toshow WHERE `name` = 'NO_OF_PUZZLES_TO_SHOW'";

    $sql2 = "UPDATE `preferences` SET `value`= $rows WHERE `name` = 'NO_OF_PUZZLES_PER_ROW'";

    if(mysqli_query($db, $sql1) && mysqli_query($db, $sql2)) {
        header('location: index.php?preferencesUpdated=Success');
    }else {
        echo "SQL: ".$sql1."<br>ERROR:".mysqli_error($db)."<br>";
        echo "SQL: ".$sql2." <br>ERROR:".mysqli_error($db);
    }
    
}//end if
?>
