<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Aculab\TelephonyRestAPI\InstanceInfo;

//////////////////////////////////////////////////////////////////////
//
//  Called at the end of the customer's call regardless of the
//  path through the app (short of a critical error)
//
class FinalPage extends CI_Controller {

	public function index()
	{
		log_message('debug', 'FinalPage.index()...');

/*

		Just some stuff that we could look at here if
		the application called for it...
		
		$info = InstanceInfo::getInstanceInfo();
		log_message('debug','getToken: '.$info->getToken());
		log_message('debug','getApplicationInstanceId: '.$info->getApplicationInstanceId());
		log_message('debug','getLogFilename: '.$info->getLogFilename());
		// log_message('debug','getActionResult: '.$info->getActionResult());
		if (!is_null($info->getErrorResult())){
			log_message('debug','getErrorResult: '.$info->getErrorResult()->getResult());
		}
		// log_message('debug','getActionProgress: '.$info->getActionProgress());
		// log_message('debug','getDroppedCallInfo: '.$info->getDroppedCallInfo());


		$cinfo = $info->getThisCallInfo();
		log_message('debug','getCallId: '.$cinfo->getCallId());
		log_message('debug','getCallDirection: '.$cinfo->getCallDirection());
		log_message('debug','getCallFrom: '.$cinfo->getCallFrom());
		log_message('debug','getCallTo: '.$cinfo->getCallTo());
		log_message('debug','getCallTarget: '.$cinfo->getCallTarget());
		log_message('debug','getSecondsCallDuration: '.$cinfo->getSecondsCallDuration());
		log_message('debug','getCallState: '.$cinfo->getCallState());
		log_message('debug','getCallCause: '.$cinfo->getCallCause());
		log_message('debug','getApplicationParameters: '.$cinfo->getApplicationParameters());
		log_message('debug','getOutboundParameters: '.$cinfo->getOutboundParameters());
		log_message('debug','getFarEndType: '.$cinfo->getFarEndType());
		log_message('debug','getCallRecordingFilename: '.$cinfo->getCallRecordingFilename());

*/

		// In a production application we would be checking here
		// to see if the caller left his/her information and
		// was disconnected in the call flow before the email to
		// the engineer went out.  If so, we should send the email
		// to the engineer here so that the customer gets a callback.

	} // index()
} // class
