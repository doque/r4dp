<?php

class eMail {
	private $from;
	private $to;
	private $subject;
	private $message;

	public function __construct() {
		$this->from = '';
		$this->to = array();
		$this->subject = '';
		$this->message = '';
	}

	public function addRecipients($rec) {
		if(!is_array($rec)) {
			$rec = array($rec);
		}
		$this->to = array_merge($this->to, $rec);
		return $this;
		
	}

	public function send() {
		if(empty($this->from) || empty($this->to) || empty($this->subject) || empty($this->message)) {
			return false;
		}

		$recs = array();
		foreach($this->to AS $rec) array_push($recs, '<'.$rec.'>');

		$header =   'Content-Type: text/html; charset=iso-8859-15'."\r\n".
					'From: '.$this->from."\r\n".
					'To: '.implode(', ', $recs)."\r\n".
					'X-Mailer: PHP/'.phpversion();

		$status = true;
		foreach($this->to AS $recipient) {
			if(!@mail($recipient, $this->subject, $this->message, $header)) $status = false;
		}
		return $status;
	}

	public function setMessage($msg) {
		$this->message = str_replace(array("\r\n", "\n\r"), "\n", $msg);
		return $this;
	}

	public function setSender($from) {
		$this->from = $from;
		return $this;
		
	}

	public function setSubject($subj) {
		$this->subject = $subj;
		return $this;
		
	}
}

?>