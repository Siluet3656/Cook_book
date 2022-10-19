window.onload = function() { 
	intervalId = window.setInterval(function () { align() }, 10);
}

function align () {
	var main = document.getElementsByClassName("main")[0];
	var alg = '' + window.innerWidth/2 - 100 + 'px';
	main.style.left = alg;
}