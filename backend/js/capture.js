function readFile() {
  
  if (this.files && this.files[0]) {
    
    var FR= new FileReader();
    
    FR.addEventListener("load", function(e) {
		
		document.getElementById("dt_filename").value = "Archivo cargado";
		document.getElementById("dt_csv_content").value = e.target.result;
    }); 
    
    FR.readAsDataURL( this.files[0] );
  }
  
}

$(document).ready(function() {

	document.getElementById("dt_csv").addEventListener("change", readFile);

});