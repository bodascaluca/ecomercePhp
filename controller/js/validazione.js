
let buttonInvia = document.getElementById("btnRegistrati");
buttonInvia.disabled=true;
console.log("Ciao");

let myImg = document.getElementById("myImg");


let inputList = [];


function textValidate(myInput){
    let myInputValue = myInput.value.trim();
    let myInputCheck = document.getElementById(myInput.id + "_check");
    let buttonSignUp = document.getElementById("regidtrationBtn");

    if(myInputValue == undefined || myInputValue == ""){
        myInputCheck.classList.remove("okCheck");
        myInputCheck.classList.add("errorCheck");
        myInputCheck.innerHTML = "Error";
        inputList[myInput.id]=0;
        myImg.src = "./img/ko.jpeg";
    }else{
        myInputCheck.classList.remove("errorCheck");
        myInputCheck.classList.add("okCheck");
        myInputCheck.innerHTML= "Ok";
        inputList[myInput.id]=1;
        if(controlla()){
            myImg.src = "./img/ok.jpeg";
        }
        
    }
    buttonSignUp.disabled = checkAllInput() ? false : true; // Se è vero mi da false e vedro il pulsante

    if(checkAllInput()){
        buttonSignUp.disabled= false;
        myImg.src = "./img/ok.jpeg";

    }else{
        buttonSignUp.disabled= true;
        myImg.src = "./img/ko.jpeg";

    }
}

function emailValidate(myInput){
    let myInputValue = myInput.value.trim();
    let myInputCheck = document.getElementById(myInput.id + "_check");
    let buttonSignUp = document.getElementById("regidtrationBtn");
    let emailRegex= /\S+@\S+\.\S+/;

    if(myInputValue == undefined || myInputValue == "" || !emailRegex.test(myInputValue)){
        myInputCheck.classList.remove("okCheck");
        myInputCheck.classList.add("errorCheck");
        myInputCheck.innerHTML = "Error";
        inputList[myInput.id]=0;
       
    }else{
        myInputCheck.classList.remove("errorCheck");
        myInputCheck.classList.add("okCheck");
        myInputCheck.innerHTML= "Ok";
        inputList[myInput.id]=1;
        if(controlla()){

        }
       
    }
    buttonSignUp.disabled = checkAllInput() ? false : true; 
}

function controlla(){

    let campi=["nome", "cognome", "username","email","pass", "indirizzoDiSpedizione"];
    let numCampi=0; 
    campi.forEach(campo => {
        let dato = document.getElementById(campo).value;
        if(dato!=""){numCampi++;}
    });

    if(numCampi==6){
       buttonInvia.disabled=false; 
    }else{
        buttonInvia.disabled=true;
    }


}

function checkAllInput(){

    //Vammi a prendere tutte le chiavi che ha imputlist   --> Keys è un array di stringhe 
    //                          dimensione massima di questo array 
    if(Object.keys(inputList).length <4){ // se non ho 5 elemnti okay restituisco false
            myImg.src = "./img/ko.jpeg";

        return false;
    }
    //Se sono qua il numero e uguale/maggiore di 4 
    for(let key in inputList){
        if(inputList.hasOwnProperty(key)) //Dentro questo array c'è queasta chiave che si chiama nameid ??
        if(imputList[key]== 0){ //se nome id inputlist è uguale a 0 return false
           // myImg.src = "./img/ko.jpeg";
            return false;
        }
    }
            myImg.src = "./img/ok.jpeg";

    return true; // Se io ritorno true vai hai riga 68
}

function mostra(){

    let myImg = document.getElementById("myImg");
    myImg.src = "./img/ok.jpeg";
}