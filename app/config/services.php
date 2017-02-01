<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => array(
		'domain' => 'sandbox550258daf5204be293a57c1de8d23e7a.mailgun.org',
		'secret' => 'key-a279a42d33dd6d12c26336beb7ec661d',
	),

	'mandrill' => array(
		'secret' => 'OzTow-Tz1Nl7bt8yAFV6sQ',
	),

	'stripe' => array(
		'model'  => 'User',
		'secret' => '',
	),

);
