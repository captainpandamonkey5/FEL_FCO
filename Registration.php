<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: Home.php"); // not yet placed
}
?>
<html>
    <head>
		
		<title>AJC Bike Shop MIS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
		<link rel="stylesheet" href="entry_styles.css">
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
      <div class="signup_Body">
      <?php
        if (isset($_POST["submit"])) {
            $fullname = $_POST["fullname"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $repeatPassword = $_POST["repeat_password"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();

            // any of these conditions are not true
            if (empty($fullname) || empty($username) || empty($password) || empty($repeatPassword)) {
              array_push($errors, "All fields are required");
            }
            if (!filter_var($username, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9]+$/")))) {
              array_push($errors, "Username already in use");
            }
            if (strlen($password < 8)) {
                array_push($errors, "Password must be atleast 8 characters long");
            }
            if ($password !== $repeatPassword) {
                array_push($errors, "Password does not match");
            }
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
             array_push($errors,"username already exists!");
            }
            if (count($errors)>0) {
                foreach($errors as $error) {
                    echo "<div class='alert alert-danger'> $error </div>";
                }
            } else {
              $sql = "INSERT INTO users (full_name, username, password) VALUES ( ?, ?, ? )";
              $stmt = mysqli_stmt_init($conn);
              $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
              if ($prepareStmt) {
                  mysqli_stmt_bind_param($stmt,"sss",$fullname, $username, $passwordHash);
                  mysqli_stmt_execute($stmt);
                  echo "<div class='alert alert-success'>You are registered successfully.</div>";
              }else{
                  die("Something went wrong");
              }
             }

        }
      ?>
        <h1>AJC Bike Shop</h1>
        <h2>Sign Up</h2>
        <form id="signup_Form" class="signup_Body" action="signup.php" method="post">
          <input type="name" name="fullname" placeholder="Full Name" />
          <input type="text" name="username" placeholder="Username" />
          <input type="password" name="password" placeholder="Password" />
          <input type="password" name="repeat_password" placeholder="Repeat Password" />
          <label>Already have an account? <a href="Entry.php">Login here</a></label>
          <button type="submit" value="Register" name="submit"><b>SIGNUP</b></button>
        </form>
      </div>
    </body>

</html>
