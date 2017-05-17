<?php defined('BASEPATH') OR exit('No direct script access allowed');
log_message('debug', 'greetengineerview...');

/*  TWILIO CODE

    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Gather action="http://www.bitrox.io/engineerresponse" method="POST">
        <Say>
            Welcome Mr. Fix it.
            Press 1 if you would like to accept a service call.
            Otherwise press 2 or simply hang up.
        </Say>
    </Gather>
    <Say>We didn't receive any input. Goodbye!</Say>
</Response>
*/

use \Aculab\TelephonyRestAPI\InstanceInfo;
use \Aculab\TelephonyRestAPI\Actions;
use \Aculab\TelephonyRestAPI\Play;
use \Aculab\TelephonyRestAPI\RunMenu;
use \Aculab\TelephonyRestAPI\MessageList;

$response = new Actions();
$response->setToken('my instance id');
$ttsvoice = $GLOBALS['hConfig']->get('ttsVoice');
// Create the menu action
$menuPrompt = Play::sayText(
    "Welcome Mr Fix it".
    "Press 1 if you would like to accept a service call" .  
    "Otherwise press 2 or simply hang up",$ttsvoice
);

$menu = new RunMenu($menuPrompt);
$menu->addMenuOption('1', base_url('eaccept'));
$menu->addMenuOption('2', base_url('ereject'));
$menu->setHelpDigit('*');

// Set up some new info messages for digit timeout and invalid digit
$onDigitTimeoutMessages = new MessageList();
$onDigitTimeoutMessages->addMessage(Play::sayText("I didn't catch your entry",$ttsvoice));
$onDigitTimeoutMessages->addMessage(Play::sayText("Please make a choice",$ttsvoice));

// Since we're playing a wave file here, the voice will
// be different than with the TTS
//
// Doing this intentionally just to test out the standard
// playFile function in a place out of the normal call flow.
$onDigitTimeoutMessages->addMessage(Play::playFile("oneMoreTime.wav"));
$menu->setOnDigitTimeoutMessages($onDigitTimeoutMessages);

$onInvalidDigitMessages = new MessageList();
$onInvalidDigitMessages->addMessage(Play::sayText("That wasn't one of the options Please try again",$ttsvoice));

// Same in this case... the voice will be different from the TTS
$onInvalidDigitMessages->addMessage(Play::playFile("oneMoreTime.wav"));
$menu->setOnInvalidDigitMessages($onInvalidDigitMessages);

$response->add($menu);

// log_message('debug', $response);

header("Content-Type: application/json; charset=UTF-8");
print $response;