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
            }
        };


        var path = document.getElementById("inputPath").value;

        xmlhttp.open("GET","listContent.php?path="+path,true);
        xmlhttp.send();
    
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

  	document.getElementById("optionsDiv").style.display = "block";
	document.getElementById(fileNameText.concat(selectedFileName)).style.backgroundColor= "#272727";
	document.getElementById(fileNameText.concat(selectedFileName)).style.color= "white";
}