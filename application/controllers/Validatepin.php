<?php defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////////////////////////////////////////////
//
//  Arrives here after caller enters their PIN number
//
use \Aculab\TelephonyRestAPI\InstanceInfo;

class ValidatePin extends CI_Controller {


    //////////////////////////////////////////////////////////////////
    //
    // Compare the caller entered PIN to the array of PIN numbers
    // stored in our persistent storage (default: filebox.json)
    //
    // Of course with a Production application we'd want to
    // do some sort of at rest encryption of this type of info
    //
    private function _isValidPIN($thePIN='')
    {
        // We an have single or array of valid pins
        if (is_array($GLOBALS['hConfig']->get('validPINS'))){
            if (in_array($thePIN, $GLOBALS['hConfig']->get('validPINS'))){
                return TRUE;
            }
        }
        else {
            if ($thePIN == $GLOBALS['hConfig']->get('validPINS')){
                return TRUE;
            }
        }
        return FALSE;
    } // _isValidPIN()

    public function index()
    {
        log_message('debug', 'ValidatePin.index()...');
        
/*      TWILIO CODE

        $enteredPIN = $this->input->post('Digits');
        $data = array('enteredPIN' => $enteredPIN);

*/
        $info = InstanceInfo::getInstanceInfo();
        $numberResult = $info->getActionResult();
        $enteredPIN = $numberResult->getEnteredNumber();

        log_message('debug', 'Entered PIN:',$enteredPIN);

        if ($this->_isValidPIN($enteredPIN)){
            $this->load->view('validpinview');
        }
        else{
            $data = array('enteredPIN' => $enteredPIN);
            $this->load->view('invalidpinview', $data);
        }

    }   // index()
} // class