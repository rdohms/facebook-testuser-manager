<?php

namespace App\Action;

class AboutAction extends Base
{
	
	public function run()
	{
		//Render Template
		$this->getMustache()->renderContent('about', array());
	}
	
}

?>