<!DOCTYPE html>
<html lang = "HU">
 <head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>gombos gombozás</title>
  <style>
	canvas {
		border:1px solid #d3d3d3;
		background-color: #000000;
	}

	body {
		background-color: #1f1f1f;
		color: #ffffff;
	}
  </style>
 </head>
 <body onload="startLift()" >

  <canvas id="canvas"></canvas>
  <script>

	var emeletszam = <?php echo $_POST["emelet_num"]; ?>;
	var liftszam = <?php echo $_POST["lift_num"]; ?>;

	var liftGomb = {
		height: 20,
		width: 20,
		sorNum: Math.ceil(emeletszam/2),
		padding: 10
	};
	
	var emeletGomb = {
		height: 20,
		width: 20,
		padding: 5
	};
	
	var lift = {
		height: (liftGomb.sorNum * (liftGomb.height + liftGomb.padding) + liftGomb.padding),
		width: 2*(liftGomb.width + liftGomb.padding) + liftGomb.padding,
		padding: 10
	};
	
	var padlo = {
		height: 10,
		width: (lift.width + 2*lift.padding)
	};
	
	

	var elevator = new Array(liftszam);
	var floor = new Array(emeletszam);
	
	var elevatorButton = new Array(liftszam);
	for (let i = 0; i < liftszam; i++) {
	  elevatorButton[i] = new Array(emeletszam);
	}
	
	var floorButton = new Array(emeletszam);
	
	
	floorButton[0] = new Array(1);
	floorButton[emeletszam-1] = new Array(1);
	for(let i=1; i<emeletszam-1; i++){
		floorButton[i] = new Array(2);
	}
	
	// egy emelet magassaga
	var level = lift.height + padlo.height;
	
	// az egesz liftakna (canvas) szelessege
	var szeles = (padlo.width + liftGomb.width) * liftszam;

	function startLift() {
		for(let i = 0; i<liftszam; i++){
			elevator[i] = new component(lift.width, lift.height, "red", lift.padding+(2*lift.padding+lift.width)*i, (emeletszam-1)*level);
			
			var akt = liftGomb.sorNum-1;
			for(let j = 0; j<emeletszam; j++){
				if(j%2==0){
					elevatorButton[i][j] = new component(liftGomb.width, liftGomb.height, "lime", lift.padding + liftGomb.padding + padlo.width*i,						(emeletszam-1)*level + liftGomb.padding + ((liftGomb.padding + liftGomb.height) * akt));
				}
				if(j%2==1){
					elevatorButton[i][j] = new component(liftGomb.width, liftGomb.height, "lime", lift.padding + liftGomb.padding*2 + liftGomb.width + padlo.width*i,	(emeletszam-1)*level + liftGomb.padding + ((liftGomb.padding + liftGomb.height) * akt));
					akt--;
				}	
			}
			
		}
		
		for(let i = 0; i<emeletszam; i++){
			floor[i] = new component(padlo.width * liftszam, padlo.height, "green", 0, lift.height + (level*i));
			
			if(i==0){
				floorButton[i][0] = new component(emeletGomb.width, emeletGomb.height, "magenta", padlo.width*liftszam, lift.height + (level*i) - emeletGomb.padding - emeletGomb.height);
			}else if(i==emeletszam-1){
					floorButton[i][1] = new component(emeletGomb.width, emeletGomb.height, "magenta", padlo.width*liftszam, lift.height + (level*i) - emeletGomb.padding*2 - emeletGomb.height - emeletGomb.height);
					}else{
						floorButton[i][0] = new component(emeletGomb.width, emeletGomb.height, "magenta", padlo.width*liftszam, lift.height + (level*i) - emeletGomb.padding - emeletGomb.height);
						floorButton[i][1] = new component(emeletGomb.width, emeletGomb.height, "magenta", padlo.width*liftszam, lift.height + (level*i) - emeletGomb.padding*2 - emeletGomb.height*2);
					}
				
		}
		
		liftAkna.start();
	}

	var liftAkna = {
		canvas : document.getElementById("canvas"),
		start : function() {
			this.canvas.width = szeles;
			this.canvas.height = emeletszam*level;
			this.context = this.canvas.getContext("2d");
			document.body.insertBefore(this.canvas, document.body.childNodes[0]);
			this.interval = setInterval(updateLiftAkna, 20);
			for(let i=0; i<emeletszam; i++){
				floor[i].update();
				
				if(i==0){
					floorButton[i][0].update();
				}else if(i==emeletszam-1){
					floorButton[i][1].update();
					}else{
						floorButton[i][0].update();
						floorButton[i][1].update();
					}
			
			}
			for(let i=0; i<liftszam; i++){
				elevator[i].update();
				for(let j=0; j<emeletszam; j++){
					elevatorButton[i][j].update();
				}
			}
		},

		clear : function() {
			this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
		}
	};

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
			elevator[i].update();
			for(let j=0; j<emeletszam; j++){
				elevatorButton[i][j].update();
			}
			//elevator[i].newPos();
		}
		for(let i=0; i<emeletszam; i++){
			floor[i].update();
			
			if(i==0){
					floorButton[i][0].update();
				}else if(i==emeletszam-1){
					floorButton[i][1].update();
					}else{
						floorButton[i][0].update();
						floorButton[i][1].update();
					}
		}
	}

	function moveup() {
		for(let i=0; i<liftszam; i++){
			elevator[i].y -= level;
			//elevator[i].speedY -= 1;
			for(let j=0; j<emeletszam; j++){
				elevatorButton[i][j].y -= level;
			}
		}
	}

	function movedown() {
		for(let i=0; i<liftszam; i++){
			elevator[i].y += level;
			//elevator[i].speedY += 1;
			for(let j=0; j<emeletszam; j++){
				elevatorButton[i][j].y += level;
			}
		}
			
	}

	function isInsideButton(pos, rect){
		return	pos.x > rect.x && pos.x < rect.x+rect.width &&
				pos.y > rect.y && pos.y < rect.y+rect.height;
	}
		
	function getMousePos(canvas, event) {
		var rect = liftAkna.canvas.getBoundingClientRect();
		return {
			x: event.clientX - rect.left,
			y: event.clientY - rect.top
		};
	}
	
	
	// itt van minden kattintható gomb ***********************************************************************************************************************
	
	this.canvas.addEventListener('click', function(evt) {
		var mousePos = getMousePos(this.canvas, evt);
		
		var e = emeletszam-1;
		
		// lifteken beluli gombok
		for(let i=0; i<liftszam; i++){
			for(let j=0; j<emeletszam; j++){
				if (isInsideButton(mousePos, elevatorButton[i][j])) {
					alert(i+". lift menjen a(z) "+j+". emeletre");
				}
			}
		}
		
		// emeletek gombjai
		for(let i=0; i<emeletszam; i++){
			if(i==0){
					// legfelso emelet (1 gomb)
					if (isInsideButton(mousePos, floorButton[i][0])) {
						alert((e-i)+". emelet liftet vár lefelé");
					}
					//legalso emelet (1 gomb)
				}else if(i==emeletszam-1){
					if (isInsideButton(mousePos, floorButton[i][1])) {
						alert((e-i)+". emelet liftet vár felfelé");
					}
					}else{
						//koztes emeletek le/fel gombjai
						if (isInsideButton(mousePos, floorButton[i][0])) {
							alert((e-i)+". emelet liftet vár lefelé");
						}
						if (isInsideButton(mousePos, floorButton[i][1])) {
							alert((e-i)+". emelet liftet vár felfelé");
						}
					}
		}
	});

  </script>
  <div style="text-align:center;width:200px;">
   <button onclick="moveup()">FEL</button><br><br>
   <button onclick="movedown()">LE</button>
  </div>
  <form action="lift.php" method="POST"> 
    Emelet darabszám:
    <input type="number" name="emelet_num"></input> <br>
	Lift darabszám:
    <input type="number" name="lift_num"></input> <br>
    <input type="submit" name="insert" value="Rajzol"></input>
  </form>
 </body>
</html>
