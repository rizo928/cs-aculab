<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*////////////////////////////////////////////////////////////////////

	The application is based on the Codeigniter 3.x framework for PHP.

	The application was tested with PHP 7.x, though it MAY work fine with PHP >= 5.6

	Some configuration is necessar in application/config/config.php
	Autoload items are in application/config/autoload.php
	Librarie(s) are included in application/libraries
	An application specific JSON formatted file for application changeable yet
	persistent variables in a file called "filebox.json" (see libraries/filebox.php
	to change this default name/path).

	Application depends on removal of requirement for index.php to
	appear in URLs.  This is accomplised by including a specific
	.htaccess file with rewrite rules in the base directory as well
	as mod_rewrite on in Apache's http.conf file. (see the
	Codeigniter documentation for details on how to do this).

	The basic application flow (i.e. order of controllers called) is as follows:

	First->ValidatePin->RecordTicketInfo->HandleRecording->ContactEngineer->ConferenceEnded
                                        				 ->GreetEngineer

    The top line is the flow for the customer and the bottom line for the on-call engineer.

    There are also controllers for a super simple web interface to set some commonly changed
    application parameters (myurl.com/admin) and a controller to handle inbound SMS used to
    set a subset of said parameters.

	Controllers and views where their name begins with an "Test" are simply unit tests.

	CAUTION:  	This entire application consists of DEMONSTRATION
	            code that is absolutely NOT production quality software.  In most cases, methods do very little
				error checking on inbound parameters.  
				Addtionally, in most cases return values from methods aren't checked except as necessary to suppor the
				main flow.  Considerable debug logging is included to help resolve any issues.  However, if you want to actually utilize any/parts of this code, please review it and invest the effort needed to increase it's robustness.

	WARNING:	As written, this application demonstration is
				NOT thread/multi-call safe. This is intentionl to maintain a level of simplicity.  I've included
				comments sprinkled througout to point out obvious
				specific bits of code that aren't thread safe, but make no warranty that I've documented each and every
				such place/condition.  Specifically absolutely NO
				testing was done in terms of placing simultaneous
				calls into the application.

*/////////////////////////////////////////////////////////////////////
use \Aculab\TelephonyRestAPI\InstanceInfo;

class First extends CI_Controller {

	public function index()
	{
		log_message('debug', 'First.index()...');

		// $info = InstanceInfo::getInstanceInfo();
		// $cinfo = $info->getThisCallInfo();
		// log_message('debug','getCallId: '.$cinfo->getCallId());
		// log_message('debug','getCallDirection: '.$cinfo->getCallDirection());
		// log_message('debug','getCallFrom: '.$cinfo->getCallFrom());
		// log_message('debug','getCallTo: '.$cinfo->getCallTo());
		// log_message('debug','getCallTarget: '.$cinfo->getCallTarget());

		$this->load->view('firstview');

	} // index()
} // class
