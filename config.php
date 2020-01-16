<?php
session_start();
$host = "mysql04.domainhotelli.fi"; /* Host name */
$user = "jnvrlywv_login"; /* User */
$password = "salasana123"; /* Password */
$dbname = "jnvrlywv_login"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

