<?php
    $rss_title = "WMTU Playlist Track-Back";
    $rss_site = "wmtu.mtu.edu";
    $rss_description = "This RSS contains the last 3 songs played on WMTU.";
    $rss_logo;
    $emailadmin = "hehe";
    header("Content-Type: text/xml;charset=iso-8859-1");
    $userName = 'wmtudjlogs';
    $pass = 'password';
    $DBserver = 'localhost';
    $finalXML = '';

    /* Database Connection and Selection */
    $mysqlCon = mysql_connect($DBserver, $userName, $pass);
    if (!$mysqlCon) {
        die('Could not connect: ' . mysql_error());
    }

    $djLogsDB = mysql_select_db('djlogs', $mysqlCon);
    if (!$djLogsDB) {
        die('Could not load database: ' . mysql_error());
    }

    /* Get data from the table */
    $query = "select artist, song_name, album, ts from djlogs ORDER BY ID DESC LIMIT 3";
    $data = mysql_query($query);

    /* Generate RSS */
    /* Header shiat */
    $finalXML = $finalXML.'<?xml version="1.0" encoding="ISO-8859-1" ?>
    <rss version="2.0">
    <channel>
    <title>' . $rss_title . '</title>
    <link>http://' . $rss_site . '</link>
    <description>' . $rss_description . '</description>
    <language>en-en</language>';

    /*Index for ranking*/
    $index = 1;

    /* Song list time */
    while ($row = mysql_fetch_assoc($data)) {
        $photo_name = 'http://www.yoursite.com/images/whatever-the-image-could-be.gif';

        $subject = 'WMTU Music Track-Back';

        $url_product = 'wmtu.mtu.edu'; //however you would link to your article

        $song = "";
        $album = "";
        $artist = "";

        $artist = "Artist: " . $row['artist'];
        $song = "Song: " . $row['song_name'];
        $album = "Album: " . $row['album'];

        $description = $artist . " " . $song . " " . $album;

        // Have to remove the &'s
        $artist = str_replace("&", "&amp;", $artist);
        $song = str_replace("&", "&amp;", $song);
        $album = str_replace("&", "&amp;", $album);
        $description = str_replace("&", "&amp;", $description);

        // Pass tags to describe the product (this has been left out of this example)

        $rss_tags = '';

        //makes a 500 character long copy of the desciption - a teaser of your content for people to read

        $short_description = substr($description, 0, 500) . "...";

        //to record when the feed was published

        $timestamp = $row['ts'];

        //converts the timestamp into a RSS-friendly format

        $pubdate = date("r", strtotime($timestamp));
        $finalXML = $finalXML."<item>";
        $finalXML = $finalXML."<title>" . $subject . "</title>";
        $finalXML = $finalXML."<description>" . $description . "</description>";
        $finalXML = $finalXML."<link>" . "</link>";
        $finalXML = $finalXML."<guid>" . $row['id'] . "</guid>";
        $finalXML = $finalXML."<pubDate>" . $pubdate . "</pubDate>";
        $finalXML = $finalXML."<song>" . $song . "</song>";
        $finalXML = $finalXML."<artist>" . $artist . "</artist>";
        $finalXML = $finalXML."<album>" . $album . "</album>";
        $finalXML = $finalXML."<rank>" . $index . ": </rank>";
        $finalXML = $finalXML."</item>";
        $index = $index + 1;
    }
    $finalXML = $finalXML. '</channel>';
    $finalXML = $finalXML. '</rss>';
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    $dom->loadXML($finalXML);
    $dom->formatOutput = true;
    echo $dom->saveXML();
?>
