<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
// Start the outbound call to the on-call engineer
//
class ContactEngineer extends CI_Controller {

/* TWILIO CODE
    private function _startEngineerCall(){
        log_message('debug', 'Starting engineer call...');
        $sid = $GLOBALS['hConfig']->get('twilioSEID');
        $token = $GLOBALS['hConfig']->get('twilioToken');
        try {
            $client = new Twilio\Rest\Client($sid, $token);
            $call = $client->calls->create(
                $GLOBALS['hConfig']->get('engineerPhone'), // To
                "+15552345555", // From
                array("url" => "http://myserver.com/greetengineer")
            );
        } // try

        catch(Exception $e){
            $this->load->view('error_view');
        } // catch

    } // _startEngineerCall()
*/
    public function index()
    {
        log_message('debug', 'ContactEngineer.index()...');

    	// start the outbound call to an engineer
    	// TWILIO CODE: $this->_startEngineerCall();

        $this->load->view('contactengineerview');
    } // index()   
} // class