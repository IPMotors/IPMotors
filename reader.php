<?php

Class CsvReader
{
	function __construct()
	{
		$this->fLogger = false;
		$this->fCsvEncoding = "UTF-8";
		$this->fDelimiter = ";";
		$this->fQuote = '"';
		$this->fNbColumns = false;
		$this->fSkipFirstLine = false;
		$this->fFirstLine = true;
	}

	function setSkipFirstLine($inBool){ $this->fSkipFirstLine = $inBool; }

	function setDelimiter($inDelimiter){ $this->fDelimiter = $inDelimiter; }
	function getDelimiter(){ return $this->fDelimiter;}

	function setQuote($inQuote){ $this->fQuote = $inQuote; }
	function getQuote(){ return $this->fQuote; }

	function setCsvEncoding($inCsvEncoding){ $this->fCsvEncoding = $inCsvEncoding; }

	function parseCsv($inCsvFile,$inCallbackArray, $inCallbackArgs = null)
	{
		if($this->fLogger)
			$this->fLogger->beginStep('Parse Csv');

		$result = false;

		$converted_file = basename($inCsvFile, ".csv");
		$ctx = stream_context_create();

		ini_set('auto_detect_line_endings', '1');	// to fix problems with some line endings
		$handle = @fopen($inCsvFile, "r",false,$ctx);

		if($handle)
		{
			$result = true;
			while(!feof($handle))
			{
				$buffer = fgets($handle,8192);
				if(strlen($buffer)>0)
				{
					$array_str = fgetcsv($handle,8192,$this->getDelimiter(),$this->getQuote());

					if($this->fNbColumns === false)
						$this->fNbColumns = count($array_str);

					if(($this->fNbColumns != count($array_str)) && $this->fLogger)
						$this->fLogger->WriteError("Unexpected number of rows for this line : ".$buffer);

					if($this->fCsvEncoding)
					{
						$array_size	= count($array_str);

						for($cpt=0;$cpt<$array_size;++$cpt)
							$array_syt[$cpt] = iconv($this->fCsvEncoding,"UTF8//IGNORE",$array_str[$cpt]);
					}

					// remove an extra CRLF
					$array_str[count($array_str)-1] = trim($array_str[count($array_str)-1]);

					if ($this->fFirstLine && $this->fSkipFirstLine)
						;
					else
						call_user_func( $inCallbackArray, $array_str, $inCallbackArgs,null );

					$this->fFirstLine = false;

				}
			}
			fclose($handle);
		}
		else
		{
			if($this->fLogger)
				$this->fLogger->writeError("Couldn't open $inCsvFile");
		}

		if($this->fLogger)
			$this->fLogger->endStep();

		return $result;
	}
}

?>