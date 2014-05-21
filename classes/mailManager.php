<?php

Class MailManager
{

	public function readContentMail()
	{
		$t = "";
		/*Ouverture du fichier en lecture seule*/
		$handle = fopen('contentMail.txt', 'r+');
		/*Si on a réussi à ouvrir le fichier*/
		if ($handle)
		{
			/*Tant que l'on est pas à la fin du fichier*/
			while (!feof($handle))
			{
				/*On lit la ligne courante*/
				$buffer = fgets($handle);
				$t.= $buffer;
				//$buffer.="<br />";
				//echo $buffer;
			}
			/*On ferme le fichier*/
			fclose($handle);
		}
		return $t;
	}

	public function writeContentMail($string)
	{
		$fp = fopen('contentMail.txt', 'r+'); // 1.On ouvre le fichier en lecture/écriture
		fseek($fp,0);                     // 4.On se place en début de fichier
		fputs($fp,$string);            // 5.On écrit dans le fichier le nouveau nb
		fclose($fp);                      // 6.On ferme le fichier
	
	}
}