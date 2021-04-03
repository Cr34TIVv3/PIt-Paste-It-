function start() {
    navbarEvent();
    chartGenerator();
}

window.onload = start;


function chartGenerator() {
    e1 = new Element(" Public Pastes", "#417333", "75");
    e2 = new Element(" Private Pastes", "#569944", "100");
    e3 = new Element(" Visitors", "#3B692E", "40");
    elementList = Array();
    elementList.push(e1);
    elementList.push(e2);
    elementList.push(e3);
    createChart(40,40,elementList,80,68);
}

function createChart(marginBot, marginTop, listElements, rectWidth, spacing) {
    var canvas = document.getElementById("myCanvas");
    var can = canvas.getContext("2d");
    var width = canvas.clientWidth;
    var height = canvas.clientHeight;
    
    var maxElement = getMaxElement(listElements);

    var rectHeight = height - marginTop;

    var x = 0 + spacing;
    var y = 0 + marginTop;


    var maxHeight = height - marginTop - marginBot; 
    console.log(maxHeight);

    for(var i=0; i< listElements.length; i++) {
        var percentage = (listElements[i].value * 100) / maxElement.value;
        var currHeight = (percentage * maxHeight) / 100;

        can.fillStyle = "white";
        can.font = "bold 16px Arial";
        can.fillText(listElements[i].value, x, y + (maxHeight - currHeight) - 2);

        can.fillStyle = listElements[i].color;
        can.fillRect(x, y + (maxHeight - currHeight), rectWidth, maxHeight - ( y + (maxHeight - currHeight)) );
        
        can.fillStyle = "white";
        can.font = "bold 16px Arial";
        can.fillText(listElements[i].name, x-10, maxHeight + 20);
        x = x + spacing + rectWidth ;
    }
}

function getMaxElement(listElements) {
    var maxElement = listElements[0];
    for(var i=1; i<listElements.length; i++) {
        if(parseInt(listElements[i].value) > parseInt(maxElement.value)) {
            maxElement = listElements[i];
        }
    }
    return maxElement;
}



class Element {
    constructor(name, color, value) {
        this.name = name;
        this.color = color;
        this.value = value;
    }
}
    // ###############
function navbarEvent() {
    const body = document.querySelector("body");
    const navbar = document.querySelector(".navbar");
    const menuBtn = document.querySelector(".menu-btn");
    const cancelBtn = document.querySelector(".cancel-btn");
    menuBtn.onclick = ()=>{
    navbar.classList.add("show");
    menuBtn.classList.add("hide");
    body.classList.add("disabled");
    }
    cancelBtn.onclick = ()=>{
    body.classList.remove("disabled");
    navbar.classList.remove("show");
    menuBtn.classList.remove("hide");
    }
    window.onscroll = ()=>{
    this.scrollY > 20 ? navbar.classList.add("sticky") : navbar.classList.remove("sticky");
    }
}