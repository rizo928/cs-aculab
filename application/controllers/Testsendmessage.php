<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
//  Simple controller to test sending an SMS/text message using
//  the Aculab Cloud REST API
//
class TestSendMessage extends CI_Controller {

    private function _sendSMS($to,$from,$body){
        // No Aculab PHP Language Wrapper to send SMS message
        // So we utilize CURL to POST the message directly
        $url = 'https://ws.aculabcloud.net/msg_send';
        // $auth = '1-2-0/<youraccountname>'.":".'<password>';
        $auth = $GLOBALS['hConfig']->get('acctLogin').":".
        $GLOBALS['hConfig']->get('acctPwd');
        $fields = array('to' => $to,
                        'from' => $from,
                        'content' => $body,
                        'request_delivery_report' => 'true',
                        'status_page' => base_url('testsmsstatus'));
        $post = http_build_query($fields);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // url_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT , 'Mozilla 5.0');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_USERPWD, $auth);
        curl_setopt($curl, CURLOPT_VERBOSE , true);

        $resp = curl_exec($curl);

        log_message('debug',$resp);

        curl_close($curl);
    } // _sendSMS()

    public function index($theMsg='**default**')
    {
        log_message('debug', 'TestSendMessage.index()...');
        /*
        $this->_sendSMS($GLOBALS['hConfig']->get('engineerPhone'),
                        $GLOBALS['hConfig']->get('smsFrom'),
                        'message from _sendMessage() controller');
        */
        $this->_sendSMS('yourdestnumber','yourvalidtwilionumber','themessagetosend');
    }  // index()
   
} // class