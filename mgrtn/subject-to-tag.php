<?php
// ** MySQL settings - You can get this info from your web host ** //

	/** MySQL hostname */
$server = 'localhost';
	/** MySQL database username */
$user = 'u311510689_cerkv';
	/** MySQL database password */
$password = 'cerkva2014';
	/** The name of the database for WordPress */
$database = 'molfar_cerkva';


$dbdriver = 'mysql';

require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
include("../wp-admin/includes/taxonomy.php");

include("adodb5/adodb.inc.php");
include("adodb5/adodb-exceptions.inc.php");

$DB = ADONewConnection($dbdriver); # eg 'mysql' or 'postgres'
$DB->debug = false;
$DB->SetCharSet('utf8'); // for mysql
$DB->SetFetchMode(2); // for mysql

$DB->Connect($server, $user, $password, $database);

$subjects = $DB->GetAll("SELECT * FROM `subject`");

global $wpdb;
foreach ($subjects as $subject) {
	$tag_id = $wpdb->get_var("SELECT MAX(`term_id`) FROM `wp_terms`");
	$tag = wp_create_term ( $subject['name'] );
	echo  $tag_id;
//	$DB->query("INSERT INTO `subject_to_tag` (`subject_id`, `tag_id`) VALUES (".$subject['id'].", ".$tag_id.")");	
}



$count = $DB->GetOne("SELECT COUNT(*) FROM `subject_to_tag`");





?>


<html>
<head>
<meta charset='UTF-8' />
</head>
<body>
<?php	
echo $count;
?>	
</body>
</html>
