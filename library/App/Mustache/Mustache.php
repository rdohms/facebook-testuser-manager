<?php

namespace App\Mustache;

use App\Mustache\TemplateLoader;

class Mustache extends \Mustache
{
	
	public function renderContent($tpl, $data)
	{
		$template = TemplateLoader::loadTpl($tpl);
		
		$content = parent::render($template, $data);
		
		echo $this->layoutRender($content);
	}
	
	public function layoutRender($content)
	{
		$layout = TemplateLoader::loadTpl('layout');

		return parent::render($layout, array('content' => $content));
	}
}

?>