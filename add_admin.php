<?php
include("database.php");

if (isset($_POST['add_admin']))
{
    $user_id = $_POST["add_admin"];

    // Update the account type from 0 to 1 (admin)
    $query = "UPDATE user SET AccountType = 1 WHERE id = '$user_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Admin added successfully";
        header('Location: AccountMngr.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something went wrong. Please try again.";
        header('Location: AccountMngr.php');
        exit(0);
    }
}
?>