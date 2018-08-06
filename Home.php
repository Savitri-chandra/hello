<?php
class Home extends MY_Controller{

	public function index(){

		$this->email->from('kumar.daulat.07@gmail.com', 'Daulat');
		$this->email->to('djwadh910@gmail.com'); 
		$this->email->subject('Email Test');
		$this->email->message('<b>Testing the email class.</b>');	
		
		if($this->email->send()){
			echo 'mail send ';
		}
      die();
		//echo $this->email->print_debugger();
    }
	
	
}

?>