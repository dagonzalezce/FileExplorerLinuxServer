var selectedFileName;

function getFiles(){
	
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

function fileTouched(fileName){
	var fileNameText= "file_name_text_";

	if(selectedFileName!=null){
		document.getElementById(fileNameText.concat(selectedFileName)).style.backgroundColor= "white";
		document.getElementById(fileNameText.concat(selectedFileName)).style.color= "black";
	}

	selectedFileName= fileName;

	

	document.getElementById(fileNameText.concat(fileName)).style.backgroundColor= "#4A5159";
		document.getElementById(fileNameText.concat(selectedFileName)).style.color= "white";
}