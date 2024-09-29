<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<meta http-equiv="Contect-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php include ("header.php");?>

<h2> Edit a record <h2>

<?php
//look for a valid user id, either through GET or POST
if ((isset ($_GET['id'])) && (is_numeric($_GET['id']))) {
     $id = $_GET['id'];
} elseif ((isset ($_POST['id'])) && (is_numeric($_POST['id'])))  {
    $id = $_POST['id'];
} else {
    echo '<p class ="error"> This page has been accessed in error.</p>';
        exit();
}

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    $error = array();

    //look for FirstName
    if (empty($_POST['FisrtName_P'])) {
        $error[] = 'You forgot to enetr the Fisrt Name.';
    } else {
        $n = mysqli_real_escape_string($connect, trim($_POST['FirstName_P']));
    }

    //look for LatName
    if (empty($_POST['LastName_P'])) {
        $error[] = 'You forgot to enter the Last Name.';
    } else {
        $l = mysqli_real_escape_string($connect, trim($_POST['LastName_P']));
    }

    //look for insurance Number
    if (empty($_POST['InsuranceNumber'])) {
        $error[] = 'You forgot to enter the Insurance Number.';
    } else {
        $in = mysqli_real_escape_string($connect,trim($_POST['InsuranceNumber']));
    }


    //look for diagnose
    if (empty($_POST['Diagnose'])) {
               $error[] = 'You forgot to enter the Diagnose.';
    } else {
        $in = mysqli_real_escape_string($connect,trim($_POST['Diagnose']));
    }

        
    //if no problem occured
    if (empty($error)) {

        $q = "SELECT ID_P FROM pesakit WHERE InsuranceNumber = '$in' AND ID_P != $id";

$result = @mysqli_query($connect, $q);

if (mysqli_num_rows($result) == 0 )  {
    $q = "UPDATE pesakit SET FirstName_P='$n' , LastName_P = '$l', InsuranceNumber = '$in', Diagnose = '$d' WHERE ID_P= '$id' LIMIT 1";

$result = @mysqli_query($connect, $q);

if (mysqli_affected_rows($connect) == 1 ) {

    echo '<h3>The user has been edited</h3>';
} else {
    echo '<p class="error"> The user has not be edited due to the system error. We apologize for any convenience.</p>';
    echo '<p>' .mysqli_error($connect). '<br/> query: ' .$q. '</p>';  
}
        
} else {
echo '<p class="error"> The no ic has already been registered</p>';
}
    }else {
        echo '<p class= "error"> The following error (s) occured: <br?r>';
        foreach ($error as $msg)
        {
        echo " -$msg<br/> \n";
    }
    echo '<p/><p>Please try again.</p>';
}
}

$q = "SELECT FirstName_P, LastName_P, InsuranceNumber, Diagnose FROM pesakit WHERE ID_P=$id";
$result = @mysqli_query ($connect, $q);

if (mysqli_num_rows($result) == 1 ) {
    //get patient information
    $row = mysqli_fetch_array ($result, MYSQLI_NUM);
    //create the form
echo '<from action ="edit_pesakit.php" method="post">
    <p><label class = "label" for="FirstName_P" > First Name: </label>
    <input id = "FirstName_P" type = "text" name ="FirstName_P" size="30" maxlength="30" value="'.$row[0].'"></p>

    <p><label class = "label" for="LastName_P" > Last Name: </label>
    <input id = "LastName_P" type = "text" name ="LastName_P" size="30" maxlength="30" value="'.$row[1].'"></p>

    <p><br><label class = "label" for="InsuranceNumber" > Insurance Number: </label>
    <input id = "InsuranceMumber" type ="text" name ="InsuranceNumber" size="39" maxlngth="30" value="'.$row[2].'"></p>

    <p><br><label class = "label" for="Diagnose" > Diagnose: </label>
    <input id = "Diagnose" type ="text" name ="IDiagnose" size="30" maxlngth="30" value="'.$row[3].'"></p>


    <br><p><input id ="submit" type="submit" name="submit" value="Edit"></p

    <br><input type="hidden" name="id" value="'.$id.'"/>

    </form>';


} else {
    echo 'p class="error"> This page has been accussed in error.</p>';
}

mysqli_close ($connect);

?>
</body>
</html>
        

    
       



















