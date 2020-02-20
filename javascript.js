var selectedFileName;

function getFiles(){
	
		document.getElementById("optionsDiv").style.display = "none";
		selectedFileName= null;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("filesSection").innerHTML = this.responseText;
                document.getElementById("inputPath").value= document.getElementById("current_path").innerHTML;
            }
        };


        var requestType = "listFiles";
        var path = document.getElementById("inputPath").value;

        xmlhttp.open("POST", "listContent.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("path=" + path + "&requestType=" + requestType);
    
}

function getParentFolderFiles(){
	var inputPath = document.getElementById("inputPath").value;

	if(inputPath=="/"){
		console.log("Estás en carpeta principal");
		return;
	}

	if((inputPath.length-1) == inputPath.lastIndexOf("/")){
		inputPath= inputPath.substring(0, inputPath.lastIndexOf("/"));
	}

	if(inputPath.lastIndexOf("/") == 0){
		inputPath= "/";
	}else{
		inputPath= inputPath.substring(0, inputPath.lastIndexOf("/"));}

	document.getElementById("inputPath").value = inputPath;
	getFiles();
    
}

function openFolder(){
	if(selectedFileName == null){return;}

	var basePath= document.getElementById("current_path").innerHTML;

	if(basePath.slice(-1) == "/"){
		document.getElementById("inputPath").value = basePath.concat(selectedFileName);
	}else{
		document.getElementById("inputPath").value = basePath.concat("/", selectedFileName);
	}

	getFiles();

}

function fileTouched(fileName){
	var fileNameText= "file_name_text_";

	if(selectedFileName!=null && document.getElementById(fileNameText.concat(selectedFileName))!=null){
		document.getElementById("optionsDiv").style.display = "none";
		document.getElementById(fileNameText.concat(selectedFileName)).style.backgroundColor= "white";
		document.getElementById(fileNameText.concat(selectedFileName)).style.color= "#272727";
	}

	if(fileName.localeCompare(selectedFileName)==0){
		selectedFileName=null;
		return;
	}

	selectedFileName= fileName;

  	openOptionsMenu();
	document.getElementById(fileNameText.concat(selectedFileName)).style.backgroundColor= "#E8520C";
	document.getElementById(fileNameText.concat(selectedFileName)).style.color= "white";
}

function openOptionsMenu(){
	document.getElementById("optionsDiv").style.display = "block";

	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("openButtonOptionMenuDiv").innerHTML = this.responseText;
                document.getElementById("inputPath").value= document.getElementById("current_path").innerHTML;
            }
        };


        var requestType = "optionMenuOpenButton";
        var basePath = document.getElementById("current_path").innerHTML;
        var name = selectedFileName;

        xmlhttp.open("POST", "listContent.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("basePath=" + basePath + "&name=" + name + "&requestType=" + requestType);
}

function renameFile(){
	var newName= document.getElementById("newNameInput").value;

	if(selectedFileName!="" ){
		if(newName){
			if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                getFiles();
					$('#modalRenombrar').modal('hide');
					console.log(this.responseText);
	            }
	        };


	        var requestType = "renameFile";
	        var basePath = document.getElementById("current_path").innerHTML;
	        var name = selectedFileName;

	        xmlhttp.open("POST", "listContent.php", true);
			xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlhttp.send("basePath=" + basePath + "&name=" + name+ "&newName=" + newName + "&requestType=" + requestType);			
			
		}
	}

}


function deleteFile(){

	if(selectedFileName!="" ){
			if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                getFiles();
					$('#modalEliminar').modal('hide');
					console.log(this.responseText);
	            }
	        };


	        var requestType = "deleteFile";
	        var basePath = document.getElementById("current_path").innerHTML;
	        var name = selectedFileName;


	        xmlhttp.open("POST", "listContent.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("basePath=" + basePath + "&name=" + name+ "&requestType=" + requestType);			
		
		
	}       		
			
	
}

function getPermissions(){

	if(selectedFileName!="" ){
			if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {

			document.getElementById("variableFromPHP").innerHTML = this.responseText;


			if(document.getElementById("ruPermission").innerText == '1'){
				document.getElementById("ruPermissionCheckBox").checked = true;
			}else{
				document.getElementById("ruPermissionCheckBox").checked = false;
			}
			if(document.getElementById("wuPermission").innerText  == '1'){
				document.getElementById("wuPermissionCheckBox").checked = true;
			}else{
				document.getElementById("wuPermissionCheckBox").checked = false;
			}
			if(document.getElementById("xuPermission").innerText  == '1'){
				document.getElementById("xuPermissionCheckBox").checked = true;
			}else{
				document.getElementById("xuPermissionCheckBox").checked = false;
			}
			if(document.getElementById("roPermission").innerText  == '1'){
				document.getElementById("roPermissionCheckBox").checked = true;
			}else{
				document.getElementById("roPermissionCheckBox").checked = false;
			}
			if(document.getElementById("woPermission").innerText  == '1'){
				document.getElementById("woPermissionCheckBox").checked = true;
			}else{
				document.getElementById("woPermissionCheckBox").checked = false;
			}
			if(document.getElementById("xoPermission").innerText  == '1'){
				document.getElementById("xoPermissionCheckBox").checked = true;
			}else{
				document.getElementById("xoPermissionCheckBox").checked = false;
			}
			if(document.getElementById("rgPermission").innerText  == '1'){
				document.getElementById("rgPermissionCheckBox").checked = true;
			}else{
				document.getElementById("rgPermissionCheckBox").checked = false;
			}
			if(document.getElementById("wgPermission").innerText  == '1'){
				document.getElementById("wgPermissionCheckBox").checked = true;
			}else{
				document.getElementById("wgPermissionCheckBox").checked = false;
			}
			if(document.getElementById("xgPermission").innerText  == '1'){
				document.getElementById("xgPermissionCheckBox").checked = true;
			}else{
				document.getElementById("xgPermissionCheckBox").checked = false;
			}


			document.getElementById("showOwnerInput").value= document.getElementById("ownerName").innerText;
			document.getElementById("showGroupInput").value= document.getElementById("groupName").innerText;


			$('#modalPermisos').modal('show');
	            }
	        };


	        var requestType = "getPermissions";
	        var basePath = document.getElementById("current_path").innerHTML;
	        var name = selectedFileName;


	        xmlhttp.open("POST", "listContent.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("basePath=" + basePath + "&name=" + name+ "&requestType=" + requestType);			
		
		
	}    
}

function moveFile(){
	var newdirection = document.getElementById("newDirectionInput").value;

	if(selectedFileName!="" ){
		if(newdirection){
			if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                getFiles();
					$('#modalMover').modal('hide');
					console.log(this.responseText);
	            }
	        };


	        var requestType = "moveFile";
	        var basePath = document.getElementById("current_path").innerHTML;
	        var name = selectedFileName;

	        xmlhttp.open("POST", "listContent.php", true);
			xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlhttp.send("basePath=" + basePath + "&name=" + name+ "&newdirection=" + newdirection + "&requestType=" + requestType);			
			
		}
	}

}

function createFile(){
	var createFileName = document.getElementById("fileNameCreateInput").value;

	
	if(createFileName){

		if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                getFiles();
				$('#modalCrear').modal('hide');
				console.log(this.responseText);
            }
        };


        var requestType = "createFile";
        var basePath = document.getElementById("current_path").innerHTML;

        if(document.getElementById("createFileRadioButton").checked){
        	var fileType= "file";
        }else{
        	var fileType= "directory";
        }

        xmlhttp.open("POST", "listContent.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("basePath=" + basePath + "&name=" + createFileName + "&fileType=" + fileType + "&requestType=" + requestType);			
		
	}
	
}

function changePermissions(){

	var permissionsNumber= 0;

	if(document.getElementById("ruPermissionCheckBox").checked) { permissionsNumber += 400;}
	if(document.getElementById("wuPermissionCheckBox").checked) { permissionsNumber += 200;}
	if(document.getElementById("xuPermissionCheckBox").checked) { permissionsNumber += 100;}
	if(document.getElementById("rgPermissionCheckBox").checked) { permissionsNumber += 40;}
	if(document.getElementById("wgPermissionCheckBox").checked) { permissionsNumber += 20;}
	if(document.getElementById("xgPermissionCheckBox").checked) { permissionsNumber += 10;}
	if(document.getElementById("roPermissionCheckBox").checked) { permissionsNumber += 4;}
	if(document.getElementById("woPermissionCheckBox").checked) { permissionsNumber += 2;}
	if(document.getElementById("xoPermissionCheckBox").checked) { permissionsNumber += 1;}


	if(selectedFileName!="" ){
		if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                getFiles();
				$('#modalPermisos').modal('hide');
				console.log(this.responseText);
            }
        };


        var requestType = "changePermissions";
        var basePath = document.getElementById("current_path").innerHTML;
        var name = selectedFileName;

        xmlhttp.open("POST", "listContent.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("basePath=" + basePath + "&name=" + name+ "&permissionsNumber=" + permissionsNumber + "&requestType=" + requestType);			
			
	}
}

function copyFile() {
	var newdirection = document.getElementById("copyPathInput").value;

	if(selectedFileName!="" ){
		if(newdirection){
			if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                getFiles();
					$('#modalCopiar').modal('hide');
					console.log(this.responseText);
	            }
	        };


	        var requestType = "copyFile";
	        var basePath = document.getElementById("current_path").innerHTML;
	        var name = selectedFileName;

	        xmlhttp.open("POST", "listContent.php", true);
			xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlhttp.send("basePath=" + basePath + "&name=" + name+ "&newdirection=" + newdirection + "&requestType=" + requestType);			
			
		}
	}
	
}

function ChangeOwner(){
	console.log("HOLA_VAS_BIEN");
	var changeownergroup = document.getElementById("ownerChangeInput").value;

	
	if(changeownergroup){

		if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                getFiles();
				$('#modalCambiar').modal('hide');
				console.log(this.responseText);
            }
        };


        var requestType = "ChangeOwner";
        var basePath = document.getElementById("current_path").innerHTML;
	console.log("HOLA_VAS_BIEN_2");
        if(document.getElementById("changeownerRadioButton").checked){
        	var changeType= "owner";
		console.log("HOLA_VAS_BIEN_2");
        }else{
		
        	var changeType= "group";
		console.log("HOLA_VAS_BIEN_2");
        }

        xmlhttp.open("POST", "listContent.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("basePath=" + basePath + "&name=" + selectedFileName + "&changeType=" + changeType + "&newOwnerGroup=" + changeownergroup + "&requestType=" + 				requestType);			
		
	}
	
}

