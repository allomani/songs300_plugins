<?
if(!check_admin_login()){die("<center> $phrases[access_denied] </center>");} 


if(!$action){
    $members_files = db_qr_fetch("select count(id) as count from members_files");
    print "<br>";
    print_admin_table("<center><b> ملفات تنتظر الموافقة : <b> <a href='index.php?action=members_files'>$members_files[count]</a></center>");
}

//----------------------------

if($action=="members_files" || $action=="members_files_del" || $action=="members_files_accept"){
   
   //--------- accpt -------------- 
    if($action=="members_files_accept"){
  
        if($type=="audio"){
         
        db_query("insert into songs_songs (name,date,album,userid,url_{$settings['default_url_id']}) values('".db_escape($name)."','".time()."','$singer','$userid','".db_escape($url)."')");
        update_singer_counters($singer,'songs'); 
        
        }else{
              db_query("insert into songs_videos_data (name,url,img,date,cat,userid) values('".db_escape($name)."','".db_escape($url)."','".db_escape($img)."','".time()."','$cat','$userid')");
       
        }
        
        db_query("delete from members_files where id='$id'");
    }
    //---- del ----
    if($action=="members_files_del"){
        $data = db_qr_fetch("select url,img from members_files where id='$id'");
        @unlink(CWD . "/" .$data['url']);
        @unlink(CWD . "/" .$data['img']);
        db_query("delete from members_files where id='$id'");
    }
    
print "<p align=center class=title> ملفات تنتظر الموافقة </p>";
$qr=db_query("select * from members_files order by filetype,id desc");
if(db_num($qr)){
    
    ?>
    <script>
    function file_listen(id){
window.open("<?=$scripturl?>/listen_members_files.php?id="+id,"displaywindow","toolbar=no,scrollbars=yes,width=600,height=400,top=200,left=200");
return false;
}
</script>
    <?
    print "<center><table width=99% class=grid>";
    while($data=db_fetch($qr)){
        
        $data_user = db_qr_fetch("select id,username from songs_members where id='$data[userid]'");
      
       
        
          
        print "<tr>
        <td><a href='index.php?action=member_edit&id=$data_user[id]'>$data_user[username]</a></td>
        <td>$data[name]</td>
        <td><b>".iif($data['filetype']=="audio","<font color='#0080C0'>صوت</font>","فيديو")."</b></td>
         <td>";
         if($data['filetype']=="audio"){
             $data_cat = db_qr_fetch("select id,name from songs_cats where id='$data[cat]'");          
         print "<a href='$scripturl/cat-".$data_cat['id'].".html' target=_blank>".$data_cat['name']."</a>";
         }else{
         $data_cat = db_qr_fetch("select id,name from songs_videos_cats where id='$data[cat]'"); 
           print "<a href='$scripturl/videos-".$data_cat['id'].".html' target=_blank>".$data_cat['name']."</a>";          
         }
         
         print "</td><td>";
         if($data['singer']){
         $data_singer = db_qr_fetch("select name,id from songs_singers where id='$data[singer]'");
         print "<a href='$scripturl/singer-".$data_singer['id'].".html' target=_blank>".$data_singer['name']."</a>";
         }  
        print "</td><td>$data[date]</td>
        <td><a href=\"javascript:file_listen($data[id]);\">استماع</a></td>
        <td><a href='index.php?action=members_files_details&id=$data[id]'> تفاصيل \ موافقة</a></td>
        <td><a href='index.php?action=members_files_del&id=$data[id]' onClick=\"return confirm('are you sure ?');\">حذف</td></tr>";
    }
    print "</table></center>";
}else{
print_admin_table("<center> لا توجد ملفات </center>");
}    
}

//-------------------------------
if($action=="members_files_details"){
    $qr=db_query("select * from members_files where id='$id'");
    if(db_num($qr)){
        $data=db_fetch($qr);
        print "
        <form action=index.php method=post>
        <input type=hidden name=id value='$id'> 
        <input type=hidden name=type value='$data[filetype]'>  
        <input type=hidden name=action value='members_files_accept'>
        <input type=hidden name=userid value='$userid'>
        <table width=100% class=grid>";
        
        if($data['filetype']=="video"){
        print "<tr><td colspan=2 align=center><img src=\"$scripturl/".get_image($data['img'])."\"></td></tr>";
        }
        
        print "<tr>
    <td><b> اسم الملف  : </b> </td><td><input type=text name='name' value=\"$data[name]\" size=30></td></tr>   
    
    <td><b> رابط الملف : </b> </td><td><input type=text name=url value=\"$data[url]\" size=40 dir=ltr></td></tr>";
    
    
      if($data['filetype']=="video"){    
    print " <tr><td><b> صورة الملف : </b> </td><td><input type=text name=img value=\"$data[img]\" size=40 dir=ltr></td></tr>";
     
     /* 
      <td><b> وصف الملف : </b> </td><td><textarea cols=40 rows=5 name=details>$data[details]</textarea></td></tr>*/   

       print "<tr><td><b> القسم : </b> </td><td><select name=cat>";
    
    $qr=db_query("select * from songs_videos_cats order by cat,ord asc");   

        
    while($datac = db_fetch($qr)){
        
        
        if($datac['cat']){
        $data_cat = db_qr_fetch("select name from songs_videos_cats where id='$datac[cat]'");
        }
        
    print "<option value='$datac[id]'".iif($datac['id']==$data['cat']," selected").">".iif($data_cat['name'],"$data_cat[name] -> ")."$datac[name]</option>";
    }
    print "</select></td></tr>";
      }
   
      if($data['filetype']=="audio"){     
    $qr=db_query("select * from songs_singers order by cat asc,binary name asc");
    print "<tr><td><b> $phrases[singer] : </b> </td><td><select name=singer>";
    while($datas = db_fetch($qr)){
        
         if($datas['cat']){
        $data_cat = db_qr_fetch("select name from songs_cats where id='$datas[cat]'");
        }
        
       print "<option value='$datas[id]'".iif($datas['id']==$data['singer']," selected").">".iif($data_cat['name'],"$data_cat[name] -> ")."$datas[name]</option>";
      
    }
    print "</select></td></tr>";      
      }
     
     print "<tr><td colspan=2 align=center><input type=submit value=' قبول الملف '></td></tr>
        <tr><td colspan=2 align=left><a href='index.php?action=members_files_del&id=$data[id]' onClick=\"return confirm('are you sure ?');\">حذف الملف</a></td></tr>  
        </table>
        </form>";
    }else{
        print_admin_table("<center>wrong url</center>");
    }
}