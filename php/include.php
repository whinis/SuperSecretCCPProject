<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2/18/2016
 * Time: 5:56 PM
 */
include("classes/class_Curl.php");
include("classes/class_db.php");


$db=new db();
$db->loadByParams(
    HOST,       //host
    USER,       //username
    PASSWORD,   //password
    DATABASE,   //db
    PORT,       //port
    FALSE       //Debug mode
);
if($db->destroy)
    $db=null;

$curl = new Curl();