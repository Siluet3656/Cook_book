function readCookie(name) {
    var i, c, ca, nameEQ = name + "=";
    ca = document.cookie.split(';');
    for(i=0;i < ca.length;i++) {
        c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1,c.length);
        }
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length,c.length);
        }
    }
    return '';
}

function deleteAllCookies() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }

    setTimeout(() => { location.reload(); }, 150);
}

function hideNAME() {
     var el = document.getElementsByClassName("name")[0];
         el.style.visibility = 'hidden';
}

function hideREG() {
     var el = document.getElementsByClassName("regiserform")[0];
         el.style.visibility = 'hidden';
}

function visNAME() {
     var el = document.getElementsByClassName("name")[0];
         el.style.visibility = 'visible';
}

function visREG() {
     var el = document.getElementsByClassName("regiserform")[0];
         el.style.visibility = 'visible';
}

function align () {
    var main = document.getElementsByClassName("header")[0];
    var reg = document.getElementsByClassName("regiserform")[0];
    var nam = document.getElementsByClassName("name")[0];
    var hid = document.getElementsByClassName("hiden")[0];
    var alg = '' + window.innerWidth - 40 + 'px';
    main.style.width = alg;
    alg = '' + window.innerWidth - 270 + 'px';
    reg.style.left = alg;
    alg = '' + window.innerWidth - 275 + 'px';
    nam.style.left = alg;
    alg = '' + window.innerWidth/2 - 400 + 'px';
    hid.style.left = alg;
}

window.onload = function() {
    align();
   //Старт сессии
   if (readCookie('session') != '') {
    hideREG();
    visNAME();

        var el = document.getElementsByClassName("hiden")[0];
         el.style.visibility = 'visible';
   } else {
    visREG();
    hideNAME();
   } 
  };

window.addEventListener(`resize`, event => {
  align();
}, false);

function coin () {
    var cho = 0;
    var bet = document.getElementById('bet').value;
   if (document.getElementById('orel').checked)
    cho = 1;
   else if (document.getElementById('reshka').checked)
    cho = 2;
query='bet=' + bet + '&cho=' + cho;
document.getElementById('phpsender').innerHTML = '<img src="/valform/coin.php?' + query +
    ' " '+'border="0" width="1" height="1" />';
     setTimeout(() => { answer(); }, 200);
}

function answer () {
    var answ = readCookie('answer');
    switch (answ) {
        case '0':
        break;
        case '1':
        el = document.getElementById('result');
        el.innerHTML = 'Недостаточно средств!';
        el.style.color = 'red';
        document.cookie = "answer=;max-age=-1";
        break;
        case '2':
        el = document.getElementById('result');
        el.innerHTML = 'Победа!';
        el.style.color = 'green';
        document.cookie = "answer=;max-age=-1";
        break;
        case '3':
        el = document.getElementById('result');
        el.innerHTML = 'Проигрыш!';
        el.style.color = 'red';
        document.cookie = "answer=;max-age=-1";
        break;
    }
    if (document.getElementById('orel').checked && answ == '2')
        document.getElementById('coinimg').src = "/image/ru_orel.png";
    else if (document.getElementById('orel').checked && answ == '3')
        document.getElementById('coinimg').src = "/image/ru_reshka.png";
    else if (document.getElementById('reshka').checked && answ == '2')
        document.getElementById('coinimg').src = "/image/ru_reshka.png";
    else if (document.getElementById('reshka').checked && answ == '3')
        document.getElementById('coinimg').src = "/image/ru_orel.png";
    else
        document.getElementById('coinimg').src = "/image/ru_hz.png";
    if (readCookie('score') != '')
    document.getElementById('score').innerHTML = 'счёт: ' + readCookie('score');
}