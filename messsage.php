<?php

if(isset($_SESSION['message']))
{
    ?>
        <div class="alert" role="alert">
            <strong>Hey!</strong> <?= $_SESSION['message']; ?>
            <button type="button" class="button-close" data-bs-dismiss="alert" ></button>
        </div>
    <?php
    unset($_SESSION['message']);
}

?>