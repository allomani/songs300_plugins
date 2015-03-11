Dedications Bar. Ajax.
Songs v3.0
--------------------

1. upload files to script's folder
2. import sql.sql file into database

3. add
$dedications_admin_review=1;
to config.php file if you want to review and accept new dedications.

4. add dedications bar to templates -> header by adding this line at end

<br>
<script type="text/javascript" src="dedications.js"></script>
<div id='dedications_bar_div' width=100% style="border: 1px dashed #0099CC;"></div>
<script>get_dedications();</script>
<br>

----------------------

Allomani.com
