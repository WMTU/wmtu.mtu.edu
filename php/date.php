<?php
header('Content-Type: text/xml');

echo "<?xml version='1.0' encoding='utf-8'?>\n";
echo "<rss version='2.0'>\n";
echo "<channel>\n";
echo "<title>".date("l, F j, Y")."</title>\n";
echo "<link>http://bustyloli.ch</link>\n";
echo "<description>The date</description>\n";
echo "<language>en-us</language>\n";
echo "<item></item>\n";
echo "</channel>\n";
echo "</rss>\n";
?>
