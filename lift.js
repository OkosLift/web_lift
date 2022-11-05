
var emeletszam = 4;
var liftszam = 1;

var padlo = 10;
var szint = 50;

var lift = [];
var floor = [];

var kovi = szint + padlo;
var szeles = (szint + 20) * liftszam;

var button1;
var button2;
var button3;
var button4;



function startLift() {
    for(let i = 0; i<liftszam; i++){
		lift[i] = new component(szint, szint, "red", 10+(2*10+szint)*(i), (emeletszam-1)*kovi);
	}
	
	for(let i = 0; i<emeletszam; i++){
		floor[i] = new component(szeles, padlo, "green", 0, szint);
		szint = szint + kovi;
	}
	
	button1 = new component(40,40,"lime",95,10);
	button2 = new component(40,40,"lime",95,70);
	button3 = new component(40,40,"lime",95,130);
	button4 = new component(40,40,"lime",95,190);
	
    liftAkna.start();
}

var liftAkna = {
    canvas : document.getElementById("canvas"),
    start : function() {
        this.canvas.width = szeles+100;
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
		button1.update();
		button2.update();
		button3.update();
		button4.update();
	
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
	button1.update();
	button2.update();
	button3.update();
	button4.update();
	
	this.canvas.addEventListener('click', function(evt) {
		var mousePos = getMousePos(this.canvas, evt);
		if (isInsideButton(mousePos, button1)) {
			alert("1");
		}
		if (isInsideButton(mousePos, button2)) {
			alert("2");
		}
		if (isInsideButton(mousePos, button3)) {
			alert("3");
		}
		if (isInsideButton(mousePos, button4)) {
			alert("4");
		}
	});
}

function moveup() {
    for(let i=0; i<liftszam; i++){
		lift[i].y -= kovi;
		//lift[i].speedY -= 1;
	}
}

function movedown() {
    for(let i=0; i<liftszam; i++){
		lift[i].y += kovi;
		//lift[i].speedY += 1;
	}
		
}


// Ezt skubizzad Lehi

function isInsideButton(pos, rect){
			return pos.x > rect.x && pos.x < rect.x+rect.width &&
				   pos.y > rect.y && pos.y < rect.y+rect.height
}
	
function getMousePos(canvas, event) {
		var rect = canvas.getBoundingClientRect();
		return {
			x: event.clientX - rect.left,
			y: event.clientY - rect.top
		};
}

//Ez kell majd neked, alertek helyett függvényeket hívogatni

canvas.addEventListener('click', function(evt) {
	var mousePos = getMousePos(canvas, evt);
	if (isInsideButton(mousePos, button1)) {
		alert("1");
	}
	if (isInsideButton(mousePos, button2)) {
		alert("2");
	}
	if (isInsideButton(mousePos, button3)) {
		alert("3");
	}
	if (isInsideButton(mousePos, button4)) {
		alert("4");
	}
});

