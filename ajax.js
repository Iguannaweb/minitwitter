//Browser Support Code
function ajaxFunction(acortador){
 var ajaxRequest;  // The variable that makes Ajax possible!
 //var accion;
 //var id_sinonimo;
 //var id_spp;
 //var nombre;
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
 // Create a function that will receive data 
 // sent from the server and will update
 // div section in the same page.
 ajaxRequest.onreadystatechange = function(){
 
   if(ajaxRequest.readyState == 4){
      var ajaxDisplay = document.getElementById('status');
      ajaxDisplay.innerHTML = ajaxRequest.responseText;
   }
 }
 // Now get the value from user and pass it to
 // server script.
 if(acortador=="tinyurl"){
 var Web = "http://tinyurl.com/api-create.php";
 }
 var queryString = "?url=" + url;
 ajaxRequest.open("GET", Web + queryString, true);

 ajaxRequest.send(null); 


}

