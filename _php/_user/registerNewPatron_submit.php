<?php

if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');
require_once(MAIN_DIR.'/../../_php/_config/constants.inc.php');
require_once(MAIN_DIR.'/../../_php/_includes/PHPMailer/PHPMailerAutoload.php');

confirm_logged_in();

//--------------------------------------------------------------------------------------------------
//CREATING A RANDOM TEMP PASSWORD
//--------------------------------------------------------------------------------------------------

$alpha = "abcdefghijklmnopqrstuvwxyz";
$alpha_upper = strtoupper($alpha);
$numeric = "0123456789";
$special = ".-+=_,!@$#*%<>[]{}";
$chars = "";
 
if (isset($_POST['length'])){
    // if you want a form like above
    if (isset($_POST['alpha']) && $_POST['alpha'] == 'on')
        $chars .= $alpha;
     
    if (isset($_POST['alpha_upper']) && $_POST['alpha_upper'] == 'on')
        $chars .= $alpha_upper;
     
    if (isset($_POST['numeric']) && $_POST['numeric'] == 'on')
        $chars .= $numeric;
     
    if (isset($_POST['special']) && $_POST['special'] == 'on')
        $chars .= $special;
     
    $length = $_POST['length'];
}else{
    // default [a-zA-Z0-9]{9}
    $chars = $alpha . $alpha_upper . $numeric;
    $length = 9;
}
 
$len = strlen($chars);
$pw = '';
 
for ($i=0;$i<$length;$i++)
        $pw .= substr($chars, rand(0, $len-1), 1);
 
// the finished password
$pw = str_shuffle($pw);

//END CREATING A RANDOM TEMP PASSWORD

//--------------------------------------------------------------------------------------------------
//GETTING POST DATA... from registerNewPatron_load.php, sanitizing, and insterting into the database
//--------------------------------------------------------------------------------------------------
$first_name = trim($mysqli->real_escape_string($_POST['jsonData']['first_name']));
$last_name = trim($mysqli->real_escape_string($_POST['jsonData']['last_name']));
$email = trim($mysqli->real_escape_string($_POST['jsonData']['email']));
$department = trim($mysqli->real_escape_string($_POST['jsonData']['department']));
//$user_type = trim($mysqli->real_escape_string($_POST['jsonData']['user_type']));
$username = trim($mysqli->real_escape_string($_POST['jsonData']['username']));
$display_name = $first_name." ".$last_name;
$created = date('Y-m-d H:i:s');

$sql = "INSERT INTO $DB_NAME.user
			SET username = '{$username}',
				first_name = '{$first_name}',
				last_name = '{$last_name}',
				email = '{$email}',
				department = '{$department}',
				display_name = '{$display_name}',
				date_created = '{$created}' ";

$result = db_query($mysqli, $sql);

//END GETTING POST DATA...


if ($result) {

//--------------------------------------------------------------------------------------------------
//MAILING INSTRUCTIONS TO PATRON
//--------------------------------------------------------------------------------------------------

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->IsHTML(true);
$mail->Username = 'VanderbiltVRC@gmail.com';
$mail->Password = 'Poussin12';
$mail->SetFrom('VanderbiltVRC@gmail.com');
$mail->Subject = 'Hello from dimli!';
$mail->Body = 'This is the first mail sent from dimli';
$mail->AddAddress($email);

if(!$mail->Send()) {
	echo 'Mail Error:' . $mail->ErrorInfo;
} else {
	echo 'Message has been sent';
}

//END MAILING INSTRUCTIONS TO PATRON


//--------------------------------------------------------------------------------------------------
//RETURNING NEW PATRON VALUES...to load_form.php
//--------------------------------------------------------------------------------------------------

	?>

	<script>
		var patron = <?php echo json_encode($display_name) ?>;
		var dept = <?php echo json_encode($department) ?>;
		var mail = <?php echo json_encode($email) ?>;
		var pw = <?php echo json_encode($pw) ?>;
		
		alert(mail);

		

	</script>

<?php

} ?>


