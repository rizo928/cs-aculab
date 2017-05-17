<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'contactengineerview...');

/* TWILIO CODE

	header("content-type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

<Response>
    <Say>
        Please hold while we attempt to connect you with an engineer.
    </Say>
  <Dial action="http://www.bitrox.io/handleleaveconference" method="POST">
    <Conference 
      startConferenceOnEnter="false" 
      endConferenceOnExit="true"
      waitUrl = 'http://twimlets.com/holdmusic?Bucket=com.twilio.music.ambient'>
      theConferenceID
    </Conference>
  </Dial>
</Response>

?>

*/

use \Aculab\TelephonyRestAPI\InstanceInfo;
use \Aculab\TelephonyRestAPI\Actions;
use \Aculab\TelephonyRestAPI\Play;
use \Aculab\TelephonyRestAPI\Connect;
use \Aculab\TelephonyRestAPI\SecondaryCallConfiguration;

$response = new Actions();
$response->setToken('my instance id');
$ttsvoice = $GLOBALS['hConfig']->get('ttsVoice');
$response->add(Play::sayText('Please hold',$ttsvoice));

$connect = new Connect();
$connect->addDestination($GLOBALS['hConfig']->get('engineerPhone'));
$connect->setCallFrom($GLOBALS['hConfig']->get('callerID'));
$connect->setHoldMedia(Play::playFile('holdmusic.wav'));
$connect->setSecondsAnswerTimeout(30);
$connect->setNextPage(base_url('conferenceended'));

// If we want to do something with the caller immediately after the
// connect has FINISHED - i.e. the engineer hung up.
// $connect->setNextPage('connectNextPage');

$call_config = new SecondaryCallConfiguration();
$call_config->setFirstPage(base_url('greetengineer'));
$connect->setSecondaryCallConfiguration($call_config);

$response->add($connect);

// log_message('debug', $response);

header("Content-Type: application/json; charset=UTF-8");
print $response;