<?php

    $id_manga = $_GET['id_manga'];
    require_once('../config/db.php');

    $query = "SELECT * FROM manga WHERE id_manga='$id_manga'";
    $sql = mysqli_query($connect, $query);
    $data = mysqli_fetch_assoc($sql);
    $url = $data['source'];
    $title = $data['title'];

    $content = file_get_contents($url);
    $first = explode( '<div class="cl">' , $content );
    $second = explode('<div class="bixbox">' , $first[1] );
    $result = $second[0];
    preg_match_all("#<a ?.*>(.*)<\/a>#", $result, $result_chapter);
    preg_match_all("#<span class=\"rightoff\">(.*)<\/span>#", $result, $date_chapter);

    $query = "SELECT * FROM chapter WHERE id_manga='$id_manga' ORDER BY chapter DESC LIMIT 1";
    $sql = mysqli_query($connect, $query);
    $res = mysqli_fetch_assoc($sql);
    $chapter = $res['chapter'];
    if (strlen($chapter) == 1) {
        $chapter = 0 . $chapter;
    }
    $index_now =  array_search("Chapter " . $chapter, $result_chapter[1]);

    if ($index_now > 0) {

        $new_update = array();

        for($i=0; $i < $index_now; $i++) {
            $new_update[0][] = $result_chapter[1][$i];
            $new_update[1][] = $result_chapter[0][$i];
        }

        function dateConverter($time) {
            $explode = explode(" ", $time);
            date_default_timezone_set('Asia/Jakarta');
            if ($explode[1] == "min" || $explode[1] == "mins") {
        
                $date = time() - ($explode[0]*60);
            } else if ($explode[1] == "hour" || $explode[1] == "hours") {
                $date = time() - ($explode[0]*(60*60));
            } else if ($explode[1] == "day" || $explode[1] == "days") {
                $date = time() - ($explode[0]*(24*60*60));
            } else if ($explode[1] == "week" || $explode[1] == "weeks") {
                $date = time() - ($explode[0]*(7*24*60*60));
            } else if ($explode[1] == "month" || $explode[1] == "months") {
                $date = time() - ($explode[0]*(30*24*60*60));
            } else if ($explode[1] == "year" || $explode[1] == "years") {
                $date = time() - ($explode[0]*(12*30*24*60*60));
            }
            return date("Y-m-d H:i:s", $date);
        }

        $query = "INSERT INTO chapter (id_manga, chapter, release_date, source) VALUES ";
        for ($i=0;$i < sizeof($new_update[1]);$i++) {
            $xpath = new DOMXPath(@DOMDocument::loadHTML($new_update[1][$i]));
            $src = $xpath->evaluate("string(//a/@href)");
            $query .= "('".$id_manga."', '". str_replace("Chapter ", "", $new_update[0][$i]) ."', '". dateConverter($date_chapter[1][$i]) ."', '". $src ."'),";
        }
        $query = substr($query, 0, -1);
        $sql = mysqli_query($connect, $query);
        if($sql) {
            $result_data['status'] = "update";
            $result_data['result'] = "<div class=\"update\">Manga " . $title . " has been updated</div>";
        }
    } else {
        $result_data['status'] = "no update";
        $result_data['result'] = "<div class=\"no-update\">Manga " . $title . "has no update</div>";
    }

    echo json_encode($result_data);

?>