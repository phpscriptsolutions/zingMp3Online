<?php
if (!empty($_GET["url"])) {
    $url = $_GET["url"];
    if (strpos($url, "ttp://") == null || strpos($url, "zing.vn") == null) {
        echo "<h3 class='list-group-item list-group-item-danger'>Link không hợp lệ <img src='img/cry.png'/></h3>";
    }
    else {
        if (strpos($url, "://mp3") != null) {
            $arr = explode("http://", $url);
            $urlm = "http://m." . $arr[1];
        } else if (strpos($url, "://m.mp3.zing.vn") != null) {
            $urlm = $url;
        }

        if ($content = file_get_contents($urlm)) {
            //Get img ava
            $content1 = explode("property=\"og:image\" content=\"", $content)[1];
            $img = explode("\"", $content1)[0];

            //Get lyric
            $lyric = explode("<p id=\"conLyrics\" class=\"row-5\">", $content)[1];
            $lyric = explode("</p>", $lyric)[0];

            //Get infomation song
            $content = explode("xml=\"", $content)[1];
            $xmlURL = explode("\"", $content)[0];
            $jsonContent = file_get_contents($xmlURL);
            $music = json_decode($jsonContent);
            $data = $music->data[0];

            //Content
            $title = $data->title;
            $singer = $data->performer;
            $mp3 = $data->source;
            $link320 = "http://mp3.zing.vn/download/vip/song/" . getID($url);

            echo "<li class=\"list-group-item list-group-item-info\"><h3 style=\"font-weight: bold;\">" . $title . "</h3></li>";
            echo "<li class=\"list-group-item list-group-item-info\">Thể hiện: <strong>" . $singer . "</strong></li>";
            echo "<li class=\"list-group-item list-group-item-info\">Download: <a href=\"" . $mp3 . "\" download=\"" . $mp3 . "\">128 kpbs</a> - <a href=\"" . $link320 . "\" download=\"" . $link320 . "\">320 kpbs</a></li>";
            echo "<li class=\"list-group-item list-group-item-warning\"><p>" . $lyric . "</p></li>";
        }
        else {
            echo "<h3 class='list-group-item list-group-item-danger'>Đã có lỗi xảy ra <img src='img/cry.png'/></h3>";
        }
    }
}
else {
    die("No!");
}

function getID($url) {
    $url = str_replace(".", "/", $url);
    $arr = explode("/", $url);
    $pos = count($arr) - 2;
    return $arr[$pos];
}
?>