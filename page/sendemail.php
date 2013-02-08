<?php
class page_sendemail extends Page {
    function init(){
        parent::init();

        $this->api->m->destroy();
        $m=$this->add('Model_User');

        $m->setLimit(15);
        $m->addCondition('is_sent',false);

        $cnt = 0;
        $m->each(function($m) use(&$cnt) {
            $cnt++;
            $m->test();
        });

        $this->add('View')->set('Sent to '.
            ($m->newInstance()->addCondition('is_sent',true)->count()));

        $this->add('View')->set('Remaining '.
            ($m->newInstance()->addCondition('is_sent',false)->count()));


        if($cnt){
            $this->add('View')->setElement('button')->set('Stop')->setAttr('onclick','window.close()');
            $this->js(true)->univ()->location($this->api->url());
        }else{
            $this->add('Button')->set('Done')->js(null,'window.close()');
        }
    }
}
