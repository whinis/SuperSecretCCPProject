<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2/18/2016
 * Time: 6:05 PM
 */
include ("include.php");
$systemID = 0;
$systemName = "";
if(isset($_GET['ID']))
    $systemID=$_GET['ID'];

elseif(isset($_GET['NAME']))
    $systemName = $_GET['NAME'];