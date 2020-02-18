<?php

	echo '
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="javascript.js?<?php echo time();?>"></script>

	';
 
	include 'listContent.php';

   	$var1 = "Uepaje!";


?>

<html>

<head>
	<title>SO Explorador de archivos</title>
</head>

<body style= "padding-top: 70px;">
	<nav class="navbar navbar-dark fixed-top p-0" style="background-color: #3D3D3D;">
		<div class="w-100">
			<div class="input-group m-3 w-50"  style="display: inline-flex; ">
	  			<div class="input-group-prepend">
	    			<button onclick="getParentFolderFiles();" class="btn btn-dark" style="background-color: #272727;" type="button" id="button-addon1"> < </button>
	  			</div>
	  			<input type="text" class="form-control" id="inputPath" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" value= <?= $current_path ?> autocomplete= off>
	  			<div class="input-group-prepend">
	    			<button onclick="getFiles();" class="btn btn-dark" style="background-color: #272727;" type="button" id="button-addon1" > Explorar </button>
	  			</div>         
			</div>

      <button type="button" class="btn btn-primary btn-outline-light float-right m-3" style="background-color: #E8520C; font-weight: bold;" data-toggle="modal" data-target="#modalCrear" > Crear </button>
		</div>
		<div class ="w-100 mb-1 mt-3 p-1" style="background-color: white; display: none;" id="optionsDiv">
			<div id="openButtonOptionMenuDiv" style="display:inline-block;"> </div>
			<button type="button" class="btn btn-light btn-outline-dark" data-toggle="modal" data-target="#modalRenombrar">
			  Renombrar
			</button>
			<button type="button" class="btn btn-light btn-outline-dark" data-toggle="modal" data-target="#modalEliminar">
			  Eliminar
			</button>
			<button type="button" class="btn btn-light btn-outline-dark" data-toggle="modal" data-target="#modalCopia">
			  Crear copia
			</button>
			<button type="button" class="btn btn-light btn-outline-dark" onclick="getPermissions();">
			  Permisos y propietario
			</button>
			<button type="button" class="btn btn-light btn-outline-dark" data-toggle="modal" data-target="#modalMover">
			  Mover
			</button>
					
		</div>
	</nav>

	<section class="d-flex flex-row flex-wrap p-4 text-center" id="filesSection">
		<?php listFolderContent($current_path); ?>
	</section>

<div id="variableFromPHP" style="display: none;"></div>
<p > <?= $var1 ?> </p>


<!-- Modals -->
<div class="modal fade" id="modalRenombrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Renombrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p> Ingrese el nuevo nombre: </p>
        <input type="text" class="form-control" id="newNameInput">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-outline-dark" data-dismiss="modal">Cerrar</button>
        <button onclick="renameFile();" type="button" class="btn btn-primary btn-outline-light" style="background-color: #E8520C;">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Eliminar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p> ¿Estás seguro de que deseas eliminar este archivo/directorio? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-outline-dark" data-dismiss="modal">Cerrar</button>
        <button onclick="deleteFile();" type="button" class="btn btn-primary btn-outline-light" style="background-color: #E8520C;">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalCopia" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Crear copia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p> Ingrese la dirección del directorio en la que desea copiar este archivo/directorio </p>        
        <input type="text" class="form-control" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-outline-dark" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-outline-light" style="background-color: #E8520C;">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalPermisos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Permisos y propietario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Lectura</th>
		      <th scope="col">Escritura</th>
		      <th scope="col">Ejecución</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <th scope="row">Usuario</th>
		      <td class="text-center" ><input type="checkbox" class="form-check-input" id="ruPermissionCheckBox"></td>
		      <td class="text-center" ><input type="checkbox" class="form-check-input" id="wuPermissionCheckBox"> </td>
		      <td class="text-center" ><input type="checkbox" class="form-check-input" id="xuPermissionCheckBox"></td>
		    </tr>
		    <tr>
		      <th scope="row">Grupo</th>
		      <td class="text-center" ><input type="checkbox" class="form-check-input" id="rgPermissionCheckBox"></td>
		      <td class="text-center" ><input type="checkbox" class="form-check-input" id="wgPermissionCheckBox"></td>
		      <td class="text-center" ><input type="checkbox" class="form-check-input" id="xgPermissionCheckBox"></td>		    
		    </tr>
		    <tr>
		      <th scope="row">Otros</th>
		      <td class="text-center" > <input type="checkbox" class="form-check-input" id="roPermissionCheckBox"></td>
		      <td class="text-center" ><input type="checkbox" class="form-check-input" id="woPermissionCheckBox"></td>
		      <td class="text-center" > <input type="checkbox" class="form-check-input" id="xoPermissionCheckBox"></td>
		    </tr>
		  </tbody>
		</table>

		<p> Usuario propietario </p>
		<input type="text" class="form-control" >
		<p> Grupo propietario </p>
		<input type="text" class="form-control" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-outline-dark" data-dismiss="modal">Cerrar</button>
        <button onclick= "changePermissions();" type="button" class="btn btn-primary btn-outline-light" style="background-color: #E8520C;">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalMover" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Mover</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<p> Ingrese la ruta del directorio al que desea mover este archivo/directorio </p>
        <input type="text" class="form-control" id="newDirectionInput" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-outline-dark" data-dismiss="modal">Cerrar</button>
        <button onclick="moveFile();" type="button" class="btn btn-primary btn-outline-light" style="background-color: #E8520C;">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Crear</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p> Ingrese el nombre: </p>
        <input type="text" class="form-control" id="fileNameCreateInput">
        <p class="mt-3"> Seleccione el tipo: </p>
        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons" >
          <label class="btn btn-secondary active">
            <input type="radio" name="options" id="createFileRadioButton" autocomplete="off" checked> Archivo
          </label>
          <label class="btn btn-secondary">
            <input type="radio" name="options" id="createDirectoryRadioButton" autocomplete="off"> Directorio
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-outline-dark" data-dismiss="modal">Cerrar</button>
        <button onclick="createFile();" type="button" class="btn btn-primary btn-outline-light" style="background-color: #E8520C;">Aceptar</button>
      </div>
    </div>
  </div>
</div>

</body>


</html>
