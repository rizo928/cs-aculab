<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'invalidpinview...');

/*  TWILIO CODE

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Say>
    	<?php echo $enteredPIN; ?> is not valid.
        You must have a valid customer PIN to use our system. Goodbye!
    </Say>
    <Hangup/>
</Response>

*/

use \Aculab\TelephonyRestAPI\Actions;
use \Aculab\TelephonyRestAPI\Play;
use \Aculab\TelephonyRestAPI\HangUp;

$response = new Actions();
$response->setToken('my instance id');
$ttsvoice = $GLOBALS['hConfig']->get('ttsVoice');
// Should add some SSML so that the digits are spoken individually
// here, instead of as a whole number
$response->add(Play::sayText($enteredPIN.'is not valid.'.
							' You must have a valid customer PIN to use our system Goodbye!',$ttsvoice));
$response->add(new HangUp());

// log_message('debug', $response);

header("Content-Type: application/json; charset=UTF-8");
print $response;