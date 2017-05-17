<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'unsatisfiedcustomerview...');

use \Aculab\TelephonyRestAPI\Actions;
use \Aculab\TelephonyRestAPI\Play;
use \Aculab\TelephonyRestAPI\HangUp;

// Reaches here if at the end of the conference it was determined
// that the caller never really spoke with the engineer

$response = new Actions();
$ttsvoice = $GLOBALS['hConfig']->get('ttsVoice');
$response->add(Play::sayText('We are sorry our engineers are busy and will return your call at a later time Goodbye',$ttsvoice));
$response->add(new HangUp());

// log_message('debug', $response);

header("Content-Type: application/json; charset=UTF-8");
print $response;