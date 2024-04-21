<?php

session_start();
if (isset($_SESSION["user"])) {
   header("Location: Home.php");
}
?>
<html>
<head>
    <title>AJC Bike Shop MIS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/entry_styles.css">
    <script src="Entry.js"></script>
</head>
<style>
    * {
        box-sizing: border-box;
        font-family: Tahoma, "Trebuchet MS", sans-serif;
    }
    html,
    body,
    .wrapper {
        height: 100%;
    }
    body {
        display: grid;
        place-items: center;
        margin: 0 auto;
        padding: 0 24px;
        background-image: url(polygon-scatter-haikei.svg);
        background-repeat: no-repeat;
        background-size: cover;
        color: solid white;
        animation: rotate 6s infinite alternate linear;
    }
</style>
<body>
<!-- 1st screen to be seen, for login / signup-->
<div id="login_Body">
<?php
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    require_once "includes/database.php";
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($user) {
        if (password_verify($password, $user["Password"])) {
            // Set the 'AccountType' session variable
            $_SESSION['AccountType'] = $user['AccountType'];

            // Set other session variables if needed

            $_SESSION["user"] = "yes";
            header("Location: Home.php");
            die();
        } else {
            echo "<div class='alert alert-danger'>Password does not match</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Username does not match</div>";
    }
}
?>
    <h1>AJC Bike Shop</h1>
    <h2>Log In</h2>
    <form class="login_Form" method="POST" action="">
        <input type="text" placeholder="Username" name="username" />
        <input type="password" placeholder="Password" name="password" />
        <label> Don't have an account? <a href="Registration.php"> Sign Up here</a></label>
        <button type="submit" value="login" name="login"><b>LOGIN</b></button>
    </form>
</div>
</body>
</html>