<?php
namespace App;

	class DB 
	{
		const HOST = "localhost";
		const USER = "root";
		const PASS = "";
		const DB   = "test";

		function connect()
		{
			$con = mysqli_connect(Self::HOST,Self::USER,Self::PASS,Self::DB);
			if(!$con)
			{
				echo "DB connection error";
				exit();
			}
			return $con;
		}
	}	
?>