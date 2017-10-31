<?php
	defined('BASEPATH') OR die('No direct script access allowed.');

	class Shifts extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
		}
	}
?>