<?
include_once("global.php") ;
header("Content-Type: text/html;charset=$settings[site_pages_encoding]");

print "<table width=98% style=\"padding: 0\"><tr><td>";
$qr = db_query("select * from songs_dedications where active=1 order by id desc limit 20");
if(db_num($qr)){
print " <marquee align=\"right\" direction=\"right\" scrollamount=\"4\" style=\"font-family: Tahoma; font-size: 12px;  LINE-HEIGHT: 30px; text-decoration: none direction: rtl; text-align: right;\" onmouseover=\"this.scrollAmount=0\" onmouseout=\"this.scrollAmount='5'\">     \n";
print "&nbsp;&nbsp;*ـ*&nbsp;&nbsp;";
while($data = db_fetch($qr)){
$data['msg'] = addslashes($data['msg']);

$emo_qr = db_query("select * from songs_emotions");
while($emo_data = db_fetch($emo_qr)){
$data['msg'] = str_replace($emo_data['value'],"<img src=\"$emo_data[img]\">",$data['msg']);
}

$qr_user = db_query("select id from songs_members where username='$data[user]'");
if(db_num($qr_user)){
        $data_user = db_fetch($qr_user);
print "<b><a href='profile_$data_user[id].html' target=_blank>$data[user]</a>:</b>";
}else{
print "<b>$data[user]:</b>";
}
print "&nbsp;$data[msg]&nbsp;&nbsp;*ـ*&nbsp;&nbsp;" ;
        }
print "</marquee>";
}else{
        print "<center>  لا توجد إهدائات </center>";
        }
print "</td><td width=10%>
<a href='#' onclick=\"window.open('send_dedication.php','displaywindow','toolbar=no,scrollbars=no,width=350,height=380,top=200,left=200');return false;\"> ارسل إهداء </a>
<br>
<a href=\"javascript:get_dedications();\">تحديث</a>
</td></tr></table>";