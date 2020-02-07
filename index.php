<?php

	echo '<link rel="stylesheet" href="styles.css">';

	$var1= "Uepaje!";

	chdir('/home/david');
	exec('ls -l',$filesArray,$error);

	if($error){		
		echo "Error : $error<BR>n";
		exit;
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


	<?php foreach($filesArray as $file):?>
		<?php if(!(strpos($file, 'total') !== false)): ?>		<li> <?php echo $file ?> </li>
		<?php endif; ?>
	<?php endforeach; ?>

	<p> <?= $var1 ?> </p>
</body>



</html>