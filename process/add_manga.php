<?php
$url = $_GET['url'];
$id_user = $_GET['id_user'];
require_once '../config/db.php';
$split = explode(" ", $url);
$chapter = "";
if (sizeof($split) > 1) {
    $url = $split[0];
    $chapter = $split[1];
}

$query_cek_manga = "SELECT * FROM manga WHERE source='".$url."'";
$sql_cek_manga = mysqli_query($connect, $query_cek_manga);
$tit = mysqli_fetch_assoc($sql_cek_manga);
$title = $tit['title'];
$isExist = false;
$isManga = false;
$isDetail = false;
$isGenre = false;
$isAuthor = false;
$isChapter = false;

if(mysqli_num_rows($sql_cek_manga) > 0) {
    $isExist= true;
} else {
    $content = file_get_contents($url);
    $first_step = explode( '<div class="infox">' , $content );
    $second_step = explode('<div class="rt">' , $first_step[1] );
    $result = $second_step[0];
    //title
    preg_match_all("#<h1 ?.*>(.*)<\/h1>#", $result, $title);
    $title = str_replace("Bahasa Indonesia", "", $title[1][0]);
    //native
    preg_match_all("#<span class=\"alter\">(.*)<\/span>#", $result, $native);
    $native = base64_encode($native[1][0]);
    //Genre
    $third = explode( '<b>Genres:</b>' , $result );
    $fourth = explode('</span>' , $third[1] );
    $raw_genres = explode(",",strip_tags($fourth[0]));

    //Release Date
    preg_match_all("#<span class=\"split\">(.*)<\/span>#", $result, $date);
    $raw_date = strip_tags($date[1][0]);
    $clean_date = str_replace("Released: ","", $raw_date);
    if ($clean_date == "?") {
        $release_date = "";
    } else {
        $cek_date = explode(" to ", $clean_date);
        if ($cek_date > 1) {
            $date=date_create($cek_date[0]);
            $release_date = date_format($date,"Y-m-d");
        } else {
            $date=date_create($clean_date);
            $release_date = date_format($date,"Y-m-d");
        }
    }
    //Type
    $fifth = explode( '<b>Type:</b>' , $result );
    $sixth = explode('</span>' , $fifth[1] );
    $type = str_replace(" ","", strip_tags($sixth[0]));
    //Status
    $seventh = explode( '<b>Status:</b>' , $result );
    $eight = explode('</span>' , $seventh[1] );
    $status = str_replace(" ","", strip_tags($eight[0]));
    //Author
    $ninth = explode( '<b>Author:</b>' , $result );
    $ten = explode('</span>' , $ninth[1] );
    if (str_replace(" ", "", $ten[0]) == "?" || str_replace(" ", "", $ten[0]) == ""){
        $query_insert_author_detail = "INSERT INTO author_detail (name, job) VALUES ('?', '?')";
        $sql_insert_author_detail = mysqli_query($connect, $query_insert_author_detail);
        $query_get_author = "SELECT * FROM author_detail WHERE name='?'";
        $sql_get_author = mysqli_query($connect, $query_get_author);
        $fetch_id_author = mysqli_fetch_assoc($sql_get_author);
        $id_author = $fetch_id_author['id_author_detail'];
        $list_id_author[] = array($id_author);
    } else {
        $separate_author = str_replace("),", ")batas", str_replace(" ","", strip_tags($ten[0])));
        if (strpos($separate_author, ')batas') !== false) {
            $each_author = explode("batas", $separate_author);
            for($i=0;$i<sizeof($each_author);$i++) {
                $get = explode("(", $each_author[$i], 2);
                $fix_name = str_replace(",", " ", $get[0]);
                $fix_job = str_replace(")", "", $get[1]);
                if ($fix_job == "") {
                    $fix_job = "?";
                } else {
                    $fix_job = str_replace(")", "", $get[1]);
                }
                $query_get_author = "SELECT * FROM author_detail WHERE name='". $fix_name ."'";
                $sql_get_author = mysqli_query($connect, $query_get_author);
                if (mysqli_num_rows($sql_get_author) > 0) {
                    $fetch_id_author = mysqli_fetch_assoc($sql_get_author);
                    $id_author = $fetch_id_author['id_author_detail'];
                } else {
                    $query_insert_author_detail = "INSERT INTO author_detail (name, job) VALUES ('". $fix_name. "', '". $fix_job ."')";
                    $sql_insert_author_detail = mysqli_query($connect, $query_insert_author_detail);
                    if ($sql_insert_author_detail) {
                        $query_get_id_author_detail = "SELECT MAX(id_author_detail) AS id_author FROM author_detail";
                        $sql_get_id_author_detail = mysqli_query($connect, $query_get_id_author_detail);
                        $fetch_id_author_detail = mysqli_fetch_assoc($sql_get_id_author_detail);
                        $id_author = $fetch_id_author_detail['id_author'];
                    }
                }
                $list_id_author[] = array($id_author);
            }
        } else {
            $query_get_author = "SELECT * FROM author_detail WHERE name='". $separate_author ."'";
            $sql_get_author = mysqli_query($connect, $query_get_author);
            if (mysqli_num_rows($sql_get_author) > 0) {
                $fetch_id_author = mysqli_fetch_assoc($sql_get_author);
                $id_author = $fetch_id_author['id_author_detail'];
            } else {
                $query_insert_author_detail = "INSERT INTO author_detail (name, job) VALUES ('". $separate_author. "', '?')";
                $sql_insert_author_detail = mysqli_query($connect, $query_insert_author_detail);
                if ($sql_insert_author_detail) {
                    $query_get_id_author_detail = "SELECT MAX(id_author_detail) AS id_author FROM author_detail";
                    $sql_get_id_author_detail = mysqli_query($connect, $query_get_id_author_detail);
                    $fetch_id_author_detail = mysqli_fetch_assoc($sql_get_id_author_detail);
                    $id_author = $fetch_id_author_detail['id_author'];
                }
            }
            $list_id_author[] = array($id_author);
        }
    }
    //Description
    $eleventh = explode( '<div class="sinopc" style="text-align: justify;">' , $content );
    if (sizeof($eleventh) == 1) {
        $eleventh = explode( '<div itemprop="articleBody">' , $content );
        $twelves = explode('</div>' , $eleventh[1]);
        $description = base64_encode($twelves[0]);
    } else {
        $twelves = explode('<div class="ads">' , $eleventh[1]);
        $description = base64_encode($twelves[0]);
    }
    //Images
    $thirdteen = explode('<div class="thumb" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">', $content);
    $fourteen = explode('</div>' , $thirdteen[1]);
    preg_match_all("#<img ?.*/>#", $thirdteen[0], $images);
    preg_match('/src\s*=\s*"(.+?)"/', $images[0][0], $src);
    $img_src = $src[1];
    if (strpos($img_src, '.jpg') !== false) {
        $link_img = 'thumbnail.jpg';
    } else if (strpos($img_src, '.png') !== false){
        $link_img = 'thumbnail.png';
    } else if (strpos($img_src, '.jpeg') !== false){
        $link_img = 'thumbnail.jpeg';
    }
    
    // QUERY SECTION
    // MANGA TABLE
    if ($status == "Ongoing") {
        $status = "airing";
    } else if ($status == "Completed") {
        $status = "Completed";
    } else {
        $status = $status;
    }
    //INSERT MAIN TABLE (MANGA)

    $query_manga = "INSERT INTO manga (title, image, source, type, status) VALUES ('". $title ."', '". $link_img ."', '". $url ."', '". $type ."', '". $status ."')";
    $sql_manga = mysqli_query($connect, $query_manga);
    if ($sql_manga) {
        $isManga = true;
        //GET MANGA ID FROM INSERT BEFORE
        $query_id = "SELECT id_manga FROM manga WHERE source='$url'";
        $sql_id = mysqli_query($connect, $query_id);
        $data_id = mysqli_fetch_assoc($sql_id);
        $id_manga = $data_id['id_manga'];
        // INSERT MANGA DETAIL BASED ON MANGA ID BEFORE
        $query_detail = "INSERT INTO manga_detail (id_manga, release_date, native_title, description) VALUES ('". $id_manga ."', '". $release_date ."', '". $native ."', '". $description ."')";
        $sql_detail = mysqli_query($connect, $query_detail);
        if ($sql_detail) {
            $isDetail = true;
            $query_genre = "INSERT INTO genre (id_manga, id_genre_detail) VALUES ";
            for($i=0;$i<sizeof($raw_genres);$i++) {
                $cleanGenre = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $raw_genres[$i])));
                $query_get_id = "SELECT id_genre_detail AS id FROM genre_detail where name='". $cleanGenre ."'";
                $sql_get_id = mysqli_query($connect, $query_get_id);
                $id_genre = mysqli_fetch_assoc($sql_get_id);
                $query_genre .= "('".$id_manga."', '". $id_genre['id'] ."'),";
            }
            $query_genre = substr($query_genre, 0, -1);
            $sql_genre = mysqli_query($connect, $query_genre);
            if ($sql_genre) {
                $isGenre = true;
                $query_insert_author = "INSERT INTO author (id_manga, id_author_detail) VALUES ";
                for ($i=0; $i<sizeof($list_id_author);$i++) {
                    $query_insert_author .= "('".$id_manga."', '". $list_id_author[$i][0] ."'),";
                }
                $query_insert_author = substr($query_insert_author, 0, -1);
                $sql_insert_author = mysqli_query($connect, $query_insert_author);
                if($sql_insert_author) {
                    $isAuthor = true;

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
                    $first_manga = explode( '<div class="cl">' , $content );
                    $second_manga = explode('<div class="bixbox">' , $first_manga[1] );
                    $result_manga = $second_manga[0];
                    preg_match_all("#<a ?.*>(.*)<\/a>#", $result_manga, $data);
                    preg_match_all("#<span class=\"rightoff\">(.*)<\/span>#", $result_manga, $data2);
                    $query_chapter = "INSERT INTO chapter (id_manga, chapter, release_date, source) VALUES ";
                    for ($i=0;$i < sizeof($data[0]);$i++) {
                        $xpath = new DOMXPath(@DOMDocument::loadHTML($data[0][$i]));
                        $src = $xpath->evaluate("string(//a/@href)");
                        $query_chapter .= "('".$id_manga."', '". str_replace("Chapter ", "", $data[1][$i]) ."', '". dateConverter($data2[1][$i]) ."', '". $src ."'),";
                    }
                    $query_chapter = substr($query_chapter, 0, -1);
                    $sql_chapter = mysqli_query($connect, $query_chapter);
                    if ($sql_chapter) {

                        if ($chapter != "") {
                            $now = date("Y-m-d");
                            $query_user = "INSERT INTO user_history (id_user, id_manga, chapter, read_date) VALUES ('$id_user', '$id_manga', '$chapter', '$now')";
                            $sql_user = mysqli_query($connect, $query_user);
                        }

                        $isChapter = true;
                        if(!is_dir('../assets/manga/'.$id_manga)) {
                            mkdir('../assets/manga/'.$id_manga);
                            $save = '../assets/manga/'. $id_manga .'/' . $link_img; 
                            $ch = curl_init($img_src);
                            $fp = fopen($save, 'wb');
                            curl_setopt($ch, CURLOPT_FILE, $fp);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_exec($ch);
                            curl_close($ch);
                            fclose($fp);
                        }
                    } else {
                        $isChapter = false;
                    }
                } else {
                    $isAuthor = false;
                }
            } else {
                $isGenre = false;
            }
        } else {
            $isDetail = false;
        }
    } else {
        $isManga = false;
    }
}
if ($isExist) {
    $hasil["isExist"] = 'true';
    $hasil["msg"] = $title;
} else {
    $hasil["isExist"] = 'false';
    $hasil["result"] = "sukses";
    $hasil["msg"] = $title;
}

echo json_encode($hasil);
?>