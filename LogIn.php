<html>
<head>
    <style>
        .error{color: #FF0000;}
    </style>
</head>
<body>

<?php
$emailErr = $passwordErr = $emailandpasswordErr = "";
$email = $password = "";

$sqlConnect = mysqli_connect('localhost', 'root');
if(!$sqlConnect){
    die();
}

$selectDB = mysqli_select_db($sqlConnect, 'LogInDatabase');
if(!$selectDB) {
    die("Database connection failed!" .mysqli_error());
}

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["Email"]) && !empty($_POST["Password"])){

        $result_out = mysqli_query($sqlConnect, "select * from RegisterDetails");

        if(!$result_out){
            die();
        }

        $email = test_input($_POST["Email"]);
        $password = test_input($_POST["Password"]);

        $login_details = mysqli_query($sqlConnect, "select * from RegisterDetails where Email = '$email' and  Password = '$password'");
        $rows = mysqli_num_rows($login_details);
        if($rows != 0) {
            while ($SR = mysqli_fetch_array($login_details)) {
                $Email = $SR['Email'];
                $Password = $SR['Password'];
            }

            if ($email == $Email && $password == $Password){
                echo "Welcome to this page!";
                exit();
            }

        }

        else{
            $emailandpasswordErr = "Incorrect username and/or password";
        }
    }

    else{
        if(empty($_POST["Email"])){
            $emailErr= "Please enter your email";
        }

        if (empty($_POST["Password"])){
            $passwordErr = "Please enter your password";
        }
    }
}
?>

<p><span class="error">* required field</span> </p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Email: <input type="text" name="Email" >
    <span class = "error">* <?php echo $emailErr;?> </span>
    <br><br>

    Password: <input type="password" name="Password" >
    <span class="error">* <?php echo $passwordErr;?> </span>
    <br><br>

    <span class="error"> <?php echo $emailandpasswordErr;?> </span>
    <br><br>

    <input type="submit" value="Log In" />
    <input type = "submit" formaction="RegisterForm.html" value="Register">
</form>