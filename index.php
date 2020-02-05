<?php
require 'bin/functions.php';
require 'db_configuration.php';
include('header.php');

?>
<!-- THIS IS A COMMENT -->
<html>
    <head>
        <title>Gpuzzles</title>
    </head>
    <style>
        .image {
            width: 100px;
            height: 100px;
            padding: 20px 20px 20px 20px;
            transition: transform .2s;
        }
        .image:hover {
            transform: scale(1.2)
        }
        #table_1 {
            border-spacing: 300px 0px;
        }
        #table_2 {
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 8rem;
        }
        
        #welcome {
            text-align: center;
        }
        #directions {
            text-align: center;
        }
        #title {
            color: black;
            text-align: center;
        }
        a:visited, a:link, a:active {
            text-decoration: none;
        }
        #title2 {
        text-align: center;
        color: darkgoldenrod;
        }


    </style>
    <body>
    <?php
        if(isset($_GET['preferencesUpdated'])){
            if($_GET["preferencesUpdated"] == "Success"){
                echo "<br><h3 align=center style='color:green'>Success! The Preferences have been updated!</h3>";
            }
        }
    ?>
    <h1 id = "title2">Welcome to Gpuzzles</h1>
    <h2 id = "directions">Puzzles</h2><br>

    <?php

    /********** GET NUMBER OF PUZZLES PER ROW QUERY **********/
    $no_of_sql = "SELECT `value` FROM `preferences` WHERE `name`= 'NO_OF_PUZZLES_PER_ROW'";
    $results1 = mysqli_query($db,$no_of_sql);
    if(mysqli_num_rows($results1)>0){
        while($row = mysqli_fetch_assoc($results1)){
            $column[] = $row;
        }
    }
    $columns = $column[0]['value'];

    /********** GET NUMBER OF PUZZLES TO SHOW QUERY **********/
    $to_show_sql = "SELECT `value` FROM `preferences` WHERE `name`= 'NO_OF_PUZZLES_TO_SHOW'";
    $results_to_show = mysqli_query($db,$to_show_sql);
    $row = mysqli_fetch_array($results_to_show );
    $no_of_puzzles = $row['value'];
    
    /********** RANDOMIZE PUZZLES QUERY **********/
    $rand_sql = "SELECT `name`, `puzzle_image` FROM `gpuzzles` ORDER BY RAND() LIMIT $no_of_puzzles";
    $results2 = mysqli_query($db,$rand_sql);
    if(mysqli_num_rows($results2)>0){
        while($row = mysqli_fetch_assoc($results2)){
            $names[] = $row;
            $pics[] = $row;
        }
    }
    $count= count($names);

    echo "<table id = 'table_2'>";
    echo "<tr>";
    for($a=0;$a<$count;$a){
        for($b=0;$b<$columns;$b++){
            if($a>=$count){
                break;
            }else{
                $name = $names[$a]['name'];
                $pic = $pics[$a]['puzzle_image'];
                echo "
                <td>
                    <a href = '#' title = $name>
                        <image class = 'image' src='Images\puzzle_images\/".$pic."'></image>
                        <div id = 'title'>$name</div>
                    </a>
                </td>";
                $a++;
            }
        }

    echo "</tr>";
    }
    echo"</table>";
    ?>

    </body>
</html>
