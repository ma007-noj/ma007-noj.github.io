<?php
error_reporting(E_ERROR | E_PARSE);
if(session_status()==PHP_SESSION_NONE){
session_start();
} 
require_once __DIR__ . "/login.php";
