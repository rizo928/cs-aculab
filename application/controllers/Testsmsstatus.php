<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
//  Test retrieval of status of previously sent SMS/text
//
class TestSmsStatus extends CI_Controller {

    public function index()
    {
        log_message('debug', 'TestSmsStatus.index()...');

        $jsonMessageBody = file_get_contents('php://input');
        log_message('debug',$jsonMessageBody);

        $aMessageBody = json_decode($jsonMessageBody); // access as an array for convienece



    } // index()   
} // class