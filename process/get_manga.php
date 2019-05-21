<?php
$id_user = $_GET['id_user'];
$id_manga = $_GET['id_manga'];

require_once('../config/db.php');

$query = "SELECT manga.title, manga.image, manga.type, manga.status, manga_detail.release_date, manga_detail.native_title, manga_detail.description FROM manga INNER JOIN manga_detail ON manga.id_manga=manga_detail.id_manga WHERE manga.id_manga='$id_manga'";
$sql = mysqli_query($connect, $query);
$data = mysqli_fetch_assoc($sql);
$title = $data['title'];
$native = $data['native_title'];
$image = $data['image'];
$type = $data['type'];
$status = $data['status'];
$release_date = $data['release_date'];
$description = $data['description'];

$query = "SELECT genre_detail.name FROM genre INNER JOIN genre_detail ON genre.id_genre_detail=genre_detail.id_genre_detail WHERE genre.id_manga='$id_manga'";
$sql = mysqli_query($connect, $query);
$genre = "";
foreach($sql as $dat) {
    $genre .= $dat['name'] . ", ";
}
$genre = substr($genre,0,strlen($genre) - 2);
$query = "SELECT author_detail.name, author_detail.job FROM author_detail INNER JOIN author ON author_detail.id_author_detail=author.id_author_detail WHERE author.id_manga='$id_manga'";
$sql = mysqli_query($connect, $query);
$author = "";
foreach($sql as $dat) {
    $name = $dat['name'];
    $job = $dat['job'];
    if($job == "?") {
        $job = "";
    } else {
        $job = " (" . $dat['job'] . ")";
    }

    $author .= $name . $job . ", ";
}
$author = substr($author,0,strlen($author) - 2);
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

$chapter = "";
$query = "SELECT * FROM chapter WHERE id_manga='$id_manga' ORDER BY chapter DESC";
$sql = mysqli_query($connect, $query);
foreach($sql as $dat) {
    $q = "SELECT chapter, status FROM user_history WHERE id_user='$id_user' AND id_manga='$id_manga' AND chapter LIKE '".$dat['chapter']."'";
    $s = mysqli_query($connect, $q);
    $cek = mysqli_num_rows($s);
    $chap = "";
    if ($cek > 0) {
        $stat= mysqli_fetch_assoc($s);
        if($stat['status'] == '0' || $stat['status'] == 0) {
            $download = ' <button class="btn btn-xs btn-success" id="down-'.$dat['chapter'].'" onclick="downloadManga(' . $dat['chapter'] .')" id_manga="'.$id_manga.'" source="'.$dat['source'].'"><i class="fas fa-download"></i></button><a class="btn btn-xs btn-success hidden" id="view-'.$dat['chapter'].'" href="viewer.php?id_manga='.$id_manga.'&chapter='.$dat['chapter'].'" target="_blank"><i class="fas fa-eye"></i></a><button class="btn btn-xs btn-success hidden" id="btnLoad-'.$dat['chapter'].'" disabled><i class="fas fa-spinner fa-pulse"></i></button>';
        } else {
            $download = ' <a class="btn btn-xs btn-success" href="viewer.php?id_manga='.$id_manga.'&chapter='.$dat['chapter'].'" target="_blank"><i class="fas fa-eye"></i></a>';
        }

        $chap = "Chapter " . $dat['chapter'];
    } else {
        $download = ' <button class="btn btn-xs btn-success" id="down-'.$dat['chapter'].'" onclick="downloadManga(' . $dat['chapter'] .')" id_manga="'.$id_manga.'" source="'.$dat['source'].'"><i class="fas fa-download"></i></button><a class="btn btn-xs btn-success hidden" id="view-'.$dat['chapter'].'" href="viewer.php?id_manga='.$id_manga.'&chapter='.$dat['chapter'].'" target="_blank"><i class="fas fa-eye"></i></a><button class="btn btn-xs btn-success hidden" id="btnLoad-'.$dat['chapter'].'" disabled><i class="fas fa-spinner fa-pulse"></i></button>';
    }

    $qn = "SELECT chapter FROM user_history WHERE id_user='$id_user' AND id_manga='$id_manga' ORDER BY chapter DESC LIMIT 1";
    $sn = mysqli_query($connect,$qn);
    $get = mysqli_fetch_assoc($sn);
    $last = $get['chapter'];

    if ($dat['chapter'] > $last) {
        $chap = "<b>Chapter " . $dat['chapter'] . "</b>";
    } else {
        $chap = "Chapter " . $dat['chapter'];
    }
    
    $chapter .= '<tr>
                    <td>'.$chap.'</td>
                    <td class="text-right">'. get_timeago(strtotime($dat['release_date'])) .$download.'</td>
                </tr>';
}

$result = '<div class="col-xs-5 col-md-2 ">
                <img width="120" height="170" class="img" src="assets/manga/' . $id_manga . "/" . $image.'">
            </div>
            <div class="col-xs-7 col-md-10">
                <h3>'.$title.'</h3>
                <h4>'.base64_decode($native).'</h4>
                <div class="row">
                    <div class="col-md-6">
                        <dl class="dl-horizontal">
                            <dt class="text-left">Genres</dt>
                            <dd>'.$genre.'</dd>
                            <dt class="text-left">Release Date</dt>
                            <dd>'.$release_date.'</dd>
                            <dt class="text-left">Type</dt>
                            <dd>'.ucfirst($type).'</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="dl-horizontal">
                            <dt class="text-left">Status</dt>
                            <dd id="status">'.ucfirst($status).'</dd>
                            <dt class="text-left">Author</dt>
                            <dd id="author">'.$author.'</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border bg-primary">
                    <h3 class="box-title text-white">Sinopsis</h3>
                    <button class="btn btn-xs btn-success pull-right">RESUME</button>
                    </div>
                    <div class="box-body bg-primary">
                        '.base64_decode($description).'
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border bg-primary">
                    <h3 class="box-title text-white">Chapter</h3>
                    </div>
                    <div class="box-body bg-primary">
                        <table class="table table-striped">
                            <tbody>
                            '. $chapter .'
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';
echo $result;
?>