<!doctype html>
<html lang="en">
  <head>
<!--*************************** LIBRARIES INORDER THE PAGE TO WORK*****************************-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Linear_A Library</title>
    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <!-- ********CSS FOR THE TABLE WE ARE USING, BUT SINCE WE ARE USING BOOSTRAP TABLE, MOST OF THE PROPERTIES ARE GIVEN BY DEFAULT***********-->
    <style>

      .th{
          background-color: #4CAF50;
          color: white;
         }
    </style>
  </head>
  <body>
<!--************************* NAVIGATION BAR ON THE TOP*************************************************-->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">LInear A</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
        </div>
    </nav>
<!--*********************************END OF NAVIGATION BAR***************************************************-->
<!--***********************INPUT FORM WHICH IS MADE OF THREE INPUT TEXT BOX AND A SUBMIT BUTTON******************************************-->
    <div class="container">
        <form style="padding-top: 50px;" class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="form-group row">
            <!--<label class="control-label col-sm-4 col-form-label" for="usr">Enter Substring by Numbers (Use Table Below):</label>-->
            <div class="col-sm-8">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label control-label col-sm-2" for="usr">Search by Linear A number seq: </label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="usr" name="LinearA" value="<?php echo htmlspecialchars($_POST["LinearA"]);?>" >
            </div>
          </div>
          <div class="form-group row">
            <label class=" col-form-label control-label col-sm-2" for="usr">Search by Cretan H. number seq:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="usr" name="CretanH" value="<?php echo htmlspecialchars($_POST["CretanH"]);?>" >
            </div>
          </div>
          <div class="form-group row">
            <label class=" col-form-label control-label col-sm-2" for="usr"> Search by English Word:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="usr" name="Word" value="<?php echo htmlspecialchars($_POST["Word"]);?>" >
            </div>
          </div>
          <div class="form-group row ">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default" name="submit" value="Submit">Submit</button>
            </div>
          </div>
        </form>
<!--**********************************END OF THE FORM**************************************************-->
<!--**********************BEGINNING OF PHP SCRIPT WHICH DEALS WITH THE SERVER ******************************-->
  <?php
                      //***************SERVER INFORMATION FOR LOGING IN********************************
                      $servername = ".......";
                      $username = ".........";
                      $password = "..........";
                      $dbname = ".............";
//********************* THIS IS FOR MAKING SURE THAT THE FORM WAS ONLY SUBMITTED AFTER THE USER CLICK A SUBMIT BUTTON, AND WE USE POST FOR SECURITY PURPOSE*********
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST['LinearA']) && empty($_POST['CretanH']) && empty($_POST['Word'])){// PREVENT EMPTY FORM TO BE SUBMITTED
                      echo "All fields can't be empty";

              }elseif (!empty($_POST['LinearA']) && !empty($_POST['CretanH']) && !empty($_POST['Word'])){ // PREVENT THE SUBMITION WITH ONE MORE THAN ONE BOX FILLED OUT
                      echo " Please search by one box at time";
                    //if linear box is not empty but the other one is empty
              }elseif (!empty($_POST['LinearA']) && empty($_POST['CretanH']) && empty($_POST['Word'])){//ALLOWING ONLY LINEAR A BOX TO BE FILLED OUT AND SUBMITTED SUCCESFUL
                      //set up connection
                      $linearA= $_POST['LinearA'];
                      //database_connection();

                     //$sql="select SquenceNumbers, Meaning, GorillaID, ChcID, PdblockNumber from Inscriptions where SquenceNumbers like '%$linearA%'"; //RETRIEVE DATA FROM INSCRIPTIONS TABLE

					 $sql="select SquenceNumbers, Meaning, GorillaID, ChcID, PdblockNumber from Inscriptions where SquenceNumbers like '%$linearA%' and type='l'";
					 $sql2="select MEANING, TRANSLITERATION, COGNATES, LANGUAGE, SYLLABICVALUE from LinearA_Words where TRANSLITERATION like '%$linearA%' and type='l'"; // RETRIEVE DATA FROM LINEARA_WORDS TABLE

                      // Create connection
                      $conn = new mysqli($servername, $username, $password, $dbname);
                      // Check connection
                      if ($conn->connect_error) {
                             die("Connection failed: " . $conn->connect_error);
                      }
                      $result=$conn->query($sql);
                      $result2=$conn->query($sql2);
                      if($result->num_rows>0){ // IF THE QUERY RESULT IS NOT EMPTY, WE DISPLAY RESULTS IN THE TABLE

                        echo "<table class='table table-bordered'>";
                        echo"<thead><tr><th class='th' style='width: 40%'>LINEAR A SEQUENCE</th><th class='th' style='width: 27%'>Meaning</th><th class='th' style='width: 12%'>GORILA</th>
                        <th class='th' style='width: 11%'>CHIC</th><th class='th' style='width: 10%'>PD BLOCK</th></tr></thead>";

                         while($row= $result->fetch_assoc()){ // DISPLAY THE RESULTS IN THE TABBLE
                            echo "<tr><td>{$row["SquenceNumbers"]}</td><td>{$row["Meaning"]}</td><td>{$row["GorillaID"]}</td><td>{$row["ChcID"]}</td><td>{$row["PdblockNumber"]}</td></tr>";

                           }
                            echo "</table>";

                        }else{
                              echo "No data found in linear A inscription \n";
                        }
                        if($result2->num_rows>0){

                          echo "<table id= 'id' class='table table-bordered'>";
                          echo"<tr><th class='th'>Meaning</th><th class='th'>Linear A</th><th class='th'>Cognates</th><th class='th'>Language</th><th class='th'>Syllabic Value</th></tr>";
//***************** FOR THE SECOND TABLE WE NEED TO CHANGE SOME OF THE CHARACTERS TO SPECIAL SYMBOLS, SO THIS WHILE LOOP TAKES CARE OF IT***********************************
//*********************bUT INSTEAD YOU CAN ALSO PUT UNICODES DIRECTLY IN THE DATABASE AND IF YOU HAVE NotoSansLinearA-Regular.ttf INSTALLED, THE CORRECT SYMBOLS WILL BE DISPLAYED *********************
                         while($row= $result2->fetch_assoc()){
                             if(strpos($row["COGNATES"],"E") !== false){
                                $split= explode("E", $row["COGNATES"]);
                                $WithSpecialchar = implode('&#0233', $split);
                                echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                             }elseif(strpos($row["COGNATES"],"A") !== false){
                                $split= explode("A", $row["COGNATES"]);
                                $WithSpecialchar = implode('&#0228', $split);
                                echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                             }elseif(strpos($row["COGNATES"],"@") !== false){
                               $split= explode("@", $row["COGNATES"]);
                               $WithSpecialchar = implode('&#0230', $split);
                               echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";

                             }elseif(strpos($row["COGNATES"],"X") !== false){
                               $split= explode("X", $row["COGNATES"]);
                               $WithSpecialchar = implode('&#967', $split);
                               echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                             }elseif(strpos($row["COGNATES"],"O") !== false){
                               $split= $row["COGNATES"];
                               $WithSpecialchar=str_replace('O','&#333',$split);
                               echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                             }elseif (strpos($row["COGNATES"],"S") !== false ){
                               $split= $row["COGNATES"];
                               $WithSpecialchar=str_replace('S','&#353',$split);
                               echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                             }elseif(strpos($row["COGNATES"],"N") !== false ){
                               $split= $row["COGNATES"];
                               $WithSpecialchar=str_replace('N','&#328',$split);
                               echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                             }elseif(strpos($row["COGNATES"],"U") !== false){
                               $split= explode("U", $row["COGNATES"]);
                               $WithSpecialchar = implode('&#250', $split);
                               echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                             }else{
                               echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$row["COGNATES"]}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                             }
                          }
                          echo "</table>";

                        }else{
                              echo "No data found in linear A transliteration";
                        }
                        $conn->close();
                }elseif(empty($_POST['LinearA']) && !empty($_POST['CretanH']) && empty($_POST['Word'])){ // ONLY CRETAN H BOX IS FILLED OUT
                                 $cretanH= $_POST['CretanH']; // INPUT FROM THE USER
                                 $arr=(explode('-',$cretanH)); // WE ARE BRANKING IT INTO SEPARATE SYMBOLS
                                 $LinearAarr= array();
                                 $Pdarr=array();
                                 $Unicodes=array();

                              foreach ($arr as $value){ //******* NOW FOR EACH CRETAN H SYMBOL, WE NEED TO FIND ITS CORRESPONDING PD SYMBOL AND LINEAR A SYMBOL IF THERE EXIST ANY********
                                   $sql ="select UNICODE, AID, PD from Linear_A where CH=$value";
                                // Create connection
                                   $conn = new mysqli($servername, $username, $password, $dbname);
                                // Check connection
                                   if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                     }
                                     $result=$conn->query($sql);
                                   if($result->num_rows> 0){

                                         while($row= $result->fetch_assoc()){
                                          //  echo $row["AID"]. " ";
                                           array_push($LinearAarr,$row["AID"]);
                                           array_push($Pdarr,$row["PD"]);
                                           array_push($Unicodes,$row["UNICODE"]);

                                           }

                                    }else {
                                         echo " no corresponding linear A found";
                                    }
                                    $conn->close();

                             }
//*************************** THE main goal here is to combine all pd or linear A symbols  together so that they make a sequence of pd or linear A symbols, THEN
                              //look for their corresponding linear A or PD INSCRIPTIONS that contain those linear A/ Pd sequences as substrings
                              // after getting those inscriptions, for linear A we display them to the user while for PD display them AND find their corresponding linear A SEQUENCEs and display it as well.
                              // then finally, display also the cretan H inscriptions which contains the input from user as substrings

                              // NOTE: the above steps are more likely to be confusing at first, so please make sure to discuss with Dr. Revesz to understand it better.
                             $strp=implode("-", $Pdarr); // COMBINE ALL PD SYMBOLS OBTAINED ABOVE INORDER TO MAKE A SENTENCE (OR SUBSTRING OF PD INSCRIPTION)
                             $str= implode("-", $LinearAarr); // combine all linear A symbols
                             $cretan=$_POST['CretanH'];
                             $sql2="select SquenceNumbers, GorillaID, ChcID, PdblockNumber from Inscriptions where SquenceNumbers like '%$str%'"; // Query to get Linear A inscriptions
                             $sql3="select SquenceNumbers, GorillaID, ChcID, PdblockNumber from Inscriptions where SquenceNumbers like '%$cretan%'"; // Query to get CH inscriptions
                             $sql4="select SquenceNumbers, GorillaID, ChcID, PdblockNumber from Inscriptions where SquenceNumbers like '%$strp%'"; // Query to get PD inscriptions
                             $conn = new mysqli($servername, $username, $password, $dbname); // database connection
                             // Check connection
                             if ($conn->connect_error) { // in case of failure, display connection error message to the user
                                    die("Connection failed: " . $conn->connect_error);
                             }
                             $result4=$conn->query($sql4);
                             $result3=$conn->query($sql3);
                             $result2=$conn->query($sql2);

                             if($result2->num_rows>0 && $result3->num_rows==0 && $result4->num_rows==0){ // Display Linear A inscriptions

                               echo "<table class='table table-bordered'>";
                               echo"<thead><tr><th class='th' style='width: 20%'>Linear A</th><th class='th' style='width: 30%'>CH or PD</th><th class='th' style='width: 20%'>GORILA</th>
                               <th class='th' style='width: 15%'>CHIC</th><th class='th' style='width: 15%'>PD BLOCK</th></tr></thead>";

                                while($row= $result2->fetch_assoc()){
                                   echo "<tr><td>{$row["SquenceNumbers"]}</td><td>{}</td><td>{$row["GorillaID"]}</td><td>{$row["ChcID"]}</td><td>{$row["PdblockNumber"]}</td></tr>";

                                  }
                                   echo "</table>";
                              }elseif($result2->num_rows==0 && $result3->num_rows>0 && $result4->num_rows==0){//Display CH inscriptions
                                echo "<table class='table table-bordered'>";
                                echo"<thead><tr><th class='th' style='width: 20%'>Linear A</th><th class='th' style='width: 30%'>SEQUENCE</th><th class='th' style='width: 20%'>GORILA</th>
                                <th class='th' style='width: 15%'>CHIC</th><th class='th' style='width: 15%'>PD BLOCK</th></tr></thead>";

                                 while($row= $result3->fetch_assoc()){
                                    echo "<tr><td>{$str}</td><td>{$row["SquenceNumbers"]}</td><td>{$row["GorillaID"]}</td><td>{$row["ChcID"]}</td><td>{$row["PdblockNumber"]}</td></tr>";

                                   }
                                    echo "</table>";
                               }elseif($result2->num_rows==0 && $result3->num_rows==0 && $result4->num_rows>0){// Display pd inscriptions
                                 echo "<table class='table table-bordered'>";
                                 echo"<thead><tr><th class='th' style='width: 20%'>Linear A</th><th class='th' style='width: 30%'>SEQUENCE</th><th class='th' style='width: 20%'>GORILA</th>
                                 <th class='th' style='width: 15%'>CHIC</th><th class='th' style='width: 15%'>PD BLOCK</th></tr></thead>";

                                  while($row= $result4->fetch_assoc()){
                                     echo "<tr><td>{$str}</td><td>{$row["SquenceNumbers"]}</td><td>{$row["GorillaID"]}</td><td>{$row["ChcID"]}</td><td>{$row["PdblockNumber"]}</td></tr>";

                                    }
                                     echo "</table>";

                               }elseif($result2->num_rows>0 && $result3->num_rows>0 && $result4->num_rows==0){//just in case you we get both linear A and CH inscriptions results
                                 echo "<table class='table table-bordered'>";
                                 echo"<thead><tr><th class='th' style='width: 40%'>LINEAR A SEQUENCE</th><th class='th' style='width: 20%'>GORILA</th>
                                 <th class='th' style='width: 20%'>CHIC</th><th class='th' style='width: 20%'>PD BLOCK</th></tr></thead>";

                                          while($row= $result2->fetch_assoc()){

                                              echo "<tr><td>{$row["SquenceNumbers"]}</td><td>{$row["GorillaID"]}</td><td>{$row["ChcID"]}</td><td>{$row["PdblockNumber"]}</td></tr>";
                                            }

                                        while($row= $result3->fetch_assoc()){

                                           echo "<tr><td>{$row["SquenceNumbers"]}</td><td>{$row["GorillaID"]}</td><td>{$row["ChcID"]}</td><td>{$row["PdblockNumber"]}</td></tr>";
                                         }
                                         echo "</table>";
                               }elseif($result2->num_rows>0 && $result3->num_rows==0 && $result4->num_rows>0){ //incase of linear A and PD inscriptios results
                                 echo "<table class='table table-bordered'>";
                                 echo"<thead><tr><th class='th' style='width: 40%'>LINEAR A SEQUENCE</th><th class='th' style='width: 20%'>GORILA</th>
                                 <th class='th' style='width: 20%'>CHIC</th><th class='th' style='width: 20%'>PD BLOCK</th></tr></thead>";
                                          while($row= $result2->fetch_assoc()){

                                            echo "<tr><td>{$row["SquenceNumbers"]}</td><td>{$row["GorillaID"]}</td><td>{$row["ChcID"]}</td><td>{$row["PdblockNumber"]}</td></tr>";
                                          }
                                        while($row= $result4->fetch_assoc()){

                                        echo "<tr><td>{$row["SquenceNumbers"]}</td><td>{$row["GorillaID"]}</td><td>{$row["ChcID"]}</td><td>{$row["PdblockNumber"]}</td></tr>";
                                      }
                                       echo "</table>";
                               }elseif($result2->num_rows==0 && $result3->num_rows>0 && $result4->num_rows>0){
//******************* incase of CH and PD inscriptios we need to display them, and transulate them into their corresponding linear A symbols*****************.
                                 echo "<table class='table table-bordered'>";
                                 echo"<thead><tr><th class='th' style='width: 20%'>Linear A</th><th class='th' style='width: 30%'>CH or PD</th><th class='th' style='width: 20%'>GORILA</th>
                                 <th class='th' style='width: 15%'>CHIC</th><th class='th' style='width: 15%'>PD BLOCK</th></tr></thead>";
                                 $LinAarray= array();
                                 $LineAarrayCH=array();
                                 $LinAarryayOfstrings= array();
                                 $chLinAarryayOfstrings=array();
                                          while($row= $result4->fetch_assoc()){
                                             $pdString=$row["SquenceNumbers"];
                                             $pdSigns=(explode('-',$row["SquenceNumbers"]));
                                             $gorilla=$row["GorillaID"];
                                             $chid=$row["ChcID"];
                                             $pblock=$row["PdblockNumber"];

                                             foreach ($pdSigns as $key){
                                                  $sql5 ="select AID from Linear_A where PD=$key";
                                               // Create connection
                                                  $conn = new mysqli($servername, $username, $password, $dbname);
                                               // Check connection
                                                  if ($conn->connect_error) {
                                                       die("Connection failed: " . $conn->connect_error);
                                                    }
                                                    $result5=$conn->query($sql5);
                                                  if($result5->num_rows> 0){
                                                        while($row= $result5->fetch_assoc()){
                                                          array_push($LinAarray,$row["AID"]);
                                                        }

                                                   }else {
                                                        echo " no corresponding linear A found";
                                                   }
                                                   $conn->close();
                                            }
                                            $LinAString=implode("-", $LinAarray);
                                            echo "<tr><td>{$LinAString}</td><td>{$pdString}</td><td>{$gorilla}</td><td>{$chid}</td><td>{$pblock}</td></tr>";
                                          }
                                        while($row= $result3->fetch_assoc()){
                                          $chString=$row["SquenceNumbers"];
                                          $chSigns=(explode('-',$row["SquenceNumbers"]));
                                          $chgorilla=$row["GorillaID"];
                                          $chChid=$row["ChcID"];
                                          $chplock=$row["PdblockNumber"];
                                          foreach ($chSigns as $key){
                                               $sql6 ="select AID from Linear_A where CH=$key";
                                            // Create connection
                                               $conn = new mysqli($servername, $username, $password, $dbname);
                                            // Check connection
                                               if ($conn->connect_error) {
                                                    die("Connection failed: " . $conn->connect_error);
                                                 }
                                                 $result6=$conn->query($sql6);
                                               if($result6->num_rows> 0){
                                                     while($row= $result6->fetch_assoc()){
                                                       array_push($LineAarrayCH,$row["AID"]);
                                                     }

                                                }else {
                                                     echo " no corresponding linear A found";
                                                }
                                                $conn->close();
                                         }
                                         $chLinAString=implode("-", $LineAarrayCH);
                                        // array_push($chLinAarryayOfstrings,$chLinAString);
                                         echo "<tr><td>{$chLinAString}</td><td>{$chString}</td><td>{$chgorilla}</td><td>{$chChid}</td><td>{$chplock}</td></tr>";
                                       }
                                         echo "</table>";
                               }elseif($result2->num_rows>0 && $result3->num_rows>0 && $result4->num_rows>0){
// ************************** In case of linear A, CH, and PD results. We need to display them first, then transulate their CH and PD into Linear A inscriptios. so the following code
                                 //takes care of it.
                                 echo "<table class='table table-bordered'>";
                                 echo"<thead><tr><th class='th' style='width: 40%'>LINEAR A SEQUENCE</th><th class='th' style='width: 20%'>GORILA</th>
                                 <th class='th' style='width: 20%'>CHIC</th><th class='th' style='width: 20%'>PD BLOCK</th></tr></thead>";
                                          while($row= $result2->fetch_assoc()){

                                            echo "<tr><td>{$row["SquenceNumbers"]}</td><td>{$row["GorillaID"]}</td><td>{$row["ChcID"]}</td><td>{$row["PdblockNumber"]}</td></tr>";
                                            }

                                        while($row= $result3->fetch_assoc()){

                                           echo "<tr><td>{$row["SquenceNumbers"]}</td><td>{$row["GorillaID"]}</td><td>{$row["ChcID"]}</td><td>{$row["PdblockNumber"]}</td></tr>";
                                         }
                                         while($row= $result4->fetch_assoc()){

                                            echo "<tr><td>{$row["SquenceNumbers"]}</td><td>{$row["GorillaID"]}</td><td>{$row["ChcID"]}</td><td>{$row["PdblockNumber"]}</td></tr>";
                                          }
                                          echo "</table>";

                               }else{
                                     echo "No data found in linear A matching";
                               }

                               $conn->close();

                }elseif (empty($_POST['LinearA']) && empty($_POST['CretanH']) && !empty($_POST['Word'])){ // WE ENTER THIS IF CASE IF THE ENGLISH WORD BOX WAS THE ONLY FILLED OUT
                  $word=$_POST['Word']; // USER INPUT
                  $sql="select MEANING, TRANSLITERATION, COGNATES, LANGUAGE, SYLLABICVALUE from LinearA_Words where MEANING like '%$word%'"; // QUERY TO RETRIEVE the user input related info FROM LinearA-words;
                  $sql9="select SquenceNumbers, GorillaID, Meaning from Inscriptions where meaning like '%$word%'"; // QUERY to retrieve all insrciptions that contains user input from Inscriptions table
                  $conn = new mysqli($servername, $username, $password, $dbname); // connection to the database
                  // Check connection
                  if ($conn->connect_error) { // if connection failed, we display the message to the user
                         die("Connection failed: " . $conn->connect_error);
                  }
                  $result=$conn->query($sql);
                  $result9=$conn->query($sql9);
                  if($result->num_rows>0){ // if the query results is not zero else we display the zero result message to the user
                      echo "<table id= 'id' class='table table-bordered'>";
                      echo"<tr><th class='th'>Meaning</th><th class='th'>Linear A</th><th class='th'>Cognates</th><th class='th'>Language</th><th class='th'>Syllabic Value</th></tr>";
//*****************THIS while loop is for changing special characters to their corresponding unicode presantation. Please check with Dr. revesz to make sure you understand it correctly
                     while($row= $result->fetch_assoc()){

                          if(strpos($row["COGNATES"],"E") !== false){
                             $split= explode("E", $row["COGNATES"]);
                             $WithSpecialchar = implode('&#0233', $split);
                             echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                          }elseif(strpos($row["COGNATES"],"A") !== false){
                             $split= explode("A", $row["COGNATES"]);
                             $WithSpecialchar = implode('&#0228', $split);
                             echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                          }elseif(strpos($row["COGNATES"],"@") !== false){
                            $split= explode("@", $row["COGNATES"]);
                            $WithSpecialchar = implode('&#0230', $split);
                            echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";

                          }elseif(strpos($row["COGNATES"],"X") !== false){
                            $split= explode("X", $row["COGNATES"]);
                            $WithSpecialchar = implode('&#967', $split);
                            echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                          }elseif(strpos($row["COGNATES"],"O") !== false){
                            $split= $row["COGNATES"];
                            $WithSpecialchar=str_replace('O','&#333',$split);
                            echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                          }elseif (strpos($row["COGNATES"],"S") !== false ){
                            $split= $row["COGNATES"];
                            $WithSpecialchar=str_replace('S','&#353',$split);
                            echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                          }elseif(strpos($row["COGNATES"],"N") !== false ){
                            $split= $row["COGNATES"];
                            $WithSpecialchar=str_replace('N','&#328',$split);
                            echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                          }elseif(strpos($row["COGNATES"],"U") !== false){
                            $split= explode("U", $row["COGNATES"]);
                            $WithSpecialchar = implode('&#250', $split);
                            echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$WithSpecialchar}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                          }else{
                            echo "<tr><td>{$row["MEANING"]}</td><td>{$row["TRANSLITERATION"]}</td><td>{$row["COGNATES"]}</td><td>{$row["LANGUAGE"]}</td><td>{$row["SYLLABICVALUE"]}</td></tr>";
                          }
                       }
                       echo "</table>";
                    }else{ // message to the user if no result to be displayed
                          echo "No data found in linear A";
                    }

                    if($result9->num_rows>0){ // Displaying results from query9
                        echo "<table class='table table-bordered'>";
                        echo"<thead><tr><th class='th' style='width: 40%'>Meaning</th><th class='th' style='width: 40%'>Linear A</th><th class='th' style='width: 20%'>GORILA ID</th>
                        </tr></thead>";
                           while($row= $result9->fetch_assoc()){
                             echo "<tr><td>{$row["Meaning"]}</td><td>{$row["SquenceNumbers"]}</td><td>{$row["GorillaID"]}</td></tr>";
                           }
                            echo "</table>";
                      }else{ // message to the user if querry 9 results is empty
                            echo "No data found in linear A Inscriptions";
                      }


                    $conn->close();

               }else{
                             echo "0 results";
               }
       }
      ?>
           </tbody>

         </table>
         <h4>References Table: </h4>
         <table class="table table-bordered table-condensed">
<?php
//******************************************* FROM HERE TO THE BOTTOM, WE ARE SIMPLY DISPLAYING THE SYSMBOLS WITH THEIR CORRESPONDING UNICODES
$U_code=array("10600","10601","10602","10603","10604","10605","10606","10607","10608","10609","10609","1060A","1060B","1060C","1060D","1060E","1060F","10610","10611","10612","10613","10614","10615","10616","10617","10618","10619","1061A","1061B","1061C","1061D","1061E","1061F","10620","10620","10620","10621","10622","10622","10623","10624","10624","10625","10626","10627","10628","10629","1062A","1062B","1062C","1062D","1062E","1062F","1062F","10630","10631","10632","10632","10633","10634","10635","10636","10637","10638","10639","1063A","1063B","1063C","1063D","1063E","1063F","1063F","1063F","10640","10641","10642","10643","10644","10644","10645","10646","10647","10648","10649","1064A","1064B","1064C","1064D","1064E","1064F","10650","10651","10652","10653","10654","10655","10656","10657","10658","10659","1065A","1065B","1065C","1065D","1065D","1065D","1065E","1065F","10660","10661","10662","10663","10664","10665","10666","10667","10668","10669","1066A","1066B","1066C","1066D","1066E","1066F","10670","10671","10672","10673","10674","10675","10676","10677","10678","10679","1067A","1067B","1067C","1067D","1067E","1067F","10680","10681","10682","10683","10684","10685","10686","10687","10688","10689","1068A","1068B","1068C","1068D","1068F","10690","10691","10692","10693","10694","10695","10696","10696","10697","10698","10699","1069A","1069B","1069C","1069D","1069E","1069F","106A0","106A1","106A2","106A3","106A4","106A5","106A6","106A7","106A8","106A9 ","106AA","106AB","106AC ","106AD ","106AE ","106AF ","106B0 ","106B1 ","106B2 ","106B2 ","106B3","106B4","106B5","106B6","106B7","106B8","106B9","106BA","106BB","106BC","106BD","106BE","106BF","106C0","106C1","106C2","106C3","106C4","106C5","106C6","106C7","106C8","106C9","106CA","106CB","106CC","106CD","106CE","106CF","106D0","106D1","106D2","106D3","106D4","106D5","106D6","106D7","106D8","106D9","106DA","106DB","106DC","106DD","106DE","106DF","106E0","106E1","106E2","106E3","106E4","106E5","106E6","106E7","106E8","106E9","106EA","106EB","106EC","106ED","106EE","106EF","106F0","106F1","106F2");
$U_code=array_unique($U_code);
//print_r($U_code);
//echo count($U_code);
$aid=array("001","002","003","004","005","006","007","008","009","010","010","011","013","016","017","020","021","021F","021M","022","022F","022M","023","023M","024","026","027","028","A028B","029","030","031","034","037","037","037","038","039","039","040","041","041","044","045","046","047","048","049","050","051","053","054","055","055","056","057","058","058","059","060","061","065","066","067","069","070","073","074","076","077","078","078","078","079","080","081","082","085","085","086","087","A100-102","118","120","120B","122","123","131A","131B","131C","164","171","180","188","191","301","302","303","304","305","306","307","308","309A","309A","309A","309B","309C","310","311","312","313A","313B","313C","314","315","316","317","318","319","320","321","322","323","324","325","326","327","328","329","330","331","332","333","334","335","336","337","338","339","340","341","342","343","344","345","346","347","348","349","350","351","352","353","355","356","357","358","359","360","361","362","362","363","364","365","366","367","368","369","370","371","400","401","402","403","404","405","406","407","408","409","410","411","412","413","414","415","416","417","418","418","501","502","503","504","505","506","508","509","510","511","512","513","515","516","520","521","523","524","525","526","527","528","529","530","531","532","534","535","536","537","538","539","540","541","542","545","547","548","549","550","551","552","553","554","555","556","557","559","563","564","565","566","568","569","570","571","572","573","574","575","576","577","578","579","648","712","732");
$aid=array_unique($aid);
//echo count($aid);
$i=0;
$j=0;
/*foreach ($U_code as $code) */
for ($count=0;$count<5;$count++) // five rows
{
   echo "<tr>";
for($c2=1;$c2<=20;$c2++) // 20 columns
{
	$Uval=current($U_code);
    //echo "<td>&#x$U_code[$i]</td>";
	echo "<td>&#x$Uval</td>";
	//echo current($U_code);
	next($U_code);
    $i++;
}
$i=$i-20;
echo "</tr>";
echo "<tr>";
for($c2=1;$c2<=20;$c2++)
{
    $Uaid=current($aid);
	//echo "<td>$aid[$i]</td>";
    echo "<td>$Uaid</td>";
	next($aid);
    $i++;
}
$i++;
    echo "</tr>";
}
?>
       </div>

  </body>
 </html>
