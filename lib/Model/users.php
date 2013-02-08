<?php 

class Model_Users extends Model_Table {
	public $table = 'users';

    function init(){
        parent::init();

       
        $this->addField('name');
        $this->addField('email');
        $this->addField('type');
        
    }
}
?>