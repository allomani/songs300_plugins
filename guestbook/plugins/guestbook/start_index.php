<?

if(!defined("CUR_FILENAME")){
        die("You can't access file directly ... ");
}

require(CWD . '/includes/class_security_img.php');
$sec_img = new sec_img_verification();

 //------------------ Guest Book --------------------------
 if($action=="guestbook"){
 print "<img src='images/arrw.gif'> <a href='index.php?action=guestbook_add'> اضافة الى السجل </a><br><br>";

$start = intval($start);
if(!$limit){$limit=30;}
$limit=intval($limit);


 $qr = db_query("select * from guestbook_data where active=1 order by id DESC limit $start,$limit");

 if(db_num($qr)){

 $page_result = db_qr_fetch("select count(*) as count from  guestbook_data where active=1");


$numrows=$page_result['count'];
$previous_page=$start - $m_perpage;
$next_page=$start + $m_perpage;
$m_perpage = $limit ;
$page_string = "index.php?action=guestbook";



  while($data = db_fetch($qr)){

  open_table();
  print "<table >
  <tr><td colspan=2>$data[date]</td></tr>
  <tr><td><b>الاسم:</b></td><td> $data[name]</td></tr>

  <tr><td><b>الرسالة :</b></td><td> $data[msg]</td>
  
  </tr>";
  check_admin_login();
  if(if_admin("guestbook",1)){
      print "<tr><td><a href='admin/index.php?action=guestbook_edit&id=$data[id]&redirect=1'> تعديل </a> -
       <a href='".iif($admin_dir,$admin_dir,"admin")."/index.php?action=guestbook_del&id=$data[id]&redirect=1'>حذف</a></td></tr>";
  }
  
  
  print "</table>";


  close_table();

          }

  //-------------------- pages system ------------------------
if ($numrows>$m_perpage){
echo "<p align=center>الصفحات : ";
//----------------------------
if($start >0)
{
$previouspage = $start - $m_perpage;
echo "<a href=$page_string&start=$previouspage><</a>\n";
}
//------------------------------------------
$pages=intval($numrows/$m_perpage);
//---------------------------------------
if ($numrows%$m_perpage)
{
$pages++;
}
//--------------------------------------
for ($i = 1; $i <= $pages; $i++) {

$nextpag = $m_perpage*($i-1);
//-----------------------------------------

if ($nextpag == $start)
{
echo "<font size=2 face=tahoma><b>$i</b></font>&nbsp;\n";
}
else
{
echo "<a href=$page_string&start=$nextpag>[$i]</a>&nbsp;\n";
}
}
//--------------------------------------------------

if (! ( ($start/$m_perpage) == ($pages - 1) ) && ($pages != 1) )
{
$nextpag = $start+$m_perpage;
echo "<a href=$page_string&start=$nextpag>></a>\n";
}
//--------------------------------------------------------------

echo "</p>";
}
//------------ end pages system -------------

          }else{
                  open_table();
                  print "<center> لا توجد سجلات </center>";
                  close_table();
                  }
         }

 //---------------- Guest Book Add -----------------------
 if($action=="guestbook_add"){
 open_table("اضافة الى السجل");
  print "<form action=index.php method=post>
  <input type=hidden name=action value='guestbook_addok'>
  <table width=100%>
  <tr><td colspan=2>$data[date]</td></tr>
  <tr><td width=20%><b>الاسم:</b></td><td> <input type=text name=name size=20></td></tr>
  <tr><td width=20%><b>البريد الالكتروني :</b></td><td><input type=text name=email size=20 dir=ltr> </td></tr>
  <tr><td width=20%><b>الرسالة :</b></td><td> <textarea cols=30 rows=5 name=msg></textarea></td></tr>

  <tr>

        <td><b> كود التحقق </b> :</td>
        <td>".$sec_img->output_input_box('sec_string','size=7')."</td>
           <td><img src=\"sec_image.php\" alt=\"Verification Image\" /></td>
           
        
      </tr>

  <tr><td colspan=2 align=center><input type=submit value=' اضافة '></td></tr>
  </table></form>";

 close_table();

         }
  //-------------------- Guest Book Add Ok ----------------------
  if($action=="guestbook_addok"){

  //  $sec_code = $HTTP_COOKIE_VARS['guestbook_sec_code'] ;


 //   $code = stripslashes($_REQUEST['SECURITY']);
//    $md5code = md5(strtoupper($code));

if($sec_img->verify_string($sec_string)){
    
    if($name && strchr($email,"@") && $msg){

    $name= htmlspecialchars($name);
     $email= htmlspecialchars($email);
      $msg= htmlspecialchars($msg);

    db_query("insert into guestbook_data(name,email,msg,date) values('".db_escape($name)."','".db_escape($email)."','".db_escape($msg)."',now())");



    // print "<script src='rst_cookie.php'></script>";

     open_table();
     print "<center> شكرا لك , لقد تمت الاضافة <br><br> <a href='index.php?action=guestbook'>الرجوع الى سجل الزوار</a> </center>";
     close_table();
     }else{
     open_table();
     print "<center> خطأ , يرجى اكمال جميع الحقول </center>";
     close_table();
             }
     }else{
      open_table();
      print "<center> خطأ , كود التحقق غير صحيح </center>";
      close_table();

        }
    }
  ?>