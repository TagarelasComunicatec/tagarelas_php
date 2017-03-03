<?php
namespace AppBundle\Entity;

interface Rule {
	const ADMIN = "ADMIN";
	const USER = "USER";
	const SUPERUSER = "SUPERUSER";
	const SESSION_PUBLIC = 0;
	const SESSION_PRIVATE = 1;
	
	const SUCCESS_SAVE= 3;
	const FAIL_SAVE = 4;

}