<?php
	
   	$current_path;
   	$files = array();

	function listFolderContent($path){
		global $files;
		global $current_path;

		chdir($path);

		$current_path= getcwd();
		
		exec('ls -l',$filesArray,$error);

		if($error){		
			echo $error;
			exit;
		}


		if(count($filesArray) <= 1){
			echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  					Este directorio se encuentra <strong>VACÍO</strong>
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
  					</button>
				   </div>';
			return;
		}


		foreach ($filesArray as $file) {
			if (strpos($file, 'total') !== false) { continue;}

			$newFile= new File($file, isDirectory($file));
			array_push($files, $newFile);

		}


		foreach($files as $file){	
			$name = $file->get_name();
			echo '<div class="fileDiv" id="'.$name.'" onclick="fileTouched('."'".$name."'".');" > 
					<img src= "'. $file->get_icon_name() .'" height="120" width = "120">
					<p class="fileName" id="file_name_text_'.$name.'"> '. $name .'</p>
				</div>';

		
		}



	}

	function get_current_path(){
		return $current_path;
	}

	function isDirectory($line){
		// Si la línea empieza con d, es directorio. Si empieza con -, es archivo
		if(strpos($line, 'd') === 0){
			return true;
		}

		return false;

	}
	//----------------------------------------------


	class File{
		public $name;
		public $isDirectory;
		public $permissions;
		public $full_path;
		public $father_route;

		function __construct($line, $isDirectory, $father_route){
			//quitar espacios extra
			$line= preg_replace('/\s+/', ' ', $line);
			//separarlo por espacios
			$explodedLine = explode(" ", $line);
			$this->name = $explodedLine[8];
			$this->isDirectory = $isDirectory;
			$this->permissions = str_split($explodedLine[0]);
			$this->father_route = $father_route;
			

			if (substr($father_route , -1) === '/'){

			    $this->full_path = $father_route. $this->name;

			}
			else{
			    $this->full_path = $father_route. '/'. $this->name;
			}
			
			 
		}

		function get_name(){ return $this->name;	}
		function get_is_directory(){ return $this->isDirectory;	}
		function get_icon_name(){ 
			if($this->isDirectory){
				return "folderIcon.png";
			}else{
				return "fileIcon.png";
			}
		}
		function check_permissions($index, $letter){
			if (strcmp($this->permission[$index], $letter) === 0){
				return True;
			}
			else{
				return False;
			}
		}
		function route(){ return $this->full_path;	}

	}

	if (isset($_GET['path'])) { 
		$current_path= $_GET['path'];
		listFolderContent();
	 }



?>
