<?php 

class Model_User extends Model_Table {
	public $table = 'users';

    function init(){
        parent::init();
       
        $this->addField('name')->sortable(true);
        $this->addField('email')->sortable(true);
        $this->addField('type')->sortable(true);

        $this->addField('is_sent')->type('boolean')->sortable(true);
        $this->addField('sent_time')->type('datetime')->editable(false)->sortable(true);
        
    }
	function sendEmail(){
		$mail=$this->add('TMail');
		$mail->loadTemplate($this['type']);
		$mail->setTag('subject','Elexu Creative Live! Sat 23rd February');
		$mail->setTag('name',$this['name']);
		$m=$mail->send($this['email']);

        if($m){
            $this['is_sent']=true;
            $this['sent_time']=date('Y-m-d H:i:s');
            $this->save();
        }

        return $m;
	}

    function test(){
        echo "Sending to ".$this['email'].' type of '.$this['type']."<br>";
        $this['is_sent']=true;
        $this->saveAndUnload();
    }
}
?>
