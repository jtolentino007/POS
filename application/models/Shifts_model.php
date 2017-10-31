<?php
	class Shifts_model extends CORE_Model
	{
		protected $table="shifts";
		protected $pk_id="shifts_id";
		function __construct()
		{
			parent::__construct('');
		}

		function create_default_shift()
		{
	        $sql="INSERT INTO
                  shifts(shifts_id,shift_start,shift_end)
              VALUES
                  (1,'18:00:00','2:00:00')
              ON DUPLICATE KEY UPDATE
                  shifts.shift_start=VALUES(shifts.shift_start),
                  shifts.shift_end=VALUES(shifts.shift_end)
	        ";

	        $this->db->query($sql);

	    }
	}
?>