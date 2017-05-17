<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'erejectview...');

use \Aculab\TelephonyRestAPI\Actions;
use \Aculab\TelephonyRestAPI\Play;
use \Aculab\TelephonyRestAPI\HangUp;

$response = new Actions();
$ttsvoice = $GLOBALS['hConfig']->get('ttsVoice');
$response->add(Play::sayText('Sorry for disturbing your golf game Goodbye.',$ttsvoice));
$response->add(new HangUp());

// log_message('debug', $response);

header("Content-Type: application/json; charset=UTF-8");
print $response;