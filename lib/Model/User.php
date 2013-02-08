<?php 

class Model_User extends Model_Table {
	public $table = 'users';

    function init(){
        parent::init();
       
        $this->addField('name');
        $this->addField('email');
        $this->addField('type');
        
    }
}
?>
