<?php
require_once('../config/db.php');

$id_user = $_GET['id_user'];

$max_record = 22;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page>1) ? ($page * $max_record) - $max_record : 0;

$key = @$_GET['key'];

if(!isset($key)) {

    $querytotal = "SELECT * FROM manga ORDER BY title";
    $sqltotal = mysqli_query($connect, $querytotal);
    
    $query = "SELECT * FROM manga ORDER BY title LIMIT $start, $max_record";
    $sql = mysqli_query($connect, $query);

} else {
    $querytotal = "SELECT * FROM manga WHERE title LIKE '%$key%' ORDER BY title";
    $sqltotal = mysqli_query($connect, $querytotal);
    
    $query = "SELECT * FROM manga WHERE title LIKE '%$key%' ORDER BY title";
    $sql = mysqli_query($connect, $query);
}

$total_data = mysqli_num_rows($sqltotal);
$total_page = ceil($total_data/$max_record);

$manga = array();

function get_timeago( $ptime )
{
    $estimate_time = time() - $ptime;

    if( $estimate_time < 1 )
    {
        return 'less than 1 second ago';
    }

    $condition = array( 
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return '' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}

foreach($sql as $data) {
    $id = $data['id_manga'];
    $title = $data['title'];
    $img = $data['image'];
    if (strlen($title) >= 25) {
        $title = substr($title, 0, 25) . "...";
    } else {
        $title = $title;
    }
    
    $type = $data['type'];

    $queryCH = "SELECT user_history.id_manga, MAX(user_history.chapter) AS chapter, user_history.read_date FROM user_history INNER JOIN manga ON user_history.id_manga=manga.id_manga WHERE user_history.id_manga='$id'";
    $sqlCH = mysqli_query($connect, $queryCH);
    $dataCH = mysqli_fetch_assoc($sqlCH);
    if ($dataCH['chapter'] == null || $dataCH['chapter'] == "") {
        $chapter = 0;
    } else {
        $chapter = $dataCH['chapter'];
    }
    if ($dataCH['read_date'] == null || $dataCH['read_date'] == "") {
        $read_date = "Not Read";
    } else {
        $read_date = $dataCH['read_date'];
    }

    $querySEL = "SELECT COUNT(*) AS total FROM chapter WHERE id_manga='$id' AND chapter > $chapter";
    $sqlSEL = mysqli_query($connect, $querySEL);
    $dataSEL = mysqli_fetch_assoc($sqlSEL);
    $not_read = $dataSEL['total'];

    $manga[] = array(
        'id_manga' => $id,
        'title' => $title,
        'type' => $type,
        'chapter' => $chapter,
        'thumbnail' => $img,
        'read_date' => get_timeago(strtotime($read_date)),
        'not_read' => $not_read
    );
}

$result['page'] = $page;
$result['total_page'] = $total_page;
$result['total_data'] = $total_data;
$result['result'] = $manga;

header('Content-Type: application/json');
echo json_encode($result);
?>