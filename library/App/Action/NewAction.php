<?php

namespace App\Action;

class NewAction extends Base
{
	
	public function run()
	{		
		//Render Template
		$this->getMustache()->renderContent('new', array());
	}
	
}

?>