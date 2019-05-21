<?php
require_once('../config/db.php');

$email = mysqli_escape_string($connect, $_POST['email']);
$pass = mysqli_escape_string($connect, md5($_POST['pass']));

$query = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
$sql = mysqli_query($connect, $query);
$cek = mysqli_num_rows($sql);
if ($cek == 1) {
    session_start();
    $data = mysqli_fetch_assoc($sql);
    $_SESSION['user'] = "logged";
    $_SESSION['email'] = $email;
    $_SESSION['id_user'] = $data['id_user'];
    echo json_encode("found");
} else {
    echo json_encode("not found");
}
?>