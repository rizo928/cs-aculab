<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'acknowledgerecordingview...');

use \Aculab\TelephonyRestAPI\Actions;
use \Aculab\TelephonyRestAPI\Play;
use \Aculab\TelephonyRestAPI\Redirect;

$response = new Actions();
$ttsVoice = $GLOBALS['hConfig']->get('ttsVoice');
$response->add(Play::sayText('Thanks for letting us know about your challenges. We will attempt to connect you with one of our engineers.  If you are disconnected, one of our engineers will attempt to contact you at a later time.',$ttsVoice));
$response->add(new Redirect(base_url('handlerecording')));

// log_message('debug', $response);

header("Content-Type: application/json; charset=UTF-8");
print $response;