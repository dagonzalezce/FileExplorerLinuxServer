<?php
	
	$required_path= "/home/david";
   	$current_path =  $required_path;
   	$files = array();

	function listFolderContent($path){
		global $files;
		global $current_path;
		global $required_path;

		chdir($path);

		$current_path= getcwd();

		if(strpos($current_path, $required_path) !== 0){
			chdir($required_path);

		}

		$current_path= getcwd();
		
		exec('ls -l',$filesArray,$error);

		echo '<div id="current_path" style="display: none;"">'. $current_path .'</div>';

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
		public $owner;   #variable para propietario
		public $group;   #variable para grupo
		public $move_command;  #variable para el comando de mover

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
			if (strcmp($this->permissions[$index], $letter) === 0){
				return 1;
			}
			else{
				return 0;
			}
		}
		
		function get_owner(){return $this->owner;}   #función para ver el propietario del archivo
		
	    	function get_group(){return $this->group;}   #función para ver el grupo al cual pertenece el archivo

		function get_full_path($basePath, $name){

		    if (substr($basePath , -1) === '/'){

			    return  ($basePath. $name);

			}
		    else{
			    return ($basePath. '/'. $name);
		    }

		}

	    function rename($new_name){
			
			$this->rename_command = 'mv '. $this->full_path. ' '. $this->get_full_path($this->father_route,$new_name);

			exec($this->rename_command, $output, $error);		

		}

	    function delete(){
			if($this->isDirectory){
			$this->delete_command= 'rm -R '. $this->full_path;}
			else{$this->delete_command= 'rm '. $this->full_path;}
			exec($this->delete_command);

		}
		
	#intento de funcion  para mover los archivos	
	    function move($new_direction){
			$this->move_command = 'mv '. $this->full_path. ' '. $this->get_full_path($new_direction, $this->name);
			exec($this->move_command, $output, $error );

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
		else if($requestType == "renameFile"){
			if(array_key_exists('basePath', $_POST)  && array_key_exists('name', $_POST) && array_key_exists('newName', $_POST)){
				
				$fileToRename = get_file($_POST['basePath'], $_POST['name']);
				$fileToRename->rename($_POST['newName']);
				
			}			

		}
		
		else if($requestType == "deleteFile"){
			if(array_key_exists('basePath', $_POST)  && array_key_exists('name', $_POST) ){
				$fileToDelete = get_file($_POST['basePath'], $_POST['name']);
				$fileToDelete->delete();
				
			}			

		}
		
		else if($requestType == "getPermissions"){
			if(array_key_exists('basePath', $_POST)  && array_key_exists('name', $_POST) ){
				$fileWithPermissions = get_file($_POST['basePath'], $_POST['name']);
				echo '<div id="ruPermission">'. $fileWithPermissions->check_permissions(1,'r') .'</div>';
				echo '<div id="wuPermission">'. $fileWithPermissions->check_permissions(2,'w') .'</div>';
				echo '<div id="xuPermission">'. $fileWithPermissions->check_permissions(3,'x') .'</div>';
				echo '<div id="rgPermission">'. $fileWithPermissions->check_permissions(4,'r') .'</div>';
				echo '<div id="wgPermission">'. $fileWithPermissions->check_permissions(5,'w') .'</div>';
				echo '<div id="xgPermission">'. $fileWithPermissions->check_permissions(6,'x') .'</div>';
				echo '<div id="roPermission">'. $fileWithPermissions->check_permissions(7,'r') .'</div>';
				echo '<div id="woPermission">'. $fileWithPermissions->check_permissions(8,'w') .'</div>';
				echo '<div id="xoPermission">'. $fileWithPermissions->check_permissions(9,'x') .'</div>';
				
			}			

		}
		else if($requestType == "moveFile"){
			if(array_key_exists('basePath', $_POST)  && array_key_exists('name', $_POST) && array_key_exists('newdirection', $_POST)){
				
				$fileToMove = get_file($_POST['basePath'], $_POST['name']);
				$fileToMove->move($_POST['newdirection']);
				
			}			

		}
		else if($requestType == "createFile"){
			if(array_key_exists('basePath', $_POST)  && array_key_exists('name', $_POST)  && array_key_exists('fileType', $_POST)){

				$create_full_path= $_POST['basePath'];

				if (substr($create_full_path , -1) === '/'){
			 	   $create_full_path =  ($create_full_path. $_POST['name']);
				}	
		    	else{
			    	$create_full_path = ($create_full_path. '/'.  $_POST['name']);
		    	}

		    	$create_command= "touch ".$create_full_path;

				if(strcmp($_POST['fileType'], "file" ) !== 0){
					$create_command= "mkdir ".$create_full_path;
				}

				echo $create_full_path;

				exec($create_command);
			}			

		}

	}


?>
