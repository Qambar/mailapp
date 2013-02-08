<?php
class MailApp extends ApiFrontend {

	function init() {
		parent::init();
		//$this->addLayout('Menu');

        $this->m=$m=$this->add('Menu',null,'Menu','Menu');
        $m->current_menu_class="current";
        $m->inactive_menu_class="";
       
        $m->addMenuItem('index','Users');
     //   $m->addMenuItem('mail','Mail');
       // $m->addMenuItem('checkin','Check In');
        
        $this->add('jUI');
		$this->dbConnect();
	}


}

?>
