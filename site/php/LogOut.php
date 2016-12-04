<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 04.12.2016
 * Time: 23:28
 */
session_start();
unset($_SESSION['user']);
header('Location: Start_Page.php');


