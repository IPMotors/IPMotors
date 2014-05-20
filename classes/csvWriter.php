<?php

Class CsvWriter
{
	private $fOpen;
	private $fLog;

	public function __construct()
	{
		$this->fInsertHeaderAutomatically = true;
		$this->fLog = false;
		$this->fOpen = false;
		$this->fFirstLine = true;
	}

	function __destruct()
	{
		if ($this->fOpen == true)
		{
			echo "Error: the file has not been closed properly\n";
			$this->Close();
		}
	}

	public function open($inPath)
	{
		if($this->fOpen === false)
		{
			$this->fLog = fopen( $inPath , "w" );

			if($this->fLog != false)
				$this->fOpen = true;
		}

		return ($this->fOpen !== false);
	}

	public function writeLine($inString)
	{
		if($this->fOpen == true)
		{
			$str = $inString."\n";
			fwrite( $this->fLog,$str);
		}
	}

	public function insertHeaderAutomatically(){ $this->fInsertHeaderAutomatically = true; }
	
	public function writeLineFromArray($inArrayLine)
	{
		if ($this->fFirstLine && $this->fInsertHeaderAutomatically)
		{
			$array_name = array();
			foreach ($inArrayLine as $k => $v)
				$array_name[] = $k;

			$one_line = implode(';',$array_name);
			$one_line = iconv('UTF-8','UTF-8//IGNORE',$one_line);
			$one_line .= "\n";
			if ($this->fLog)
				fwrite($this->fLog,$one_line);
		}
		
		$clean_array = str_replace(';',',',$inArrayLine);
		$clean_array = str_replace("\r",'',$clean_array);
		$clean_array = str_replace("\n",'',$clean_array);
		$one_line = implode(';',$clean_array);
		$one_line = iconv('UTF-8','UTF-8//IGNORE',$one_line);
		$one_line .= "\n";
		
		if ($this->fLog)
			fwrite($this->fLog,$one_line);
			
		$this->fFirstLine = false;			
	}
	
	public function close()
	{
		if($this->fOpen == true)
		{
			fclose($this->fLog);
			$this->fOpen = false;
		}
	}
}