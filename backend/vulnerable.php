<?
// If you are not familiar with PHP:
//	resources (eg DB connection) will be correctly garbage collected
//  $$x will resolve to the value of the variable stored in $x

// We deliberately suppress error messages; you may assume this is ok
error_reporting(0);
ini_set('error_reporting', 0);
ini_set('display_errors', 0);

$ini = parse_ini_file('../.my.cnf', true);
define('DB_HOST', $ini['client']['host']);
define('DB_USER', $ini['client']['user']);
define('DB_PASS', $ini['client']['password']);
define('DB_NAME', $ini['mysql']['database']);
define('ADMIN_EMAIL', 'test@example.com');

function isAdmin() {
	// admin is logged in elsewhere in the system
	return (bool)$_SESSION['isAdmin'];
}

function getDbConnection() {
	// you can assume this always works
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	return $conn;
}

$email = $_REQUEST['email'];
$enquiry = $_REQUEST['enquiry'];
$id  = $_REQUEST['id'];
$token  = $_REQUEST['token'];

$fields = [
	'id',
	'token',
	'email',
	'enquiry',
];

// ---------------------------------------------------------------
// Display an enquiry
// ---------------------------------------------------------------
if ($id) {
	$conn = getDbConnection();
	$sql = "SELECT * FROM enquiry WHERE id=$id";
	$result = $conn->query($sql);

	if ($row = $result->fetch_assoc()) {
		if (!isAdmin() && $row['token'] != $token) {
			header("HTTP/1.0 403 Forbidden");
			echo "Permission denied";
			exit();
		}

		?><html>
			<body>
				<h1>Customer Enquiry #<?=$row['id']?></h1>
				<p><b>Email:</b> <?=$row['email']?></p>
				<p><b>Message:</b> <?=$row['enquiry']?></p>
			</body>
		</html><?
		exit();
	}
}

// ---------------------------------------------------------------
// Submission of an enquiry (processing & response)
// ---------------------------------------------------------------
if (isset($_REQUEST['email']) && isset($_REQUEST['enquiry'])) {
	
	$conn = getDbConnection();

	$token = $_REQUEST['token'] = rand(0, 10000);
	$sql = "INSERT INTO enquiry SET "
		. implode(', ', array_map(function($field) {
			return sprintf("%s='%s'", $field, $_REQUEST[$field]);
		}, $fields))
		. ';';
	$result = $conn->query($sql);
	$id = $conn->insert_id;

	$subject = "New enquiry from $email";
	$message = "<a href='mailto:$email'>$email</a> has submitted a new enquiry:\n"
		. "$enquiry\n"
		. "<a href='http://www.mysite.com/enquiry.php?id=$id&token=$token'>It can be viewed here</a>\n";
	mail(ADMIN_EMAIL, $subject, $message);	// return status code deliberately ignored

	?><html>
		<body>
			<p>Thank you for your enquiry. We will be in contact soon.</p>
		</body>
	</html><?

	exit();
}


// ---------------------------------------------------------------
// Submission of an enquiry (form)
// ---------------------------------------------------------------
?><html>
	<body>
		<h1>Customer Enquiry</h1>
		<p>Please enter details of your enquiry below and we will contact you as soon as possible</p>
		<form method="POST" action="">
			<div><label>Email: <input type="text" name="email" /></label></div>
			<div><label>Enquiry: <input type="text" name="enquiry" /></label></div>
			<div><input type="submit" value="Submit"/></div>
		</form>
	</body>
</html>
