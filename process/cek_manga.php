<?php
$url = $_GET['url'];
require_once '../config/db.php';

$query_cek_manga = "SELECT * FROM manga WHERE source='$url'";
$sql_cek_manga = mysqli_query($connect, $query_cek_manga);

$isExist = false;

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
    $native = $native[1][0];
    //Genre
    $third = explode( '<b>Genres:</b>' , $result );
    $fourth = explode('</span>' , $third[1] );
    $genres = strip_tags($fourth[0]);
    //Release Date
    preg_match_all("#<span class=\"split\">(.*)<\/span>#", $result, $date);
    $raw_date = strip_tags($date[1][0]);
    $clean_date = str_replace("Released: ","", $raw_date);
    $date=date_create($clean_date);
    $release_date = date_format($date,"d M Y");
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
    $author = $ten[0];

    //Description
    $eleventh = explode( '<div class="sinopc" style="text-align: justify;">' , $content );
    if (sizeof($eleventh) == 1) {
        $eleventh = explode( '<div itemprop="articleBody">' , $content );
        $twelves = explode('</div>' , $eleventh[1]);
        $description = $twelves[0];
    } else {
        $twelves = explode('<div class="ads">' , $eleventh[1]);
        $description = $twelves[0];
    }
    //Images
    $thirdteen = explode('<div class="thumb" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">', $content);
    $fourteen = explode('</div>' , $thirdteen[1]);
    preg_match_all("#<img ?.*/>#", $thirdteen[0], $images);
    $randName = substr(md5(microtime()),rand(0,26),5);
    $xpath = new DOMXPath(@DOMDocument::loadHTML($images[0][0]));
    $src = $xpath->evaluate("string(//img/@src)");

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

}
if ($isExist) {
    $hasil["isExist"] = $isExist;
} else {
    $hasil["isExist"] = $isExist;
    $hasil["result"]["title"] = $title;
    $hasil["result"]["native"] = $native;
    $hasil["result"]["genres"] = $genres;
    $hasil["result"]["release_date"] = $release_date;
    $hasil["result"]["description"] = $description;
    $hasil["result"]["author"] = $author;
    $hasil["result"]["images"] = $src;
    $hasil["result"]["link"] = $url;
    $hasil["result"]["type"] = $type;
    $hasil["result"]["status"] = $status;
}

header('Content-Type: application/json');
echo json_encode($hasil);
?>