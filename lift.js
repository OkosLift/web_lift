
var padlo = 10;
var szint = 50;

var lift = [];
var floor = [];

var kovi = szint + padlo;
var szeles = (szint + 20) * liftszam;

function startLift() {
    for(let i = 0; i<liftszam; i++){
		lift[i] = new component(szint, szint, "red", 10+(2*10+szint)*(i), (emeletszam-1)*kovi);
	}
	
	for(let i = 0; i<emeletszam; i++){
		floor[i] = new component(szeles, padlo, "green", 0, szint);
		szint = szint + kovi;
	}
	
    liftAkna.start();
}

var liftAkna = {
    canvas : document.createElement("canvas"),
    start : function() {
        this.canvas.width = szeles;
        this.canvas.height = emeletszam*kovi;
        this.context = this.canvas.getContext("2d");
        document.body.insertBefore(this.canvas, document.body.childNodes[0]);
        this.interval = setInterval(updateLiftAkna, 20);
		for(let i=0; i<emeletszam; i++){
			floor[i].update();
	    }
		for(let i=0; i<liftszam; i++){
			lift[i].update();
	    }
    },
    clear : function() {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }
}

function component(width, height, color, x, y) {
    this.width = width;
    this.height = height;
    this.speedX = 0;
    this.speedY = 0;
    this.x = x;
    this.y = y;    
    this.update = function() {
        ctx = liftAkna.context;
        ctx.fillStyle = color;
        ctx.fillRect(this.x, this.y, this.width, this.height);
    }
	
    /*this.newPos = function() {
        this.x += this.speedX;
        this.y += this.speedY;        
    }*/
}

function updateLiftAkna() {

    liftAkna.clear();

	for(let i=0; i<liftszam; i++){
		lift[i].update();
		//lift[i].newPos();
	}
	for(let i=0; i<emeletszam; i++){
		floor[i].update();
	}
}




function moveup() {
    for(let i=0; i<liftszam; i++){
		lift[i].y -= kovi;
		//lift[i].speedY -= 1;
	}
    //currentLevel++;
    console.log(currentLevel);
}

function movedown() {
    for(let i=0; i<liftszam; i++){
		lift[i].y += kovi;
		//lift[i].speedY += 1;
	}
    //currentLevel--;
    console.log(currentLevel);
}

/////////////////////////////////////////////

//kiválasztás gombok
var selectedLift = 0;

function selectLift0(){
    selectedLift = 0;
    console.log("Selected lift: " +getSelectedLift());
}

function selectLift1(){
    selectedLift = 1;
    console.log("Selected lift: " +getSelectedLift());
}

function selectLift2(){
    selectedLift = 2;
    console.log("Selected lift: " +getSelectedLift());
}

function selectLift3(){
    selectedLift = 3;
    console.log("Selected lift: " +getSelectedLift());
}


// parancs gombok
async function moveTo0(){

    const level = 0;
    calculateMove(level);
}

async function moveTo1(){

    const level = 1;
    calculateMove(level);
}

async function moveTo2(){

    const level = 2;
    calculateMove(level);
}

async function moveTo3(){

    const level = 3;
    calculateMove(level);
}

async function moveTo4(){

    const level = 4;
    calculateMove(level);
}

async function moveTo5(){

    const level = 5;
    calculateMove(level);
}

async function moveTo6(){

    const level = 6;
    calculateMove(level);
}