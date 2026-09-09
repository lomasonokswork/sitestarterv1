<?php
session_start();
$userId=$_SESSION['user_id'];
$conn=new mysqli("localhost","root","","user_auth");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);
$stmt=$conn->prepare("DELETE FROM users WHERE id = ?");$stmt->bind_param("i",$userId);
if($stmt->execute()){session_destroy();echo "Account deleted successfully.";header("Location: login.php");}else echo "Error deleting account.";
$stmt->close();$conn->close();
?>
