<?
 if($action=="download" && $id){ 
       $id = (int) $id;


  $data = db_qr_fetch("select songs_songs.name,songs_songs.album_id, songs_singers.name as singer_name,songs_cats.name as cat_name  from songs_songs,songs_singers,songs_cats  where songs_singers.id=songs_songs.album and songs_cats.id = songs_singers.cat and songs_songs.id='$id'");   
   
   $title_sub = $data['cat_name'] ." - ".$data['singer_name'] ." - ".$data['name']." تحميل";
   $meta_description = $title_sub;
 
 }
 
 
$actions_checks["تحميل الاغنية"] = 'download' ;
?>