<?php

	echo '<link rel="stylesheet" href="styles.css">';

   	$var1= "Uepaje!";

	chdir('/home/david');
	
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

		function __construct($name, $isDirectory){
			$this->name = $name;
			$this->isDirectory = $isDirectory;
		}

		function get_name(){ return $this->name;	}
		function get_is_directory(){ return $this->isDirectory;	}
	}
?>

<html>

<head>
	<title>SO Explorador de archivos</title>
</head>

<body>
	<header >
		<p >Este es el header</p>
	</header>


	<?php foreach($files as $file):?>		
		<div> 
			<p>  <?php echo $file->get_name(); ?> </p>
		</div>
	<?php endforeach; ?>

	<p> <?= $var1 ?> </p>
</body>



</html>
