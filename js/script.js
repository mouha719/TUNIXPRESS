const bar=document.getElementById('bar');
const nav=document.getElementById('navbar');
const close=document.getElementById('close');

if(bar){
        bar.addEventListener('click', () => {
            nav.classList.add('active');
        })
}

if(close){
    close.addEventListener('click', () => {
        nav.classList.remove('active');
    })
}


var Mainimg=document.getElementById("Main");
var simg=document.getElementsByClassName("small-img");
simg[0].onclick=function(){
    Mainimg.src=simg[0].src;
}
simg[1].onclick=function(){
    Mainimg.src=simg[1].src;
}
simg[2].onclick=function(){
    Mainimg.src=simg[2].src;
}
simg[3].onclick=function(){
    Mainimg.src=simg[3].src;
}
    