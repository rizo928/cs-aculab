<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
//  Landing page for receipt of SMS messages
//
//  Never really did get any of the SMS stuff to work
//  for the Aculab Cloud.  Mainly having issues with the
//  send... shows sent in status, but no message ever received and
//  no error messages anywhere that I can see...
//
//  TBD to work out the kinks here
//
class ReceiveSMS extends CI_Controller {

    private function _sendSMS($to,$from,$body){

/* TWILIO CODE

        $sid = $GLOBALS['hConfig']->get('twilioSEID');
        $token = $GLOBALS['hConfig']->get('twilioToken');
        $client = new Twilio\Rest\Client($sid, $token);

        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
        // the number you'd like to send the message to
        $to,
        array(
            // A Twilio phone number you purchased at twilio.com/console
            'from' => $from,
            // the body of the text message you'd like to send
            'body' => $body
            )
        );

*/

        // No Aculab PHP Language Wrapper to send SMS message
        // So we utilize CURL to POST the message directly
        //
        $url = 'https://ws.aculabcloud.net/msg_send';
        $fields = array('to' => '15550001234',
                        'from' => '15552341234',
                        'content' => 'SMS message content here');
        $post = http_build_query($fields);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT , 'Mozilla 5.0');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        // curl_setopt($curl, CURLOPT_USERPWD, $auth);
        curl_setopt($curl, CURLOPT_VERBOSE , true);

        $resp = curl_exec($curl);

        log_message('debug',$resp);

        curl_close($curl);

    } // _sendSMS()

    public function index()
    {
        log_message('debug', 'ReceiveSMS.index()...');

/* TWILIO CODE
        $from = $this->input->post('From');
        $body = json_decode($this->input->post('Body'),true);
*/

        $jsonMessageBody = file_get_contents('php://input');
        log_message('debug',$jsonMessageBody);

        /* Example JSON received in the body of the message

        {"status": "received", "direction": "receive", "from": "15554499760", "msg_ref": "36e1766e_2.1493141823.12345", "timestamp": "2017-04-25_17:37:03", "content": "Test4", "to": "15558130969", "aculab_msg_err": "000", "type": "sms"} 

        */

        $aMessageBody = json_decode($jsonMessageBody); // access as an array for convienece


        $responseSMS = "We received your application configuration message.\n";

        return;

        if (is_null($body)){
        	log_message('debug',"Received Invalid JSON");
        	return;
        }
		log_message('debug', 'SMS Received From: '.$from);
		foreach ($body as $key => $value) {
    		// log_message('debug','Key: '.$key.' Value: '.$value);
    		switch ($key){
    			case 'validPINS':
                    if (!is_array($value)){
                        log_message('debug',"Adding a single PIN");
                    }
                    else {
                        log_message('debug','Setting the array of valid PINS');
                    }
                    $GLOBALS['hConfig']->set($key,$value);
                    $responseSMS = $responseSMS.$key." set to: ".json_encode($value)."\n";
                    break;
                case 'engineerPhone':
                case 'engineerEmail':
                case 'smsFrom':
                   	log_message('debug', 'Process '.$key.'...');
                    $GLOBALS['hConfig']->set($key,$value);
                    $responseSMS = $responseSMS.$key." set to: ".json_encode($value)."\n";
    				break;
    			default:
    				log_message('debug', 'Process default...');
                    $responseSMS = "Invalid configuration key: ".$key."\n";
    		} // switch
  		} // foreach

        $this->_sendSMS($from, // respond back to original sender
                $GLOBALS['hConfig']->get('smsFrom'),
                $responseSMS);

    } // index()   
} // class