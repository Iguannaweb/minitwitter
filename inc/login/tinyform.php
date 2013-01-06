	<div style="float: left; width: 370px; position: absolute; margin-top: 5px;*margin-top: 25px; *margin-left: -215px;">
	<select name="service" id="service">
		<option value="tinyurl"><b>Tinyurl!</b></option>
		<option value="isgd"><b>Is.gd!</b></option>
		<option value="zima"><b>Zi.ma!</b></option>
		<option value="unu"><b>U.nu!</b></option>
		</select> 
		<input type="text" name="url" id="url" style="width: 120px;" value="http://www."/ onblur="if (this.value == '') {this.value = 'http://www.';}" onfocus="if (this.value == 'http://www.') {this.value = '';}"/>
		<input type="submit" value="Short URL!" onclick="shorturl(document.getElementById('url').value,document.getElementById('service').value);return false;">
<br>

	</div>