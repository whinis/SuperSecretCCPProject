<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2/18/2016
 * Time: 5:56 PM
 */
include("classes/class_Curl.php");
include("classes/class_db.php");
include("classes/class_crest.php");


$db=new db();
$db->loadByParams(
    "127.0.0.1",       //host
    "root",       //username
    "790825",   //password
    "sde",   //db
    3306,       //port
    true       //Debug mode
);
if($db->destroy)
    $db=null;

$curl = new Curl();