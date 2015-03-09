<?php
echo "<p></p>";
$connect = mysql_connect("localhost","root","root");

if (!$connect) {
	die(mysql_error());
}

$counter = 0;
mysql_select_db("cyberou");
$results = mysql_query("SELECT * FROM summit2015test");
while($row = mysql_fetch_array($results)) {
	
	
//	if ($row['mailed']==0) {
		$userid = $row['id'];
		$title = $row['title'];
		$first = $row['first'];
		$last = $row['last'];
		$receiver = $row['email'];
		$org = $row['organization'];
		echo "log: sending mail to $receiver, id: $userid<br>";

		$to      = $receiver;
		$subject = 'Oakland University Cyber Summit Registration';
		$message = '
			<html>
				<head>
				</head>
				<body>
					<h2>Cyber Summit Registration</h2>
					<hr>
					<p>
						Thank you for Registering for the the 2nd Annual Cyber Summit presented by Oakland University’s Cyber Security Club and the School of Engineering and Computer Science (SECS).
					</p>
					<p>
						Here is the information we received from you<br>
						Title: '.$title.'<br>
						First name: '.$first.'<br>
						Last name: '.$last.'<br>
						Email: '.$receiver.'<br>
						Organization: '.$org.'<br>
					</p>
					<p>
						If you wish to change your registration status please contact CyberOU at: <a href="mailto:cyberou@gmail.com">cyberou@gmail.com</a>
					</p>
					<p>
						A subsequent reminder email will be sent out with a campus map and program.<br>
						We look forward to having you attend this great event! 
					</p>
					<p>
						Thank you,<br>CyberOU
					</p>
				</body>
			</html>';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//		$headers .= "To: $to" . "\r\n";
		$headers .= 'From: CyberOU <cyberou@gmail.com>' . "\r\n";
		mail($to, $subject, $message, $headers);
		
		$sql="UPDATE summit2015test SET mailed = '1' WHERE id = $userid";

		if (!mysql_query($sql, $connect)) {
			die('Error: ' . mysql_error());
		}
		
		$counter = $counter+1;
		echo "log: email succesfully sent, and 'mailed' value updated<br><br>";
		
//	}

}
echo "<p>log: $counter mail sent</p>";