<?
include "global.php" ;
run_template('page_head');

$qr = db_query("select title,id from songs_news order by id DESC limit 20");

 print "
    <marquee onmouseover=\"this.stop()\"
    onmouseout=\"this.start()\" scrollAmount=\"5\" scrollDelay=\"0\" direction=right   width=\"100%\">"    ;

    while($data = db_fetch($qr))
    {

            print " &nbsp&nbsp&nbsp <a href='news_view_{$data['id']}.html' target='_blank'>$data[title]</a> &nbsp&nbsp&nbsp ** ";
            }

            print "</marquee>";

            ?>