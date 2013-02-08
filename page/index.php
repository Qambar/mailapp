<?php

class page_index extends Page {
	function init() {
		parent::init();
		$g = $this->add('CRUD');

		
//		$g->grid->getColumn('name')->makeSortable(); //->makeSortable(array('name', 'email'));
	//	$g->grid->getColumn('email')->makeSortable();

		
		//$search->addField("email");
		if (is_object($g->grid)) {
			$g->grid->addPaginator(15);
			$g->grid->addQuickSearch( array('name', 'email', 'type') );
			$sendSingleMail = $g->grid->addColumn('button','SendEmail');
			//var_dump($_GET);
			if ($_GET['SendEmail']) {	

				$users = $this->api->db->dsql();

				$userdetail = $users
								->table('users')
								->where('id', $_GET['SendEmail'])
								->get();
				
				$type 		= $userdetail[0]['type'];
				$name 		= $userdetail[0]['name'];
				$email 		= $userdetail[0]['email'];
				$this->sendMail($type, $name, $email);
				
				$this->js()->univ()->alert("Mail Sent Successfully to " . $name)->execute();
			}
		}	
		$g->setModel('users');

		$f = $this->add('Form');
		$sendEmailToAllButton = $f->addButton('sendEmailtoAll')->setLabel('Send Email to All');

		if ($sendEmailToAllButton->isClicked()) {

			//$this->js()->univ()->alert("Test ")->execute();

			
			$users = $this->api->db->dsql();

			$user = $users
							->table('users')		
							->get();

			foreach($user as $usr) {
				$type 		= $usr['type'];
				$name 		= $usr['name'];
				//$code 		= $usr['code'];
				$email 		= $usr['email'];

				//$this->sendMail($type, $name, $email);
			}

			$f
				->js()
				->univ()
				->alert('All Emails have been sent !')
            	->execute();

            	
		}
        	
	}
	function sendMail($type, $name, $email) {
		
		$mail=$this->add('TMail');
		$mail->loadTemplate($type);
		$mail->setTag('subject','Elexu Creative Live! Sat 23rd February');
		$mail->setTag('name',$name);
		//$mail->setTag('code',$code);
		/*
		$mail->setTag('link',$this->api
		->getDestinationURL('./ticket',array('code'=>$code))
		    ->useAbsoluteURL());
		*/

		//tickets will be generated and links will be sent to user via mail, when the user will click on the 
		//link he will see the ticket in pdf and he will be able to print it 		

		//$mail->attachFile('ticket.pdf', 'application/pdf');
		//return true;
		//uncomment below to activae mail sending again
		return $mail->send($email);
	}
	function defaultTemplate() {
		return array('page/index');
	}
}