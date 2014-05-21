<?php
	
	$mailManager = new MailManager();
	$contentMail = $mailManager->readContentMail();

	$to      = 'personne@example.com';
	$subject = 'le sujet';
	$message = $contentMail;
	
	mail($to, $subject, $message, $headers);
 ?>
