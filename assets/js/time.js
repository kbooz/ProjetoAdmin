//Relógio

function startTime()
{
	var today=new Date();
	var h=today.getHours();
	var m=today.getMinutes();
	var s=today.getSeconds();
	var d=today.getDate();
	var M=today.getMonth() + 1;
	var y=today.getFullYear();
	m=checkTime(m);
	s=checkTime(s);
	document.getElementById('time').innerHTML=d+"/"+M+"/"+y+" - "+h+":"+m+":"+s;
	t=setTimeout(function(){startTime()},500);
}

function checkTime(i)
{
	if (i<10)
	{
		i="0" + i;
	}
	return i;
}	

startTime();