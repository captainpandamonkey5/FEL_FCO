<?php
include("database.php");

if (isset($_POST['remove_admin']))
{
    $user_id = $_POST["remove_admin"];

    // Update the account type from 0 to 1 (admin)
    $query = "UPDATE user SET AccountType = 'user' WHERE UserID = '$user_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Admin removed successfully";
        header('Location: ../AccountMngr.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something went wrong. Please try again.";
        header('Location: ../AccountMngr.php');
        exit(0);
    }
}
?>