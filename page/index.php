<?php

class page_index extends Page {
	function init() {
		parent::init();
		$g = $this->add('CRUD');

		$g->setModel('User');
		
		//$search->addField("email");

		if (is_object($g->grid)) {
			$g->grid->addPaginator(15);
			$g->grid->addQuickSearch( array('name', 'email', 'type') );
			$sendSingleMail = $g->grid->addColumn('button','SendEmail');
			//var_dump($_GET);
			if ($_GET['SendEmail']) {	

                $g->model->load($_GET['SendEmail'])->sendEmail();

                /*
				$users = $this->api->db->dsql();

				$userdetail = $users
								->table('users')
								->where('id', $_GET['SendEmail'])
								->getHash();
				
				$type 		= $userdetail[0]['type'];
				$name 		= $userdetail[0]['name'];
				$email 		= $userdetail[0]['email'];
				$this->sendMail($type, $name, $email);
                 */
				
				$this->js(null,$g->grid->js()->reload())->univ()->alert("Mail Sent Successfully to " . $g->model['name'])->execute();
			}
		}	


        $this->add('Button')->set('Send to '.$g->model->count().' emails')->js('click')->univ()->newWindow(
            $this->api->url('sendemail'),
            'emails',
            'width=500,height=300,menubar=0,statusbar=1'
        );


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
	function defaultTemplate() {
		return array('page/index');
	}
}
