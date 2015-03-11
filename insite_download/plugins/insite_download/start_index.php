<?
if($action=="download"){
$id= (int) $id;
$cat = (int) $cat;
if(!$cat){$cat=1;}

   

 $data = db_qr_fetch("select songs_songs.name,songs_songs.album_id, songs_singers.name as singer_name,songs_cats.name as cat_name  from songs_songs,songs_singers,songs_cats  where songs_singers.id=songs_songs.album and songs_cats.id = songs_singers.cat and songs_songs.id='$id'");   
  
   
        
open_table("$data[singer_name] - $data[name]");
 print "<center><a href='song_download_".$id."_".$cat."'><h3>تحميل الاغنية</h3></a></center>";          
close_table();


}