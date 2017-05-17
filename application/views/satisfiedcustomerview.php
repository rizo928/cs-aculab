<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'satisfiedcustomerview...');

use \Aculab\TelephonyRestAPI\Actions;
use \Aculab\TelephonyRestAPI\Play;
use \Aculab\TelephonyRestAPI\HangUp;

// Reaches here based on the fact that the caller was actually
// in a conference with the engineer for more than X seconds

$response = new Actions();
$ttsvoice = $GLOBALS['hConfig']->get('ttsVoice');
$response->add(Play::sayText('Thanks for letting us assist you Goodbye',$ttsvoice));
$response->add(new HangUp());

// log_message('debug', $response);

header("Content-Type: application/json; charset=UTF-8");
print $response;