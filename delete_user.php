<?php
include("database.php");

if (isset($_POST['delete_user']))
{
    $user_id = $_POST["delete_user"];

    $query = "DELETE FROM user WHERE id='$user_id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Deleted Succcessfully";
        header('Location: AccountMngr.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong.!";
        header('Location: AccountMngr.php');
        exit(0);
    }
}
?>