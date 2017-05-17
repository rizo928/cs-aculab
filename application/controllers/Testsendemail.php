<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
//  Simple controller to test whether sendmail is configured
//  correctly and working with the Codeigniter framework
//
class TestSendEmail extends CI_Controller {
    public function index()
    {
        log_message('debug', '_SendMail.index()');

		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;

		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from('<you@yourserver.com>', 'Proxy');
		$this->email->to('<them@theirserver.net');

		$this->email->subject('Email Test from Aculab Demo');
		$this->email->message('Testing wav attachment');
		$this->email->attach('test.wav');

		$this->email->send();

		$this->load->view('sendemailview');

    } // index()   
} // class