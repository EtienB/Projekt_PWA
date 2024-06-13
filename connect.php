<?php
header('Content-Type: text/html; charset=utf-8');

$servername="localhost";
$username="root";
$password="";
$basename="RP";
$port=3307;

$conn=new mysqli($servername, $username, $password, $basename, $port);

if($conn->connect_error)
{
    die("Greška u povezivanju.".$conn->connect_error);
}