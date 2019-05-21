<?php
session_start();
require_once('config/db.php');
$id_manga = $_GET['id_manga'];
$id_user = $_SESSION['id_user'];
$chapter = $_GET['chapter'];
$date = date("Y-m-d");
if ($id_manga == "") {
    header('location: index.php?page=404');
} else if ($chapter == "") {
    header('location: index.php?page=404');
} else {
    $query = "SELECT user_history.chapter, user_history.status, chapter.source FROM user_history INNER JOIN chapter ON user_history.chapter=chapter.chapter AND user_history.id_manga=chapter.id_manga WHERE user_history.id_user='$id_user' AND user_history.id_manga='$id_manga' AND user_history.chapter LIKE '$chapter'";
    $sql = mysqli_query($connect, $query);
    $cek = mysqli_num_rows($sql);

    if ($cek == 1) {
        $data = mysqli_fetch_assoc($sql);
        $status = $data['status'];
        $source = $data['source'];
        if ($status == "1") {
            $query = "SELECT * FROM manga WHERE id_manga='$id_manga'";
            $sql = mysqli_query($connect, $query);
            $data = mysqli_fetch_assoc($sql);
            $title = $data['title'];
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>Chapter <?php echo $chapter; ?> - <?php echo $title ?></title>
                <link rel="stylesheet" href="dist/Bootstrap/css/bootstrap.min.css">
                <style>
                    body {
                        margin-top: 10px;
                        margin-bottom: 10px;
                        background: #232937;
                    }
                    .img-view {
                        width: 100%;
                        height: auto;
                    }
                    .image-load {
                        background-image: url("assets/loading.gif");
                        background-position: center;
                        background-repeat: no-repeat;
                    }
                    .text-white {
                        color: #FFFFFF;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="row">
                        <?php
                        $query = "SELECT chapter FROM chapter WHERE id_manga='$id_manga' ORDER BY chapter ASC";
                        $sql = mysqli_query($connect, $query);
                        $chap = array();
                        foreach($sql as $data) {
                            array_push($chap, $data['chapter']);
                        }
                        $index_now =  array_search($chapter, $chap);
                        ?>
                        <div class="col-xs-3 col-md-4">
                            <?php
                                if ($index_now <= 0) {
                                    ?>
                                    <a href="#" disabled class="btn btn-primary pull-left">PREV</a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="viewer.php?id_manga=<?php echo $id_manga;?>&chapter=<?php echo $chap[$index_now - 1];?>" class="btn btn-primary pull-left">PREV</a>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <select name="select_chapter" id="select_chapter" class="form-control">
                                <?php 
                                    $query = "SELECT * FROM chapter WHERE id_manga='$id_manga'";
                                    $sql = mysqli_query($connect, $query);
                                    foreach($sql as $data) {
                                        ?>
                                <option value="<?php echo $data['chapter'] ?>" <?php if ($data['chapter'] == $chapter) {echo "selected";} ?>>Chapter <?php echo $data['chapter'] ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-3 col-md-4">
                            <?php
                                if ($index_now >= sizeof($chap) - 1) {
                                    ?>
                                    <a href="#" disabled class="btn btn-primary pull-right">NEXT</a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="viewer.php?id_manga=<?php echo $id_manga;?>&chapter=<?php echo $chap[$index_now + 1];?>" class="btn btn-primary pull-right">NEXT</a>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="col-md-12 text-center">
                            <h3 class="text-white">
                            <?php
                            echo $title;
                            ?> - Chapter <?php echo $chapter; ?>
                            </h1>
                        </div>
                        <?php
                            $dir = "assets/manga/$id_manga/$chapter/";
                            $a = scandir($dir);
                            unset($a[0]);
                            unset($a[1]);
                            sort($a, SORT_NUMERIC);
                            $i=1;
                            for($i;$i<sizeof($a);$i++) {
                            ?>
                            <div class="image-load">
                                <img class="img-view" src="<?php echo $dir . $a[$i]; ?>"/>
                            </div>
                            <?php   
                            }
                        ?>
                        <div class="col-xs-3 col-md-4">
                            <?php
                                if ($index_now <= 0) {
                                    ?>
                                    <a href="#" disabled class="btn btn-primary pull-left">PREV</a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="viewer.php?id_manga=<?php echo $id_manga;?>&chapter=<?php echo $chap[$index_now - 1];?>" class="btn btn-primary pull-left">PREV</a>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <select name="select_chapter" id="select_chapter" class="form-control">
                                <?php 
                                    $query = "SELECT * FROM chapter WHERE id_manga='$id_manga'";
                                    $sql = mysqli_query($connect, $query);
                                    foreach($sql as $data) {
                                        ?>
                                <option value="<?php echo $data['chapter'] ?>" <?php if ($data['chapter'] == $chapter) {echo "selected";} ?>>Chapter <?php echo $data['chapter'] ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-3 col-md-4">
                            <?php
                                if ($index_now >= sizeof($chap) - 1) {
                                    ?>
                                    <a href="#" disabled class="btn btn-primary pull-right">NEXT</a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="viewer.php?id_manga=<?php echo $id_manga;?>&chapter=<?php echo $chap[$index_now + 1];?>" class="btn btn-primary pull-right">NEXT</a>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <script src="dist/jQuery/jquery.min.js"></script>
                <script src="dist/Bootstrap/js/bootstrap.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $("#select_chapter").change(function() {
                            var id_manga = <?php echo $id_manga ?>;
                            var chapter = $(this).val();
                            window.location.href = "viewer.php?id_manga=" + id_manga + "&chapter=" + chapter;
                        });
                    });
                </script>
            </body>
            </html>
<?php
        } else {
            ?>
            <div class="col-md-12 text-center">
            <i class="fas fa-spinner fa-pulse fa-3x"></i>
            </div>
            <?php
            set_time_limit(3000);
            $url = $source;

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
                if(!is_dir('assets/manga/'. $id_manga .'/' . $chapter)) {
                    mkdir('assets/manga/'. $id_manga .'/' . $chapter);
                }
                
                $file_name = 'assets/manga/'. $id_manga .'/' . $chapter .'/' . $nama_img;
                $ch = curl_init($data);
                $fp = fopen($file_name, 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);
                $i++;
            }

            $result = array();
            $query = "SELECT * FROM user_history WHERE id_user='$id_user' AND id_manga='$id_manga' AND chapter LIKE '$chapter'";
            $sql = mysqli_query($connect, $query);
            $cek = mysqli_num_rows($sql);
            if($cek > 0) {
                $query = "UPDATE user_history SET status='1', read_date='$date' WHERE id_user='$id_user' AND id_manga='$id_manga' AND chapter LIKE '$chapter'";
                $sql = mysqli_query($connect, $query);
                if ($sql) {
                    header('Refresh: 0');
                }
            }else {
                $query = "INSERT INTO user_history (id_user, id_manga, chapter, read_date, status) VALUES ('$id_user', '$id_manga', '$chapter', '$date', '1')";
                $sql = mysqli_query($connect, $query);
                if($sql) {
                    header('Refresh: 0');
                }
            }
        }
    } else {
        ?>
        <div class="col-md-12 text-center">
        <i class="fas fa-spinner fa-pulse fa-3x"></i>
        </div>
        <?php
        $query = "INSERT INTO user_history (id_user, id_manga, chapter, read_date) VALUES ('$id_user', '$id_manga', '$chapter', $date)";
        $sql = mysqli_query($connect, $query);
        if ($sql) {
            $query = "SELECT source FROM chapter WHERE id_manga='10' AND chapter LIKE '$chapter'";
            $sql = mysqli_query($connect, $query);
            $data = mysqli_fetch_assoc($sql);
            $url = $data['source'];
            set_time_limit(3000);

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
                if(!is_dir('assets/manga/'. $id_manga .'/' . $chapter)) {
                    mkdir('assets/manga/'. $id_manga .'/' . $chapter);
                }
                
                $file_name = 'assets/manga/'. $id_manga .'/' . $chapter .'/' . $nama_img;
                $ch = curl_init($data);
                $fp = fopen($file_name, 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);
                $i++;
            }

            $result = array();
            $query = "SELECT * FROM user_history WHERE id_user='$id_user' AND id_manga='$id_manga' AND chapter LIKE '$chapter'";
            $sql = mysqli_query($connect, $query);
            $cek = mysqli_num_rows($sql);
            if($cek > 0) {
                $query = "UPDATE user_history SET status='1', read_date='$date' WHERE id_user='$id_user' AND id_manga='$id_manga' AND chapter LIKE '$chapter'";
                $sql = mysqli_query($connect, $query);
                if ($sql) {
                    header('Refresh: 0');
                }
            }else {
                $query = "INSERT INTO user_history (id_user, id_manga, chapter, read_date, status) VALUES ('$id_user', '$id_manga', '$chapter', '$date', '1')";
                $sql = mysqli_query($connect, $query);
                if($sql) {
                    header('Refresh: 0');
                }
            }
        }
    }
}
?>