<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Aculab\TelephonyRestAPI\InstanceInfo;
use \Aculab\TelephonyRestAPI\Actions;
use \Aculab\TelephonyRestAPI\Redirect;

/////////////////////////////////////////////////////////////////////
//
// Reaches here after the customer records a message detailing
// their needs.
//
class HandleRecording extends CI_Controller {

    ////////////////////////////////////////////////////////////////
    //
    // Save the recording pointed to by a partial URL to a temporary
    // local file
    //
    private function _getCloudFile($fname){
        // In a production application we wouldn't want to hold up
        // the call flow waiting for PHP to download and process
        // a binary recording.  We'd want to thread this somehow.
        //
        // Unfortunately the Aculab cloud file storage doesn't
        // allow a straightforward URL to access the file.  This is
        // probably a lot safer, but if necessitates downloading
        // the recording to enable engineer access to it.
        //
        // Note that a better way to do this would probably
        // be to exec in the background so as not to hold up
        // the main thread while the file downloads...
        // e.g. exec($cmd . " > /dev/null &"); 

        log_message('debug','_getCloudFile('.$fname.')...');

        // No Aculab PHP Language Wrapper to deal with cloud files
        // So we utilize CURL to POST the message directly
        $url = 'https://ws.aculabcloud.net/file_get';

        // Substitue your Aculab Cloud user name and
        // password here.
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

        // Again a very bad idea to do this in a real
        // production application, but here we just want
        // to make sure we get the whole file.
        //
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);

        $recordingData = curl_exec($curl);
        log_message('debug',"Writing test.wav...");

        // we would obviously use a unique name in a produciton
        // application vs. this embedded filename
        // we would also check to ensure the # of bytes
        // written isn't zero.
        log_message('debug', 'writing '.file_put_contents("test.wav",$recordingData).' bytes to file.');

        curl_close($curl);
    } // _getCloudFile()

    public function index()
    {
        log_message('debug', 'HandleRecording.index()...');

/*  TWILIO CODE

        $acid = $this->input->post('AccountSid');
        $csid = $this->input->post('CallSid');
        $rsid = $this->input->post('RecordingSid');
        $rurl = $this->input->post('RecordingUrl');
        $rlen = $this->input->post('RecordingDuration');
*/


        // Retrieve the filename of the recording stored earlier
        // in the call flow.
        //
        // Note again, that this isn't thread (multi-call) safe.
        // Rather we'd need to use a DB recorded keyed by a
        // unique session number
        $recordingFilename = $GLOBALS['hConfig']->get('recordingFilename');

        // Retrieve the call back number of the recording
        // stored earlier in the call flow.
        //
        // Note again, that this isn't thread (multi-call) safe.
        // Rather we'd need to use a DB recorded keyed by a
        // unique session number
        $callbackNo = $GLOBALS['hConfig']->get('callbackNo');

        log_message('debug', 'CallbackNo: '.$callbackNo);
        log_message('debug', 'Recording Filename: '.$recordingFilename);

        // Download the reording to a local file
        $this->_getCloudFile($recordingFilename);

        ////// send email

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from($GLOBALS['hConfig']->get('senderEmail'), 'Aculab Demo Application');
        $this->email->to($GLOBALS['hConfig']->get('engineerEmail'));

        $this->email->subject('Engineering Email');

        // Ugly format for email prototype.  In a production
        // application we'd of course do a nice HTML email body.
        $this->email->message("Customer entered callback number: ".$callbackNo."\n\n Additional customer details in attached recording.");

        // we would obviously use a unique name in a
        // produciton application vs. this embedded filename
        $this->email->attach('test.wav');

        $this->email->send();

        log_message('debug', 'email sent...');


        // With the Twilio API, handling of recordings is done
        // async to the main flow.  To keep the basic application
        // structure similar, redirect to ContactEngineer page
        $response = new Actions();
        $response->add(new Redirect(base_url('contactengineer')));
        
        // log_message('debug', $response);
        
        header("Content-Type: application/json; charset=UTF-8");
        print $response;

    }  // index()
   
} // class