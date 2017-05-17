<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'recordticketinfoview...');

/*  TWILIO CODE

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Say>
        Please state your company name and a brief summary of the issue at the beep. Press the star key when finished. 
    </Say>
    <Record 
        action="http://www.bitrox.io/contactengineer"
        recordingStatusCallback="http://www.bitrox.io/handlerecording"
        maxLength="60"
        finishOnKey="*"
        />
    <Say>I did not receive a recording. Goodbye!</Say>
</Response>

*/

use \Aculab\TelephonyRestAPI\Actions;
use \Aculab\TelephonyRestAPI\Play;
use \Aculab\TelephonyRestAPI\Record;

$response = new Actions();
$response->setToken('my instance id');
$ttsvoice = $GLOBALS['hConfig']->get('ttsVoice');
$response->add(Play::sayText(
    'Please state your company name and a brief summary of the issue at the beep'.
    ' Press the pound key when finished',$ttsvoice));
$response->add(new Record(array('next_page' => base_url('acknowledgerecording'),
                                'beep_on_start' => true)));

// log_message('debug', $response);

header("Content-Type: application/json; charset=UTF-8");
print $response;