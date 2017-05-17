<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
//  Called when the the engineer rejects the request to assist
//  the customer
//
class EReject extends CI_Controller {

	public function index()
	{
		log_message('debug', 'EReject.index()...');

		$this->load->view('erejectview');
	} // index()
} // class