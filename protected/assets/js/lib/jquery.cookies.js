/* Global variable */
var today = new Date();
var expiry = new Date(today.getTime() + 30 * 24 * 3600 * 1000);
function setCookie1(name,value,days)
{
	if (days){
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}
function getCookie1(name) 
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++)
	{
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
/* Function */	
//function setCookie(name,value,days)
//{
//    value=encodeURIComponent(value);
//	if (days){
//		var date = new Date();
//		date.setTime(date.getTime()+(days*24*60*60*1000));
//		var expires = "; expires="+date.toGMTString();
//	}
//	else var expires = "";
//	document.cookie = name+"="+value+expires+"; path=/";
//}

//function getCookie(name) 
//{
//	var nameEQ = name + "=";
//	var ca = document.cookie.split(';');
//	for(var i=0;i < ca.length;i++)
//	{
//		var c = ca[i];
//		while (c.charAt(0)==' ') c = c.substring(1,c.length);
//		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
//	}
//	return null;
//}
function setCookie(c_name,value)
{
    var exdays=10;
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
document.cookie=c_name + "=" + c_value+"; path=/";
}
function getCookie(c_name)
{
var c_value = document.cookie;
var c_start = c_value.indexOf(" " + c_name + "=");
if (c_start == -1)
  {
  c_start = c_value.indexOf(c_name + "=");
  }
if (c_start == -1)
  {
  c_value = null;
  }
else
  {
  c_start = c_value.indexOf("=", c_start) + 1;
  var c_end = c_value.indexOf(";", c_start);
  if (c_end == -1)
  {
c_end = c_value.length;
}
c_value = unescape(c_value.substring(c_start,c_end));
}
return c_value;
}
function deleteCookies(name)
{
	document.cookie=name + "=null; path=/; expires= -1";
}

