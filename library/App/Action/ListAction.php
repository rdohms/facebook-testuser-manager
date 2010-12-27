<?php

namespace App\Action;

class ListAction extends Base
{
	
	public function run()
	{
		//Get list of users
		$users = array();
		//Get extra data
		
		//Render Template
		$this->getMustache()->renderContent('list', array('users' => $users));
	}
	
}

?>