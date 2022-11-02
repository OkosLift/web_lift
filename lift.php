<!DOCTYPE html>
<html>
<head>
<title>open alpha 0.0.3</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<style>
canvas {
    border:1px solid #d3d3d3;
    background-color: #f1f1f1;
}
</style>
</head>
<body onload="startLift()">
<?php
$emelet_num = $_POST["emelet_num"];
$lift_num = $_POST["lift_num"];
?>
<script>

var emeletszam = <?php echo $emelet_num; ?>;
var liftszam = <?php echo $lift_num; ?>;

var padlo = 10;
var szint = 50;

var lift = [];
var floor = [];

var kovi = szint + padlo;
var szeles = (szint + 20) * <?php echo $lift_num; ?>;

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
}

function movedown() {
    for(let i=0; i<liftszam; i++){
		lift[i].y += kovi;
		//lift[i].speedY += 1;
	}
}
</script>
<div style="text-align:center;width:400px;">
  <button onclick="moveup()">FEL</button><br><br>
  <button onclick="movedown()">LE</button>
</div>
</body>
</html>
