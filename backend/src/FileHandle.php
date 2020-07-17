<?php 
	namespace App;
	use App\DB;

	class FileHandle extends DB{

	
		private $basepath = "http://localhost/image-gallery/backend/gallery/";

		function __construct()
		{
			
		}

		function getAll()
		{
			$q = "SELECT id,file_url,created_at FROM gallery ORDER BY id DESC";
			$run = mysqli_query($this->connect(),$q);
			if(mysqli_num_rows($run)>0)
			{
				return $run;
			}
			return false;
		}		

		function getOne()
		{
			$q = "SELECT id,file_url,created_at FROM gallery ORDER BY id DESC LIMIT 1";
			$run = mysqli_query($this->connect(),$q);
			if(mysqli_num_rows($run)>0)
			{
				return $run;
			}
			return false;
		}

		function save(string $fileName):bool
		{
			
			$post = [
				'file_name'=> $fileName,
				'file_url'=> $this->basepath.$fileName
			];

			return $this->insert($post) ? true : false;
		}

		function insert(array $post):bool
		{
			$q = "INSERT INTO gallery (file_name,file_url) VALUES ('".$post['file_name']."','".$post['file_url']."')";
			$run = mysqli_query($this->connect(),$q);

			return $run ? true : false;
		}
	}
?>