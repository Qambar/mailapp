<?php

class page_ticket extends Page {
	function init() {
		parent::init();

		$m = $this->add('Model_Users');

		$m->tryLoadBy('code', $_GET['code']);

		if(!$m->loaded()){

		}
		
		$this->template->set($m->get());

	}
	function defaultTemplate() {
		return array('page/ticket');
	}
	
}