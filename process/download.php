<?php
set_time_limit(3000);
$url = $_GET['url'];
$id_manga = $_GET['id_manga'];
$chapter = $_GET['chapter'];
$id_user = $_GET['id_user'];
$date = date("Y-m-d");
$content = file_get_contents($url);
$first_step = explode( '<div id="readerarea">' , $content );
$second_step = explode('<div class="nextprev">' , $first_step[1] );
$result = $second_step[0];
preg_match_all('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $result, $image);
$img = array_values(array_unique($image['src']));
$i=0;
foreach ($img as $data) {
    if (strpos($data, '.jpg') !== false) {
        $nama_img = $i . '.jpg';
    } else if (strpos($data, '.png') !== false){
        $nama_img = $i . '.png';
    } else if (strpos($data, '.jpeg') !== false){
        $nama_img = $i . '.jpeg';
    }
    if(!is_dir('../assets/manga/'. $id_manga .'/' . $chapter)) {
        mkdir('../assets/manga/'. $id_manga .'/' . $chapter);
    }
    
    $file_name = '../assets/manga/'. $id_manga .'/' . $chapter .'/' . $nama_img;
    $ch = curl_init(str_replace(" ", "%20", $data));
    $fp = fopen($file_name, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    $i++;
}

require_once('../config/db.php');
$result = array();
$query = "SELECT * FROM user_history WHERE id_user='$id_user' AND id_manga='$id_manga' AND chapter='$chapter'";
$sql = mysqli_query($connect, $query);
$cek = mysqli_num_rows($sql);
if($cek > 0) {
    $query = "UPDATE user_history SET status='1', read_date='$date' WHERE id_user='$id_user' AND id_manga='$id_manga' AND chapter='$chapter'";
    $sql = mysqli_query($connect, $query);
    if ($sql) {
        $result['status'] = "sukses";
        $result['msg'] = "";
    } else {
        $result['status'] = "error";
        $result['msg'] = mysqli_error($sql);
    }
}else {
    $query = "INSERT INTO user_history (id_user, id_manga, chapter, read_date, status) VALUES ('$id_user', '$id_manga', '$chapter', '$date', '1')";
    $sql = mysqli_query($connect, $query);
    if($sql) {
        $result['status'] = "sukses";
        $result['msg'] = "";
    } else {
        $result['status'] = "error";
        $result['msg'] = mysqli_error($sql);
    }
}

echo json_encode($result);
?>