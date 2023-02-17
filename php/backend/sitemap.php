<?php
function update_sitemap($id){
    $date = date('Y-m-d', time());//date and time formatted for sitemap
    $url = 'https://onoranze.stecca.dev/epigrafe.php?id=' . $id;
    $lines = file('sitemap.xml');
    $last = sizeof($lines) - 1 ;
    unset($lines[$last]);
    $fp = fopen('sitemap.xml', 'w') or die("Unable to open file!");
    fwrite($fp, implode('', $lines));
    fclose($fp);
    //^ the above code deletes the last line from the sitemap.xml file </urlset>
    $myfile = fopen("sitemap.xml", "a") or die("Unable to open file!");
    $txt = "    <url>
        <loc>$url</loc>
        <lastmod>$date</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
</urlset>";
    fwrite($myfile, "". $txt);
    fclose($myfile);
}
?>