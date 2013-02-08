<?php

class page_index extends Page {
	function init() {
		parent::init();
		$g = $this->add('CRUD');

		$g->setModel('User');
		
		if (is_object($g->grid)) {
			$g->grid->addPaginator(15);
			$g->grid->addQuickSearch( array('name', 'email', 'type') );
			$sendSingleMail = $g->grid->addColumn('button','SendEmail');
			if ($_GET['SendEmail']) {	

                $g->model->load($_GET['SendEmail'])->sendEmail();
				$this->js(null,$g->grid->js()->reload())->univ()->alert("Mail Sent Successfully to " . $g->model['name'])->execute();
			}
		}	


        $this->add('Button')->set('Send to '.$g->model->count().' emails')->js('click')->univ()->newWindow(
            $this->api->url('sendemail'),
            'emails',
            'width=500,height=300,menubar=0,statusbar=1'
        );
        	
	}
	function defaultTemplate() {
		return array('page/index');
	}
}
