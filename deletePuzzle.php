
<?php $page_title = 'Gpuzzles > Delete Puzzle'; ?>
<?php
    require 'bin/functions.php';
    require 'db_configuration.php';
    include('header.php');
    $page="puzzles_list.php";
    verifyLogin($page);

?>
<div class="container">
<style>#title {text-align: center; color: darkgoldenrod;}</style>
<?php
include_once 'db_configuration.php';

if (isset($_GET['id'])){

    $id = $_GET['id'];

    $sql = "SELECT * FROM gpuzzles
            WHERE id = '$id'";

    if (!$result = $db->query($sql)) {
        die ('There was an error running query[' . $connection->error . ']');
    }//end if
}//end if

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<form action="deleteThePuzzle.php" method="POST">
    <br>
    <h3 id="title">Delete Puzzle</h3><br>
    <h2>'.$row["book_name"].' - '.$row["name"].' </h2> <br>

    <div class="form-group col-md-4">
      <label for="id">Id</label>
      <input type="text" class="form-control" name="id" value="'.$row["id"].'"  maxlength="5" readonly>
    </div>

    <div class="form-group col-md-8">
      <label for="name">Name</label>
      <input type="text" class="form-control" name="name" value="'.$row["name"].'"  maxlength="255" readonly>
    </div>

    <div class="form-group col-md-4">
      <label for="category">Creator Name</label>
      <input type="text" class="form-control" name="creator_name" value="'.$row["creator_name"].'"  maxlength="255" readonly>
    </div>

    <div class="form-group col-md-4">
      <label for="level">Author Name</label>
      <input type="text" class="form-control" name="author_name" value="'.$row["author_name"].'"  maxlength="255" readonly>
    </div>

    <div class="form-group col-md-4">
      <label for="facilitator">Book Name</label>
      <input type="text" class="form-control" name="book_name" value="'.$row["book_name"].'"  maxlength="255" readonly>
    </div>

    <div class="form-group col-md-4">
      <label for="cadence">Puzzle Image Path</label>
      <input type="text" class="form-control" name="puzz_img_name" value="Images\puzzle_images\/'.$row["puzzle_image"].'"  maxlength="255" readonly>
    </div>

    <div class="form-group col-md-4">
      <label for="cadence">Solution Image Path</label>
      <input type="text" class="form-control" name="sol_img_name" value="Images\solution_images\/'.$row["solution_image"].'"  maxlength="255" readonly>
    </div>

    <div class="form-group col-md-6">
      <label for="optional">Notes</label>
      <input type="text" class="form-control" name="notes" value="'.$row["notes"].'"  maxlength="255" readonly>
    </div>

    <br>
    <div class="text-left">
        <button type="submit" name="submit" class="btn btn-primary btn-md align-items-center">Confirm Delete Puzzle</button>
    </div>
    <br> <br>

    </form>';

    }//end while
}//end if
else {
    echo "0 results";
}//end else

?>

</div>
