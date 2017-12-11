<?php
$mailTo = 'phpuceu@googlegroups.com';
$mailFrom = '"WEucEU Service" <donotreply@weuceu.org>';
$mailSubject    = 'WEucEU Feedback';
$mailText = "";

$error = false;

if(isset($_POST)) {
	foreach($_POST as $name => $value) {

		if(empty($value)){
			$error = true;
		}
		// (z.B. <select multiple>)
		if(is_array($value)) {
			// "Feldname:" und Zeilenumbruch dem Mailtext hinzufügen
			$mailText .= $name . ":\n";
			foreach($value as $entry) {
				$mailText .= "   " . $entry . "\n";
			}
		}
		// Wenn der Feldwert ein einzelner Feldwert ist:
		else {
			$mailText .= $name . ": " . $value . "\n";
		}
	}
} // if


// Wenn PHP "Magic Quotes" vor Apostrophzeichen einfügt:
if(get_magic_quotes_gpc()) {
	// eventuell eingefügte Backslashes entfernen
	$mailtext = stripslashes($mailText);
}

// ======= Mailversand

// Mail versenden und Versanderfolg merken
$mailSent = @mail($mailTo, $mailSubject, $mailText, "From: ".$mailFrom);

// ======= Return-Seite an den Browser senden
if ($error) {
	?>
	<div class="mlayer__lead">Validation failed</div>
	<p class="">Please check all required fields.<br> It's all or nothing, pal.</p>
	<?php
}
// Wenn der Mailversand erfolgreich war:
else if($mailSent == TRUE) {
?>
<div class="mlayer__lead">Request sent</div>
<p class="">Thank you. Your request has been sent.<br>We will get in touch with you soon.</p>
<p class="">In the meantime, here is a cute unicorn for you:</p>
<div class="text-center">
	<img src="img/unicorn.png" width="200" alt="Unicorn">
</div>

<?php
}
// Wenn die Mail nicht versendet werden konnte:
else {
?>
	<div class="mlayer__lead">Error occured</div>
	<p class="">Sorry. Something went wrong. Please drop us an email at <a href="mailto:phpuceu@googlegroups.com">phpuceu@googlegroups.com</a></p>
<?php
}
?>

