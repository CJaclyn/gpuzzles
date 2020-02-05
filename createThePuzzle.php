<?php

include_once 'db_configuration.php';

if (isset($_POST["submit"])){
    echo "HERE";
    $puzzle_name = mysqli_real_escape_string($db,$_POST['puzzle_name']);
    $creator_name = mysqli_real_escape_string($db,$_POST['creator_name']);
    $author_name = mysqli_real_escape_string($db,$_POST['author_name']);
    $book_name = mysqli_real_escape_string($db,$_POST['book_name']);
    $puzzle_img = basename($_FILES["puzzleToUpload"]["name"]);
    $solution_img = basename($_FILES["solutionToUpload"]["name"]);
    $notes = mysqli_real_escape_string($db,$_POST['notes']);
    $validate = true;

    if($validate){
        $target_dir_1 = "Images/puzzle_images/";
        $target_dir_2 = "Images/solution_images/";
        $target_file_1 = $target_dir_1 . basename($_FILES["puzzleToUpload"]["name"]);
        $target_file_2 = $target_dir_2 . basename($_FILES["solutionToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType1 = strtolower(pathinfo($target_file_1,PATHINFO_EXTENSION));
        $imageFileType2 = strtolower(pathinfo($target_file_2,PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check1 = getimagesize($_FILES["puzzleToUpload"]["tmp_name"]);
            $check2 = getimagesize($_FILES["solutionToUpload"]["tmp_name"]);
            
            if($check1 !== false && $check2 !== false) {
                $uploadOk = 1;
            } 
            else {
                header('location: createPuzzle.php?createPuzzle=fileRealFailed');
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file_1) || file_exists($target_file_2)) {
            header('location: createPuzzle.php?createPuzzle=fileExistFailed');
            //echo "exists image fail";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg"
        && $imageFileType1 != "gif" ) {
            header('location: createPuzzle.php?createPuzzle=fileTypeFailed');
            //echo "type image fail";
            $uploadOk = 0;
        }
        if($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg"
        && $imageFileType2 != "gif" ) {
            header('location: createPuzzle.php?createPuzzle=fileTypeFailed');
            //echo "type image fail";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["puzzleToUpload"]["tmp_name"], $target_file_1) && 
            move_uploaded_file($_FILES["solutionToUpload"]["tmp_name"], $target_file_2)) {
                $sql = "INSERT INTO gpuzzles(`name`,creator_name,author_name,book_name,puzzle_image,solution_image,notes)
                VALUES ('$puzzle_name','$creator_name','$author_name','$book_name','$puzzle_img','$solution_img','$notes')
                ";

                //mysqli_query($db, $sql);
                if(mysqli_query($db, $sql)){
                    header('location: puzzles_list.php?createPuzzle=Success');

                }else {
                    echo "SQL: ".$sql." <br>ERROR:".mysqli_error($db);
                }

            }else {
                echo "Problem with uploading images.";
            }
            }
        }else{
            header('location: createPuzzle.php?createPuzzle=answerFailed');
    }

}//end if

?>
