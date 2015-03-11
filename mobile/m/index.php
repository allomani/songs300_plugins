<?php


chdir('./..');
define('CWD', (($getcwd = getcwd()) ? $getcwd : '.'));
$folder_name = "m";

require_once(CWD . '/global.php');


$script_url = "http://" . $_SERVER['HTTP_HOST'] . ($script_path ? "/$script_path" : "") ;






function print_header($title){
global $script_url,$folder_name ;
print  "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html dir=\"rtl\" lang=\"ar-sa\">
<head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        <title>$title</title>
        <link rel=\"stylesheet\" href=\"".$script_url."/".$folder_name."/style.css\" />
</head>
<body>
<div class=\"pagebody\">
";
}

// ********************************************************************************************
// display board

if ($action == 'index' || !$action)
{
      print_header("$sitename - Mobile");


        print "<p class=\"largefont\">عرض النسخة الكاملة : <a href='$script_url/index.php'> الصفحة الرئيسية </a></p>\n";

       print "<div id=\"content\">
	   <ul>";
     print "<li><a href='browse-0.html'>الاغاني</a></li>
            <li><a href='news-0.html'>الأخبار</a></li>
			</ul>
           ";

       print  "</div>\n";

}


// ********************************************************************************************
// display forum

if ($action == 'browse')
{
        $id = intval($id);

 if($id > 0){

$qr = db_query("select name from songs_cats where id='$id'");
if(db_num($qr)){
$data = db_fetch($qr) ;
$title_sub = "$data[name]" ;
        }else{
 $title_sub = "" ;
 }


     print_header("$sitename - $title_sub");

     print "<div id='navbar'> <a href='index.php'> الرئيسية </a>  > <a href='browse-0.html'> الأغاني </a>";
  print "</div>";

  print "<p class=\"largefont\">عرض النسخة الكاملة : <a href='$script_url/browse.php?op=cat&id=$id'> $title_sub </a></p>\n";

     print "<div id=\"content\">\n";
  $qr = db_query("select * from songs_singers where cat='$id' order by binary name asc");
  if(db_num($qr)){
          while($data = db_fetch($qr)){
                  print "<li> <a href='songs-$data[id].html'>$data[name]</a></li>";
                  }
                  }else{
                          print "<center>  لا يوجد محتوى  </center>";
                          }
print  "</div>\n";
}else{
      print_header("$sitename - الأغاني");

     print "<div id='navbar'> <a href='index.php'> الرئيسية </a>   ";
  print "</div>";

 // print "<p class=\"largefont\">عرض النسخة الكاملة : <a href='$script_url/index.php?action=browse&op=cat&id=$id'> $title_sub </a></p>\n";
     print "<br>" ;

     print "<div id=\"content\">\n";
  $qr = db_query("select * from songs_cats order by binary name asc");
  if(db_num($qr)){
          while($data = db_fetch($qr)){
                  print "<li> <a href='browse-$data[id].html'>$data[name]</a></li>";
                  }
                  }else{
                          print "<center>  لا يوجد محتوى  </center>";
                          }
print  "</div>\n";

        }

}

// ********************************************************************************************
// display thread

if ($action == 'songs')
{
        $id = intval($id);



$qr = db_query("select name from songs_singers where id='$id'");
if(db_num($qr)){
$data = db_fetch($qr) ;
$title_sub = "$data[name]" ;
        }else{
 $title_sub = "" ;
 }


  print_header("$sitename - $title_sub");

   if(db_qr_num("select * from songs_singers where id='$id'")){

        $datasngr = db_qr_fetch("select name,id,cat from songs_singers where id='$id'");
         $hdr = db_qr_fetch("select * from songs_cats where id='$datasngr[cat]'");

   print "<div id='navbar'> <a href='index.php'> الرئيسية </a>  > <a href='browse-$hdr[id].html'>$hdr[name]</a> ";
  print "</div>";

  print "<p class=\"largefont\">عرض النسخة الكاملة : <a href='$script_url/songs.php?id=$id'> $title_sub </a></p>\n";
  }

  $qr = db_query("select * from songs_songs where album='$id'");
  if(db_num($qr)){
          while($data = db_fetch($qr)){
                  print "<li> <a href='$script_url/download.php?id=$data[id]'>$data[name]</a></li>";
                  }
                  }else{
                          print "<center>  لا يوجد محتوى  </center>";
                          }
}

//*****************************  news **********************************

if($action=="news"){

   $id = intval($id);

   if($id <= 0){




  print_header("$sitename - الأخبار");

   print "<div id='navbar'> <a href='index.php'> الرئيسية </a>  ";
  print "</div>";

  print "<p class=\"largefont\">عرض النسخة الكاملة : <a href='$script_url/news.php'> الأخبار </a></p>\n";


  $qr = db_query("select * from songs_news order by id desc");
  if(db_num($qr)){
          while($data = db_fetch($qr)){
                  print "<li> <a href='news-$data[id].html'>$data[title]</a></li>";
                  }
                  }else{
                          print "<center>  لا يوجد محتوى  </center>";
                          }
 }else{

   $qr = db_query("select title,content,date,id,details from songs_news where id='$id'");
if(db_num($qr)){
$data = db_fetch($qr) ;
$title_sub = "$data[title]" ;


   print_header("$sitename - $title_sub");

   print "<div id='navbar'> <a href='index.php'> الرئيسية </a> > <a href='news-0.html'> الأخبار </a>";
  print "</div>";
  print "<p class=\"largefont\">عرض النسخة الكاملة : <a href='$script_url/news.php?id=$id'> $title_sub </a></p>\n";

  $news_date = date("d-m-Y",strtotime($data['date']));

  print   "$news_date : $data[content] <br> $data[details]" ;

         }else{
                 print "<center>  لا يوجد محتوى </center>";
                 }
         }
}




print "<div id=\"copyright\">";
print_copyrights();
print "</div>
</div>
</body>
</html>";




?>