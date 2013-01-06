<script language="JavaScript">
var maxwords = <?php echo $numero_caracteres; ?>;

function check_length(){
var status = document.getElementById('status');
var len = status.value.length;

if (len > maxwords) {
status.value = status.value.substr(0,maxchars);
len = maxwords;
}

document.getElementById('wordcount').innerHTML = len;
document.getElementById('remaining').innerHTML = maxwords - len;
}
</script>