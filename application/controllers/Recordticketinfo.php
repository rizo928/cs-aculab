<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Aculab\TelephonyRestAPI\InstanceInfo;

//////////////////////////////////////////////////////////////////////
//
//  Called after the caller leaves a callback number
//
class RecordTicketInfo extends CI_Controller {
    public function index()
    {
        log_message('debug', 'RecordTicketInfo.index()...');
/*	TWILIO CODE
        $callbackNo = $this->input->post('Digits');
*/

        $info = InstanceInfo::getInstanceInfo();
        $numberResult = $info->getActionResult();
        $callbackNo = $numberResult->getEnteredNumber();
        log_message('debug', 'Callback Number Entered: '.$callbackNo);
        // Using a simple file to store the callback number.
        // This isn't thread (multi-call) safe but it's simple
        // for prototype purposes.  In a production app we would store
        // it in a database indexed by a unique session ID.
        $GLOBALS['hConfig']->set('callbackNo',$callbackNo);
        $this->load->view('recordticketinfoview');
    } // index()   
} // class