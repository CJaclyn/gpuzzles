<?php $page_title = 'Gpuzzles > Create Puzzle'; ?>
<?php
    require 'bin/functions.php';
    require 'db_configuration.php';
    include('header.php');
    $page="puzzles_list.php";
    verifyLogin($page);

?>
<?php
    $mysqli = NEW MySQLi('localhost','root','12345','gpuzzles_db');
    $resultset = $mysqli->query("SELECT DISTINCT topic FROM topics ORDER BY topic ASC");
?>
<link href="css/form.css" rel="stylesheet">
<style>#title {text-align: center; color: darkgoldenrod;}</style>
<div class="container">
    <?php
    if(isset($_GET['createPuzzle'])){
        if($_GET["createPuzzle"] == "fileRealFailed"){
            echo '<br><h3 align="center" class="bg-danger">FAILURE - Your image is not real, Please Try Again!</h3>';
        }
    }
    if(isset($_GET['createPuzzle'])){
        if($_GET["createPuzzle"] == "answerFailed"){
            echo '<br><h3 align="center" class="bg-danger">FAILURE - Your answer was not one of the choices, Please Try Again!</h3>';
        }
    }
    if(isset($_GET['createPuzzle'])){
        if($_GET["createPuzzle"] == "fileTypeFailed"){
            echo '<br><h3 align="center" class="bg-danger">FAILURE - Your image is not a valid image type (jpg,jpeg,png,gif), Please Try Again!</h3>';
        }
    }
    if(isset($_GET['createPuzzle'])){
        if($_GET["createPuzzle"] == "fileExistFailed"){
            echo '<br><h3 align="center" class="bg-danger">FAILURE - Your image does not exist, Please Try Again!</h3>';
        }
    }

    ?>
    <form action="createThePuzzle.php" method="POST" enctype="multipart/form-data">
        <br>
        <h3 id="title">Create A Puzzle</h3> <br>

        <table>
            <tr>
                <td style="width:100px">Puzzle Name:</td>
                <td><input type="text"  name="puzzle_name" maxlength="100" size="50" required title="Please enter puzzle name."></td>
            </tr>
            <tr>
                <td style="width:100px">Creator Name:</td>
                <td><input type="text"  name="creator_name" maxlength="50" size="50" required title="Please enter creator name."></td>
            </tr>
            <tr>
                <td style="width:100px">Author Name:</td>
                <td><input type="text"  name="author_name" maxlength="50" size="50" required title="Please enter author name."></td>
            </tr>
            <tr>
                <td style="width:100px">Book Name:</td>
                <td><input type="text"  name="book_name" maxlength="50" size="50" required title="Please enter book name."></td>
            </tr>
            <tr>
                <td style="width:100px">Notes:</td>
                <td><input type="text"  name="notes" maxlength="100" size="50" title="Please enter notes."></td>
            </tr>
            <tr>
                <td style="width:100px">Puzzle Image</td>
                <td><input type="file" name="puzzleToUpload" id="puzzleToUpload" maxlength="50" size="50" title="Please enter the puzzle image name."></td>
            </tr>
            <tr>
                <td style="width:100px">Puzzle Solution Image</td>
                <td><input type="file" name="solutionToUpload" id="solutionToUpload" maxlength="50" size="50" title="Please enter the puzzle solution image name."></td>
            </tr>
        </table>

        <br><br>
        <div align="center" class="text-left">
            <button type="submit" name="submit" class="btn btn-primary btn-md align-items-center">Create Puzzle</button>
        </div>
        <br> <br>

    </form>
</div>
