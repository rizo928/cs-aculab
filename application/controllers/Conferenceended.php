<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Aculab\TelephonyRestAPI\InstanceInfo;
use \Aculab\TelephonyRestAPI\ActionResult;
use \Aculab\TelephonyRestAPI\ConnectResult;

//////////////////////////////////////////////////////////////////////
//
//  Called when the the conference ends (regardless of who
//  disconnected first, second, etc.)
//
class ConferenceEnded extends CI_Controller {

	public function index()
	{
		log_message('debug', 'ConferenceEnded.index()...');
		$info = InstanceInfo::getInstanceInfo();
		$connectResult = $info->getActionResult();
		$durationConnected = $connectResult->getSecondsConnectedDuration();
		log_message('debug','Time connected: '.$durationConnected);

		// Check to see if the caller was actually connected to
		// an engineer or not.  Assume yes if the duration of
		// the conference is more than X seconds
		if ($durationConnected < 1){
			// Never connected to the engineer
        	$this->load->view('unsatisfiedcustomerview');
		} else {
			// Connected and presumably the issue is resolved
        	$this->load->view('satisfiedcustomerview');
		}
	} // index()
} // class