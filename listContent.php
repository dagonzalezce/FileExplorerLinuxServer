<?php
	
   	$current_path = "/";
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

			$newFile= new File($file, isDirectory($file), $current_path);
			array_push($files, $newFile);

		}



		echo '<div id="current_path" style="display: none;"">'. $current_path .'</div>';
		foreach($files as $file){	
			$name = $file->get_name();
			echo '<div class="fileDiv" id="'.$name.'" onclick="fileTouched('."'".$name."'".');" > 
					<img src= "'. $file->get_icon_name() .'" height="120" width = "120">
					<p class="fileName" id="file_name_text_'.$name.'"> '. $name.'</p>
				</div>';

		
		}



	}

	function get_file($base_path, $name){
		$file = null;

		chdir($base_path);


		exec('ls -l',$searchFileList,$error);

		if($error){		
			echo $error;
			return null;
		}

		foreach ($searchFileList as $line) {
			if (strpos($line, 'total') !== false) { continue;}
			$foundFile= new File($line, isDirectory($line), $base_path);

			if($foundFile->get_name() == $name){
				$file= $foundFile;
			}
		}


		return $file;
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
		public $rename_command;

		function __construct($line, $isDirectory, $father_route){
			//quitar espacios extra
			$line= preg_replace('/\s+/', ' ', $line);
			//separarlo por espacios
			$explodedLine = explode(" ", $line);
			$this->name = $explodedLine[8];
			$this->isDirectory = $isDirectory;
			$this->permissions = str_split($explodedLine[0]);
			$this->father_route = $father_route;

			$this->full_path = $this->get_full_path($this->father_route, $this->name);
			

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

		function get_full_path($basePath, $name){

		    if (substr($basePath , -1) === '/'){

			    return  ($basePath. $name);

			}
		    else{
			    return ($basePath. '/'. $name);
		    }

		}

	    	function rename($new_name){
			//$this->rename_command = 'mv '. $this->full_path. ' '. $this->father_route. $new_name;
			$this->rename_command = 'mv /home/mayra/Documents/hola3.txt /home/mayra/Documents/'. $new_name;

			exec($this->rename_command, $output, $error);
			print_r($error); 

		

		}


	}


//---------------------------------------------------------------------
	if(array_key_exists('requestType', $_POST)){

		$requestType =$_POST['requestType'];

		if($requestType == "listFiles"){
			if (array_key_exists('path', $_POST)) {

		    $path = $_POST['path'];
		    $requestType = ($_POST['requestType']);
		    // do stuff with params
		    listFolderContent($path);			
			}
		}
		else if($requestType == "optionMenuOpenButton"){
			if(array_key_exists('basePath', $_POST) && array_key_exists('name', $_POST)){
				
				$isDirectory = get_file($_POST['basePath'], $_POST['name'])->get_is_directory();

				if($isDirectory){
					echo '<button onclick="openFolder();" class="btn btn-light btn-outline-dark" type="button" id="button-addon1"> Abrir </button>';
				}

				
			}			

		}
	}


?>
