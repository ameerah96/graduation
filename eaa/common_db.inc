<?php
$dbhost = 'localhost';
$dbusername = 'root';
$dbuserpassword = '';
$default_dbname = 'eaa_new_db';

$default_sort_order = 'ASC';
 // $default_order_by = 'usernumber';
$records_per_page = 5;


//  $user_tablename = 'user';
//  $access_log_tablename = 'access_log';


$MYSQL_ERRNO = '';
$MYSQL_ERROR = '';

$new_win_width = 600;
$new_win_height = 400;

//     ======= html_header() =====
function html_header() {
global $new_win_width, $new_win_height;
?>
<HTML>
<HEAD>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
<!--
function open_window(url) {
var NEW_WIN = null;
NEW_WIN = window.open ("", "RecordViewer",
"toolbar=no,width="+
<?php echo $new_win_width ?>+
",height="+<?php echo $new_win_height?>+
",directories=no,status=no,
scrollbars=yes,resize=no,menubar=no");
NEW_WIN.location.href = url;
}
//-->
</SCRIPT>
<TITLE>User Record Viewer</TITLE>
</HEAD>
<body  DIR = "RTL" >
<?php
}

//   ========  html_footer()  ======


function html_footer() {
    ?>
</BODY>
</HTML>
<?php
}


//  =========   function db_connect() ========


function db_connect() {
global $dbhost, $dbusername, $dbuserpassword, $default_dbname;
global $MYSQL_ERRNO, $MYSQL_ERROR;
$link_id = mysql_connect($dbhost, $dbusername, $dbuserpassword);
if(!$link_id) {
$MYSQL_ERRNO = 0;
$MYSQL_ERROR = "Connection failed to the host $dbhost.";
return 0;
}
else if(empty($dbname) && !mysql_select_db($default_dbname)) {
$MYSQL_ERRNO = mysql_errno();
$MYSQL_ERROR = mysql_error();
return 0;
}
else return $link_id;
}

// ========= function sql_error()   =========

function sql_error() {
global $MYSQL_ERRNO, $MYSQL_ERROR;
if(empty($MYSQL_ERROR)) {
$MYSQL_ERRNO = mysql_errno();
$MYSQL_ERROR = mysql_error();
}
return "$MYSQL_ERRNO: $MYSQL_ERROR";
}

//  =====    error_message()   =======

function error_message($msg) {
html_header();
echo "<SCRIPT>alert(\"Error: $msg\");history.go(-1)</SCRIPT>";
html_footer();
exit;
}
?>


