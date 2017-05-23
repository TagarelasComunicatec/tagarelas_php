<?php
namespace AppBundle\Entity;
class Rule {
	
	const ADMIN = "ADMIN";
	const USER = "USER";
	const SUPERUSER = "SUPERUSER";
	const SUCCESS_SAVE= 3;
	const FAIL_SAVE = 4;

	const USER_PENDING  = "USER_PENDING";
	const USER_ACTIVE   = "USER_ACTIVE";
	const USER_CANCELED = "USER_CANCELED";
	const USER_BANNED   = "USER_BANNED";
	const USER_REJECT   = "USER_REJECT";


}