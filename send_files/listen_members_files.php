<?
require("global.php");
$data = db_qr_fetch("select url from members_files where id='".$id."'");
$url = $data['url'];
 run_template('song_listen');