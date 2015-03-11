<?
include_once("global.php") ;
header("Content-Type: text/html;charset=$settings[site_pages_encoding]");


    
    $type=htmlspecialchars($type) ;
    $cat=intval($cat);
    $singer=intval($singer);
   
    
    if(check_member_login()){
    print "
    <form action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\" name=send_file_form onsubmit=\"return send_file_confirm_fields();\">
    <input name=action value='send_file_ok' type=hidden>
    <table width=100%>
    <tr>
     <td><b> نوع الملف  : </b> </td><td>
     <select name='type' id='type' onChange=\"get_send_file_form(this.value,0);\">
     <option value='audio'".iif($type=="audio"," selected").">اغنية</option>
     <option value='video'".iif($type=="video"," selected").">كليب</option>
     </select>
     </td></tr>  
     ";
  
     print "<td><b> $phrases[the_cat] : </b> </td><td><select id=cat name=cat ".iif($type=="audio","onChange=\"get_send_file_form(\$('type').value,\$('cat').value,0);\"").">
     <option value=''> -- اختر القسم --</option>";
        if($type=="" || $type=="audio"){   
    $qr=db_query("select * from songs_cats where active=1 order by id asc");
   
    while($data = db_fetch($qr)){
 
    print "<option value='$data[id]'".iif($data['id']==$cat," selected").">".iif($data_cat['name'],"$data_cat[name] -> ")."$data[name]</option>";
    }
      }else{
      $qr=db_query("select * from songs_videos_cats where active=1  order by cat asc");   
        while($data = db_fetch($qr)){
    $data_cat = db_qr_fetch("select name from songs_videos_cats where id='$data[cat]'");
    
    print "<option value='$data[id]'".iif($data['id']==$cat," selected").">".iif($data_cat['name'],"$data_cat[name] -> ")."$data[name]</option>";
    }     
     }
    print "</select></td></tr>";
    
    if($type=="audio" && $cat){
    print "<tr><td><b> $phrases[singer] : </b> </td><td><select id='singer' name=singer ".iif($type=="audio","onChange=\"get_send_file_form(\$('type').value,\$('cat').value,this.value);\"").">";    
        
     $qr=db_query("select * from songs_singers where active=1 and cat='$cat' order by id asc"); 
     while($data = db_fetch($qr)){
         if(!$singer){$singer=$data['id'];} 
     
    print "<option value='$data[id]'".iif($data['id']==$singer," selected").">$data[name]</option>";
    }  
    print "</select></td></tr>";  
    }else{
    print "<input type=hidden name=singer value=''>";
    }
    
       
   
       if($type=="audio" && $cat){
    print "<tr><td><b> $phrases[album] : </b> </td><td><select name=album id='album'>";          
     $qr=db_query("select * from songs_albums where  cat='$singer' order by id asc"); 
     print "<option value=0>بدون البوم</option>";
     
     while($data = db_fetch($qr)){
 
    print "<option value='$data[id]'".iif($data['id']==$singer," selected").">$data[name]</option>";
    }  
    print "</select></td></tr>";  
    }else{
    print "<input type=hidden name=album value='0'>";
    }
    
    
     print "</tr>
     <tr>
    <td><b> اسم الملف  : </b> </td><td><input type=text name='name' size=30 id='name'></td></tr>   
    <tr>   <td><b> الملف : </b> </td><td><input type=file name=datafile id='datafile'></td></tr>";
    
    if($type=="video"){
    print "<tr>    <td><b> صورة الملف : </b> </td><td><input type=file name=img_datafile></td></tr>"; 
    }
     
         
    print "<tr><td><b>اقصى حجم للرفع :</b> </td><td>";
    $upload_max = convert_number_format(ini_get('upload_max_filesize'));
$post_max = (convert_number_format(ini_get('post_max_size'))/2) ;


if($upload_max || $post_max){
print iif($upload_max < $post_max,convert_number_format($upload_max,2,true),convert_number_format($post_max,2,ture))." ";
}else{
    print "Invalid";
}

print "</td></tr>
<tr><td><b> الانواع المسموح رفعها </b></td><td>".strtoupper(implode("  ",$upload_types))."</td></tr>";
/*
   <td><b> وصف الملف : </b> </td><td><textarea cols=40 rows=5 name=details></textarea></td></tr>  */ 
   
    print "<tr><td colspan=2 align=center><input name='send_file_submit' type=submit value=' اضافة '></td></tr>
    </form>
    </table>";
    }else{
        print "<center> يرجى تسجيل الدخول  </center>";
    }
 