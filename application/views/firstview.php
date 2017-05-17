<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'firstview...');

/* TWILIO CODE

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>

<Response>
    <Gather action="http://www.bitrox.io/validatepin" method="POST">
        <Say>
            Welcome to Jiffy Pop.
            Please enter your PIN number,
            followed by the pound sign
        </Say>
    </Gather>
    <Say>We didn't receive any input. Goodbye!</Say>
</Response>

*/

use \Aculab\TelephonyRestAPI\Actions;
use \Aculab\TelephonyRestAPI\Play;
use \Aculab\TelephonyRestAPI\GetNumber;


$response = new Actions();
$ttsvoice = $GLOBALS['hConfig']->get('ttsVoice');
$prompt = Play::sayText('Welcome to the Aculab Prototype. Please enter your PIN number followed by the pound sign',$ttsvoice);
$getnum = new GetNumber($prompt);
$getnum->setNextPage(base_url('validatepin'));
$response->add($getnum);

// log_message('debug', $response);

header("Content-Type: application/json; charset=UTF-8");
print $response;