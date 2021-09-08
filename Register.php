<html>
<head>
    <style>
        .error{color: #FF0000;}
    </style>
</head>
<body>
<?php
$lastnameErr = $firstnameErr = $emailErr = $passwordErr = $ageErr = $positionErr = $genderErr = "";
$lastname = $firstname = $email = $password = $age = $position = $gender = $successfulRegister = "";
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

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["LastName"]) && !empty($_POST["FirstName"]) && !empty($_POST["Email"]) && !empty($_POST["Password"]) && !empty($_POST["Age"]) && !empty($_POST["Position"] && !empty($_POST["Gender"]))) {
        $lastname = test_input($_POST["LastName"]);
        $firstname = test_input($_POST["FirstName"]);
        $email = test_input($_POST["Email"]);
        $password = test_input($_POST["Password"]);
        $age = test_input($_POST["Age"]);
        $position = test_input($_POST["Position"]);
        $gender = test_input($_POST["Gender"]);

        $addrow = "insert into RegisterDetails(LastName, FirstName, Email, Password, Age, Position, Gender)
                    values ('$lastname', '$firstname', '$email', '$password', '$age', '$position', '$gender')";

        mysqli_query($sqlConnect, $addrow);
        $successfulRegister = "Successful register!";

        $result_out = mysqli_query($sqlConnect, "select * from RegisterDetails");
        if (!$result_out) {
            die();
        }
    }

    else{
        if(empty($_POST["LastName"])){
            $lastnameErr= "Please enter your last name";
        }

        if (empty($_POST["FirstName"])){
            $firstnameErr = "Please enter your first name";
        }

        if(empty($_POST["Email"])){
            $emailErr= "Please enter your email";
        }

        if (empty($_POST["Password"])){
            $passwordErr = "Please enter your password";
        }

        if (empty($_POST["Age"])){
            $ageErr = "Please enter your age";
        }

        if (empty($_POST["Position"])){
            $positionErr = "Please select your position";
        }

        if (empty($_POST["Gender"])){
            $genderErr = "Please select your gender";
        }

    }

}

?>
<p><span class="error">* required field</span> </p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <span class="text-center"> <?php echo $successfulRegister;?> </span>
    <br><br>

    Last Name: <input type="text" name="LastName" >
    <span class = "error">* <?php echo $lastnameErr;?> </span>
    <br><br>

    First Name: <input type="text" name="FirstName" >
    <span class = "error">* <?php echo $firstnameErr;?> </span>
    <br><br>

    Email: <input type="text" name="Email" >
    <span class = "error">* <?php echo $emailErr;?> </span>
    <br><br>

    Password: <input type="password" name="Password" >
    <span class = "error">* <?php echo $passwordErr;?> </span>
    <br><br>

    Age: <input type="number" name="Age" >
    <span class = "error">* <?php echo $ageErr;?> </span>
    <br><br>

    Position: <input type="radio" id = "flightattendant" name="Position" value="Flight Attendant">
    <label for = "flightattendant">Flight Attendant </label>

    <input type="radio" id = "pilot" name="Position" value="Pilot">
    <label for = "pilot">Pilot</label>

    <input type="radio" id="copilot" name="Position" value="Co-pilot">
    <label for = "copilot">Co-pilot</label>

    <input type="radio" id="hrmanager" name="Position" value="HR Manager">
    <label for = "hrmanager">HR Manager</label>

    <span class = "error">* <?php echo $positionErr;?> </span>
    <br><br>

    Gender: <input type ="radio" id = "male" name="Gender" value="M">
    <label for="male">Male</label>

    <input type="radio" id="female" name="Gender" value="F">
    <label for = "female">Female</label>

    <span class = "error">* <?php echo $genderErr;?> </span>
    <br><br>

    <input type = "submit" formaction="LogInForm.html" value="Log In">
    <input type="submit" value="Register" />
</form>

