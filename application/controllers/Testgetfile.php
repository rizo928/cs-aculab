<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
//  Test downloading a file from the Aculab Cloud file store
//
//  This differes considerably from how it's accomplished with
//  Twilio since Twilio actually provides a URL pointing directly
//  to the file based on a unique recording ID.
//
//  This method/approach is probably a bit safer from a security
//  standpoint, since if you guess the recording ID (slim chance)
//  with Twilio you could directly pull down the file with no
//  additional credentials required.
//
class TestGetFile extends CI_Controller {

    private function _getCloudFile($fname){
        // No Aculab PHP Language Wrapper to deal with cloud files
        // So we utilize CURL to POST the message directly
        $url = 'https://ws.aculabcloud.net/file_get';
        // $auth = '1-2-0/yourlogin@server.com'.":".'yourpassword';
        $auth = $GLOBALS['hConfig']->get('acctLogin').":".
                $GLOBALS['hConfig']->get('acctPwd');
        $fields = array('filetype' => "media",
                        'filename' => $fname);
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
        log_message('debug',"Writing test.wav...");
        file_put_contents("test.wav",$resp);

        curl_close($curl);
    } // _sendSMS()

    public function index()
    {
        log_message('debug', 'TestGetFile.index()...');
        // To test, replace the "path" with one
        // that actually exists in your Aculab Cloud
        // file store
        $this->_getCloudFile('path-to-your-file-here');

    }  // index()   
} // class