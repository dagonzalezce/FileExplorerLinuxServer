<?php

	echo '
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="javascript.js?<?php echo time();?>"></script>
	';
 
	include 'listContent.php';

   	$var1= "Uepaje!";


?>

<html>

<head>
	<title>SO Explorador de archivos</title>
</head>

<body>
	<nav class="navbar navbar-dark" style="background-color: #3D3D3D;">
		<div class="input-group mb-3 w-50">
  			<div class="input-group-prepend">
    			<button class="btn btn-dark" style="background-color: #272727;" type="button" id="button-addon1"> < </button>
  			</div>
  			<input type="text" class="form-control" id="inputPath" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" value= <?= $current_path ?>>
  			<div class="input-group-prepend">
    			<button onclick="getFiles();" class="btn btn-dark" style="background-color: #272727;" type="button" id="button-addon1" > Explorar </button>
  			</div>
		</div>
	</nav>

	<section class="d-flex flex-row flex-wrap p-4 text-center" id="filesSection">
		<?php listFolderContent(); ?>
	</section>



<p > <?= $var1 ?> </p>
</body>


</html>