<?php

namespace App\Mustache;

class TemplateLoader
{
	public static function loadTpl($tpl)
	{
		//Check for file
		$file = TPL_PATH . $tpl . '.mustache';
		
		if (!file_exists($file)) {
			throw new Exception('Template file '.$file.' not found');
		}
		
		//Load file
		return file_get_contents($file);
		
	}
}

?>