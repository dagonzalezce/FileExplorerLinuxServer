<?php

	echo '<link type="text/css" rel="stylesheet" href="styles.css?<?php echo time(); ?>"/>';

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
	<header >
		<p >Este es el header, okey?</p>
	</header>

	<section class="container">
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