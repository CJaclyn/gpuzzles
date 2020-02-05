<?php

include_once 'db_configuration.php';

if (isset($_POST["submit"])){
    $id = mysqli_real_escape_string($db, $_POST['id']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $creatorName = mysqli_real_escape_string($db, $_POST['creatorName']);
    $authorName = mysqli_real_escape_string($db, $_POST['authorName']);
    $bookName = mysqli_real_escape_string($db, $_POST['bookName']);
    $notes = mysqli_real_escape_string($db, $_POST['notes']);
    $oldPuzzleImg = mysqli_real_escape_string($db, $_POST['oldPuzzleImg']);
    $oldSolutionImg = mysqli_real_escape_string($db, $_POST['oldSolutionImg']);
    $puzzleImg = basename($_FILES["puzzleToUpload"]["name"]);
    $solutionImg = basename($_FILES["solutionToUpload"]["name"]);
    $validate = true;
    
    
    if($validate){
        /************************ IF AT LEAST ONE IMAGE UPLOADED ************************/
        if(isset($puzzleImg) || isset($solutionImg)){
            $target_dir_1 = "Images/puzzle_images/";
            $target_dir_2 = "Images/solution_images/";
            $target_file_1 = $target_dir_1 . basename($_FILES["puzzleToUpload"]["name"]);
            $target_file_2 = $target_dir_2 . basename($_FILES["solutionToUpload"]["name"]);
            $imageFileType1 = strtolower(pathinfo($target_file_1,PATHINFO_EXTENSION));
            $imageFileType2 = strtolower(pathinfo($target_file_2,PATHINFO_EXTENSION));
            $check1 = getimagesize($_FILES["puzzleToUpload"]["tmp_name"]);
            $check2 = getimagesize($_FILES["solutionToUpload"]["tmp_name"]);
            $uploadOk = 1;

            // Check if file already exists
            if (file_exists($target_file_1) || file_exists($target_file_2)) {
                header('location: modifyPuzzle.php?modifyPuzzle=fileExistFailed');
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg"
            && $imageFileType1 != "gif" ) {
                header('location: modifyPuzzle.php?modifyPuzzle=fileTypeFailed');
                $uploadOk = 0;
            }
            if($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg"
            && $imageFileType2 != "gif" ) {
                header('location: modifyPuzzle.php?modifyPuzzle=fileTypeFailed');
                $uploadOk = 0;
            }

            /***** IF USER UPLOADS BOTH PUZZLE & SOLUTION IMAGE *****/
            if($puzzleImg != "" && $solutionImg != ""){
                unlink($oldPuzzleImg);
                unlink($oldSolutionImg);
                $uploadOk = 1;

                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    if($check1 !== false && $check2 !== false) {
                        $uploadOk = 1;
                    }else {
                        header('location: modifyPuzzle.php?modifyPuzzle=fileRealFailed');
                        $uploadOk = 0;
                    }
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                // if everything is ok, try to upload file
                }else {
                    if (move_uploaded_file($_FILES["puzzleToUpload"]["tmp_name"], $target_file_1) &&
                        move_uploaded_file($_FILES["solutionToUpload"]["tmp_name"], $target_file_2)) { 
    
                        $sql = "UPDATE gpuzzles
                        SET `name` = '$name',
                            creator_name = '$creatorName',
                            author_name = '$authorName',
                            book_name = '$bookName',
                            puzzle_image = '$puzzleImg',
                            solution_image = '$solutionImg',
                            notes = '$notes'       
                        WHERE id = '$id'";
    
                        //mysqli_query($db, $sql);
                        if(mysqli_query($db, $sql)) {
                            header('location: puzzles_list.php?puzzleUpdated=Success');
                        }else {
                            echo "SQL: ".$sql." <br>ERROR:".mysqli_error($db);
                        }
                    }else {
                        echo "<p>Uploaded images were unsuccesfully moved.</p>";
                    }
                }

            /***** IF USER ONLY UPLOADS PUZZLE IMAGE *****/    
            }elseif($puzzleImg != "") {
                $uploadOk = 1;
                unlink($oldPuzzleImg);

                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    if($check1 !== false) {
                        $uploadOk = 1;
                    }else {
                        header('location: modifyPuzzle.php?modifyPuzzle=fileRealFailed');
                        $uploadOk = 0;
                    }
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    // if everything is ok, try to upload file
                    }else {
                        if (move_uploaded_file($_FILES["puzzleToUpload"]["tmp_name"], $target_file_1)) { 
        
                            $sql = "UPDATE gpuzzles
                            SET `name` = '$name',
                                creator_name = '$creatorName',
                                author_name = '$authorName',
                                book_name = '$bookName',
                                puzzle_image = '$puzzleImg',
                                notes = '$notes'       
                            WHERE id = '$id'";
        
                            //mysqli_query($db, $sql);
                            if(mysqli_query($db, $sql)) {
                                header('location: puzzles_list.php?puzzleUpdated=Success');
                            }else {
                                echo "SQL: ".$sql." <br>ERROR:".mysqli_error($db);
                            }
                        }else {
                            echo "<p>Uploaded image was unsuccesfully moved.</p>";
                        }
                    }
            
            /***** IF USER ONLY UPLOADS SOLUTION IMAGE *****/
            }elseif($solutionImg != ""){
                $uploadOk = 1;
                unlink($oldSolutionImg);

                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    if($check2 !== false) {
                        $uploadOk = 1;
                    }else {
                        header('location: modifyPuzzle.php?modifyPuzzle=fileRealFailed');
                        $uploadOk = 0;
                    }
                }

                if ($uploadOk == 0) {
                    // if everything is ok, try to upload file
                    }else {
                        if (move_uploaded_file($_FILES["solutionToUpload"]["tmp_name"], $target_file_2)) { 
        
                            $sql = "UPDATE gpuzzles
                            SET `name` = '$name',
                                creator_name = '$creatorName',
                                author_name = '$authorName',
                                book_name = '$bookName',
                                solution_image = '$solutionImg',
                                notes = '$notes'       
                            WHERE id = '$id'";
        
                            //mysqli_query($db, $sql);
                            if(mysqli_query($db, $sql)) {
                                header('location: puzzles_list.php?puzzleUpdated=Success');
                            }else {
                                echo "SQL: ".$sql." <br>ERROR:".mysqli_error($db);
                            }
                        }else {
                            echo "<p>Uploaded image was unsuccesfully moved.</p>";
                        }
                    }
            }

        /************************ IF NO IMAGE(S) UPLOADED ************************/
        }else{
            //$image = $_SESSION["image"];
            
                $sql = "UPDATE gpuzzles SET 
                    id = '$id',
                    `name` = '$name',
                    creator_name = '$creatorName',
                    author_name = '$authorName',
                    book_name = '$bookName',
                    notes = '$notes'
                WHERE id = '$id'";

                //mysqli_query($db, $sql);
                if(mysqli_query($db, $sql)) {
                    header('location: puzzles_list.php?puzzleUpdated=Success');
                }else {
                    echo "SQL: ".$sql." <br>ERROR:".mysqli_error($db);
                }
                }
    }else{
        header('location: modifyPuzzle.php?modifyPuzzle=answerFailed&id='.$id);}
}//end if

?>
