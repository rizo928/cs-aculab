<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'validpinview...');

/*  TWILIO CODE

    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Gather action="http://www.bitrox.io/recordticketinfo" method="POST">
        <Say>
            Please enter a callback number, 
            followed by pressing the pound sign.
        </Say>
    </Gather>
    <Say>We didn't receive any input. Goodbye!</Say>
</Response>

*/

use \Aculab\TelephonyRestAPI\Actions;
use \Aculab\TelephonyRestAPI\Play;
use \Aculab\TelephonyRestAPI\GetNumber;

$response = new Actions();
$response->setToken('my instance id');
$ttsvoice = $GLOBALS['hConfig']->get('ttsVoice');
$prompt = Play::sayText('Please enter a callback number followed by the pound sign',$ttsvoice);
$getnum = new GetNumber($prompt);
$getnum->setNextPage(base_url('recordticketinfo'));
$response->add($getnum);

// log_message('debug', $response);

header("Content-Type: application/json; charset=UTF-8");
print $response;