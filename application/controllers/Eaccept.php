<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
//  Called when the the engineer accepts the request to assist
//  the customer
//
class EAccept extends CI_Controller {

	public function index()
	{
		log_message('debug', 'EAccept.index()...');

		// REACHES HERE IF THE ENGINEER ACCEPTS THE CALL

		// DO NOTHING AND THE CALL IS SIMPLY CONNECTED
		// TO THE CUSTOMER

	} // index()
} // class