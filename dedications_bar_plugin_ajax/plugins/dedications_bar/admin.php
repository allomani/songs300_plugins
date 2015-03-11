<?
if(!check_admin_login()){die("<center> $phrases[access_denied] </center>");} 

//-------------- main ---------------
if(!$action){
if($dedications_admin_review){
$count = db_qr_fetch("select count(*) as count from songs_dedications where active=0");
      print "<br>";
print_admin_table("<b>اهدائات تنتظر الموافقة : </b> <a href='index.php?action=dedications'>".intval($count['count'])." </a>");    
   
}
}

//-------------------------- Dedications ---------------------
if($action=="dedications" || $action=="dedications_del" || $action=="dedications_edit_ok" || $action=="dedications_enable" || $action=="dedications_disable"){
if_admin("dedications");


print "<p align=center class=title>  الإهدائات </p>" ;

//-------------- del --------------------
if($action=="dedications_del"){
    if(!is_array($d_id)){$d_id=array($id);}

    foreach($d_id as $del_id){
        db_query("delete from songs_dedications where id='$del_id'");
        }
        }

//---------- edit -------------------
 if($action=="dedications_edit_ok"){
 db_query("update songs_dedications set user='$user',msg='".db_escape($msg)."' where id='$id'");
         }
         
 //----------- enable --------------
 if($action=="dedications_enable"){
     db_query("update songs_dedications set active=1 where id='$id'");
 }
 
 //----------- disable --------------
 if($action=="dedications_disable"){
     db_query("update songs_dedications set active=0 where id='$id'");
 }
 

$qr = db_query("select * from songs_dedications order by active asc , id desc limit 100");
if(db_num($qr)){
print "<center><table width=80% class=grid>
<form action=index.php method=post  name=submit_form>
<input type=hidden name=action value='dedications_del'>";
while($data = db_fetch($qr)){


  print "<tr>


  <td><input type=checkbox name=d_id[] value='$data[id]'></td><td>$data[user]</td><td>$data[msg]</td><td>$data[date]</td><td align=left>
  ".iif($data['active'],"<a href='index.php?action=dedications_disable&id=$data[id]'>تعطيل</a>","<a href='index.php?action=dedications_enable&id=$data[id]'>تفعيل</a>")." - 
  <a href='index.php?action=dedications_edit&id=$data[id]'>تعديل</a> -
  <a href='index.php?action=dedications_del&id=$data[id]'>حذف</a></td></tr>";
        }
        print "<tr><td width=2><img src='images/arrow_rtl.gif'></td>
          <td width=100% colspan=5>
          <table><tr><td>

          <a href='#' onclick=\"CheckAll(); return false;\"> تحديد الكل </a> -
          <a href='#' onclick=\"UncheckAll(); return false;\">الغاء التحديد </a>
          &nbsp;&nbsp;
          </td><td>
          <input type=submit value=' حذف ' onClick=\"return confirm('Are You Sure ?');\">
          </td></tr></table></form> ";

        print "</table></center>";
       }else{
                print  "<br><center>  لا توجد اهدائات </center>";
                }
        }
//--------------------------
if($action=="dedications_edit"){
    if_admin("dedications"); 
$qr = db_query("select * from  songs_dedications where id='$id'");
if(db_num($qr)){
        $data = db_fetch($qr);
print "<form action='index.php' method=post>
<input type=hidden name=action value=dedications_edit_ok>
<input type=hidden name=id value=$data[id]>
<center>
<table width=60% class=grid><tr><td align=center>
<tr><td align=center><input type=text name=user value='$data[user]'></td></tr>
<tr><td align=center>
<textarea name=msg cols=40 rows=10>$data[msg]</textarea> <br>
<input type=submit value=' تعديل '></td></tr>

</table></form>";

        }else{
                print "<br><center> رابط خاطيء </center>";
                }
}


//-------------------------- emotions ---------------------
if($action=="emotions" || $action=="emotions_del" || $action=="emotions_edit_ok" || $action=="emotions_add_ok"){
if_admin("dedications"); 
   
print "<p align=center class=title>  الابتسامات </p>" ;

if($action=="emotions_del"){
        db_query("delete from songs_emotions where id='$id'");
        }
 if($action=="emotions_edit_ok"){
 db_query("update songs_emotions set img='".db_escape($img,false)."',value='".db_escape($value,false)."' where id='$id'");
         }

          if($action=="emotions_add_ok"){
 db_query("insert into songs_emotions (img,value) values('".db_escape($img.false)."','".db_escape($value,false)."')");
         }

 print "<center>
<form action='index.php' method=post name='sender'>
<input type=hidden name=action value=emotions_add_ok>
<center>
<table width=60% class=grid>
<tr><td>الرمز</td><td><input type=text name='value' dir=ltr ></td></tr>
   <tr> <td width=\"100\">
                <b>$phrases[the_image]</b></td>
                                <td>


                            <table><tr><td>
                                 <input type=\"text\" name=\"img\" size=\"50\" dir=ltr>   </td>

                                <td> <a href=\"javascript:uploader('emoticons','img');\"><img src='images/file_up.gif' border=0 title='$phrases[upload_file]'></a>
                                 </td></tr></table>

                                 </td></tr>
<tr><td align=center colspan=2><input type=submit value=' إضافة '></td></tr>

</table></form><br>";


$qr = db_query("select * from songs_emotions  order by id");
if(db_num($qr)){
print  "
<table width=80% class=grid>";
while($data = db_fetch($qr)){

  print "<tr><td>$data[value]</td><td><img src=\"$scripturl/$data[img]\"></td><td align=left>
  <a href='index.php?action=emotions_edit&id=$data[id]'>تعديل</a> -
  <a href='index.php?action=emotions_del&id=$data[id]' onclick=\"return confirm('are you sure?');\">حذف</a></td></tr>";
        }
        print "</table></center>";
       }else{
                print  "<br><center>  لا توجد ابتسامات </center>";
                }
        }
if($action=="emotions_edit"){
    if_admin("dedications"); 
$qr = db_query("select * from  songs_emotions where id='$id'");
if(db_num($qr)){
        $data = db_fetch($qr);
print "<form action='index.php' method=post>
<input type=hidden name=action value=emotions_edit_ok>
<input type=hidden name=id value=$data[id]>
<center>
<table width=60% class=grid>
<tr><td>الرمز</td><td><input type=text name='value' dir=ltr value='$data[value]'></td></tr>
<tr><td>الصورة</td><td><input type=text name='img' dir=ltr value='$data[img]'></td></tr>
<tr><td align=center colspan=2><input type=submit value=' تعديل '></td></tr>

</table></form>";

        }else{
                print "<br><center> رابط خاطيء </center>";
                }
}        
?>