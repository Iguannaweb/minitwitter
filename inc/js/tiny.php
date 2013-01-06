<script>
function loadXmlHttp(url, id) {
var f = this;
f.xmlHttp = null;
if(window.XMLHttpRequest) {
    f.xmlHttp = new XMLHttpRequest();
  }
  else if(window.ActiveXObject) {
    f.xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

if(f.xmlHttp != null){
f.el = document.getElementById(id);
f.xmlHttp.open("GET",url,true);
f.xmlHttp.onreadystatechange = function(){f.stateChanged();};
f.xmlHttp.send(null);
}
}

loadXmlHttp.prototype.stateChanged=function () {
if (this.xmlHttp.readyState == 4 && (this.xmlHttp.status == 200 || !/^http/.test(window.location.href)))
	this.el.innerHTML = this.xmlHttp.responseText;
}

function shorturl(urllarga,service){
new loadXmlHttp('shorturl.php?url=' + urllarga + '&service='+ service,'status');
}
</script>
