<?php

class page_checkin extends Page {
	function init() {
		parent::init();
		
		

		$f = $this->add('Form');
		$f->addField('Line', 'code_or_name');
		$f->addSubmit('Check_In');


		$users = $this->api->db->dsql();
		$allusers = $users->table('users')->field('name')->field('code')->getAll();

		//var_dump($allusers);

		$tagList = "";
		foreach ($allusers as $user) {
			$tagList .= '"' . $user['name'] .'", ';
			$tagList .= '"' . $user['code'] .'", ';
		}
		$tagList = substr($tagList, 0, -2);
		$this->template->set('nameandcodes', $tagList);

		if($f->isSubmitted()){
	
			$users = $this->api->db->dsql();

			$checkin = $users ->table('users')
				->field('checkin')
				->where('code="' . $f->get('code_or_name') . '" OR name="' . $f->get('code_or_name') . '"')
				->get();

			$alreadyCheckin = $checkin[0]['checkin'];

			if (!$checkin) {
				$this->js()
			   		->univ()
			   		->alert('Invalid Ticket ! Code: '  . $f->get('code_or_name'))
			   		->execute();
			}

			if ($alreadyCheckin == 1) {
				
				$this->js()
		   		->univ()
		   		->alert('Alert ! This person has already checkedin before. Code:  ' . $f->get('code_or_name'))
		   		->execute();

			} else  {
			
				$users
				//->table('users')
		    	->set('checkin', '1')
		    	//->set('checkin_time', time())
		    	//->where('code=' . $f->get('code'))
		    	->update();
		      
			   	$this->js()
			   		->univ()
			   		->alert('Successfully checked in ' . $f->get('code_or_name'))
			   		->execute();
			}

		    
		}
		
	}
	function defaultTemplate() {
		return array('page/checkin');
	}
}