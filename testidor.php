<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

include( 'Utils.php' );
include( 'HttpRequest.php' );
include( 'TestIdor.php' );
include( 'TestIdorRequest.php' );


// parse command line
{
	$testidor = new TestIdor();
	$reference = new TestIdorRequest();

	$ssl = false;
	$argc = $_SERVER['argc'] - 1;

	for ($i = 1; $i <= $argc; $i++) {
		switch ($_SERVER['argv'][$i]) {
			case '-cl':
				$reference->setContentLength( true );
				break;

			case '-f':
				$request_file = $_SERVER['argv'][$i + 1];
				$i++;
				break;

			case '-h':
				Utils::help();
				break;

			case '-r':
				$reference->setRedirect( false );
				break;

			case '-s':
				$reference->setSsl( true );
				break;

			case '-t':
				$testidor->setTolerance($_SERVER['argv'][$i + 1]);
				$i++;
				break;

			case '-p':
				$testidor->parsePayloads($_SERVER['argv'][$i + 1]);
				$i++;
				break;

			default:
				Utils::help('Unknown option: '.$_SERVER['argv'][$i]);
		}
	}

	if( !$testidor->getPayloads() ) {
		Utils::help('Payloads not found!');
	}
}
// ---


// init
{
	$testidor->setReference( $reference );

	if( !$reference->loadFile($request_file) ) {
		Utils::help('Request file not found!');
	}

	$testidor->runReference();
}
// ---


// main loop
{
	$testidor->run();
}
// ---


exit();

?>
