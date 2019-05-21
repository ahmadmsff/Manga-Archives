<?php
require_once('../config/db.php');

$id_user = $_GET['id_user'];

// GET TOTAL MANGA
$query = "SELECT COUNT(*) AS total FROM manga";
$sql = mysqli_query($connect, $query);
$total = mysqli_fetch_assoc($sql);

// COUNT UPDATE TODAY
$query = "SELECT COUNT(*) AS total FROM chapter WHERE release_date=CURRENT_DATE";
$sql = mysqli_query($connect, $query);
$today = mysqli_fetch_assoc($sql);

// COUNT MANGA NOT READ
$query = "SELECT COUNT(*) AS total FROM user_history INNER JOIN chapter on user_history.id_manga=chapter.id_manga WHERE user_history.id_user='$id_user' AND user_history.chapter<chapter.chapter";
$sql = mysqli_query($connect, $query);
$not_read = mysqli_fetch_assoc($sql);

$result['total'] = $total['total'];
$result['update'] = $today['total'];
$result['not_read'] = $not_read['total'];
echo json_encode($result);
?>