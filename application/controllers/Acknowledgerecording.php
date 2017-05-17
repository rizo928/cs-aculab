<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Aculab\TelephonyRestAPI\InstanceInfo;

//////////////////////////////////////////////////////////////////////
//
//  Called when the caller finishes leaving a recording
//
class AcknowledgeRecording extends CI_Controller {

	public function index()
	{
		log_message('debug', 'AcknowledgeRecording.index()...');

		// Get and save recording path because it won't be available
		// later in the flow when we want to get the file and
		// email it.
        $info = InstanceInfo::getInstanceInfo();
        $recordResult = $info->getActionResult();
        $recordingFilename = $recordResult->getFilename();
        // Options we could check if we wanted to for this app
        // 	$containsSound = $recordResult->getContainsSound();
        // 	$recordingDuration = $recordResult->getSecondsDuration();
        $GLOBALS['hConfig']->set('recordingFilename', $recordingFilename);

		$this->load->view('acknowledgerecordingview');
	} // index()
} // class