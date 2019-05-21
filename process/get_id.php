<?php
require_once('../config/db.php');

$query = "SELECT id_manga FROM manga WHERE status='airing' ORDER BY id_manga ASC";
$sql = mysqli_query($connect, $query);
if($sql) {
    $id = array();
    foreach($sql as $data) {
        $id[] = $data['id_manga'];
    }

    echo json_encode($id);
}
?>