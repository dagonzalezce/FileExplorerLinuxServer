<?php

	echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">';

   	$var1= "Uepaje!";

	chdir('/');
	
	//----------------------- Listar archivos
	exec('ls -l',$filesArray,$error);

	if($error){		
		echo "Error : $error<BR>n";
		exit;
	}

	$files = array();

	foreach ($filesArray as $file) {
		if (strpos($file, 'total') !== false) { continue;}

		$newFile= new File($file, isDirectory($file));
		array_push($files, $newFile);
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

		function __construct($line, $isDirectory){
			//quitar espacios extra
			$line= preg_replace('/\s+/', ' ', $line);
			//separarlo por espacios
			$explodedLine = explode(" ", $line);
			$this->name = $explodedLine[8];
			$this->isDirectory = $isDirectory;
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
	}
?>

<html>

<head>
	<title>SO Explorador de archivos</title>
</head>

<body>
	<nav class="navbar navbar-dark" style="background-color: #4A5159;">
		<div class="input-group mb-3 w-50">
  			<div class="input-group-prepend">
    			<button class="btn btn-outline-light btn-dark" style="background-color: #4A5159;" type="button" id="button-addon1"> < </button>
  			</div>
  			<input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
  			<div class="input-group-prepend">
    			<button class="btn btn-outline-light btn-dark" style="background-color: #4A5159;" type="button" id="button-addon1"> Explorar </button>
  			</div>
		</div>
	</nav>

	<section class="d-flex flex-row flex-wrap p-4">
		<?php foreach($files as $file):?>		
			<div class="fileDiv"> 
				<img src= <?php echo $file->get_icon_name(); ?> height="120" width = "120">
				<p class="fileName">  <?php echo $file->get_name(); ?> </p>
			</div>
		<?php endforeach; ?>
	</section>

	<p > <?= $var1 ?> </p>
</body>


</html>