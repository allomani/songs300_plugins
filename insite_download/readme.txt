Audio & Video  v3.0

In Site Download Page
--------------------------------------------

1. upload plugins folder

2. add the following lines to .htaccess file

RewriteRule ^song_download_([0-9]+)_([0-9]+).html index.php?action=download&id=$1&cat=$2
RewriteRule ^song_download_([0-9]+).html index.php?action=download&id=$1&cat=1


3. from script's control panel , go to SEO settings -> links , then change "song_download" value ,

from : song_download_{id}_{cat}
to : song_download_{id}_{cat}.html

4. from script's control panel , go to Blocks , then click edit on menus that you want to appear in download page and select "download song" in appearance pages and click on edit button

-------------------------------------------
Allomani
www.allomani.com