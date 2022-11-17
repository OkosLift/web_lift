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
		font-family: Monospace;
	}
	
	input[type=number]{
		width: 6em;
	}
	
	.gombok {
		width: 100px;
		text-align: center;
	}
	
	.form {
		width: 250px;
	}
	
	
	
  </style>
 </head>
 <body onload="startLift()" >
  <canvas id="canvas"></canvas>
  <script>

    //hogy gyorsabb legyen tesztelni
	var emeletszam = 5;//<?php echo $_POST["emelet_num"]; ?>;
	var liftszam = 1;//<?php echo $_POST["lift_num"]; ?>;

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
	var szeles = padlo.width * liftszam + emeletGomb.width;

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
	
	
	// itt van minden kattinthato gomb ***********************************************************************************************************************
	
	this.canvas.addEventListener('click', function(evt) {
		var mousePos = getMousePos(this.canvas, evt);
		
		var e = emeletszam-1;
		
		// lifteken beluli gombok
		for(let i=0; i<liftszam; i++){
			for(let j=0; j<emeletszam; j++){
				if (isInsideButton(mousePos, elevatorButton[i][j])) {
					//alert(i+". lift menjen a(z) "+j+". emeletre");

                    if(elevators[i].requestArray.length != 0)
                        ButtonInsideLift(i,j);
                    else
                        console.log("nem hívtad a liftet");
				}
			}
		}
		
		// emeletek gombjai
		for(let i=0; i<emeletszam; i++){
			if(i==0){
				// legfelso emelet (1 gomb)
				if (isInsideButton(mousePos, floorButton[i][0])) {
                    liftCall(e-i,"DOWN");
				}
				//legalso emelet (1 gomb)
			}else if(i==emeletszam-1){
				if (isInsideButton(mousePos, floorButton[i][1])) {
                    liftCall(e-i,"UP");
				}
				}else{
					//koztes emeletek le/fel gombjai
					if (isInsideButton(mousePos, floorButton[i][0])) {
                        liftCall(e-i,"DOWN");
					}
					if (isInsideButton(mousePos, floorButton[i][1])) {
                        liftCall(e-i,"UP");
					}
				}
		}
	});

    //Lehi

    //classok
        //Lift
            class Lift{
                constructor(id){
                    this.ID = id;
                    this.currentFloor = 0;
                    this.isBusy = false;
                    this.requestArray = [];
                    this.direction = 2;     //0 - DOWN, 1 - UP, 2 or else - IDLE
                }

                getBusy(){
                    return this.isBusy;
                }

                getCurrentFloor(){
                    return this.currentFloor;
                }

                addRequest(request){
                    this.requestArray.push(request);

                    //print
                    let println = this.ID + ". Lift requests: "
                    for(let i = 0; i < this.requestArray.length; i++){
                        println += this.requestArray[i].toString();
                    }
                    console.log(println);
                }

                setDirection(){ //ezt itt még át kell gondolni

                    if(this.requestArray.NextFloor() != this.currentFloor){
                        this.direction = this.requestArray.NextDirection(); //legyen UP or DOWN
                    } 
                    else{  
                        this.direction = 2; //IDLE
                        //this.requestArray.PopFront();
                    }
                }

                start(goTo){
                    if(this.currentFloor > goTo)
                        this.moveDown();
                    else if( this.currentFloor < goTo)
                        this.moveUp();
                    else
                        return true;    //odaért

                    return false;   //nem ért oda
                }

                moveUp(){
                        elevator[this.ID].y -= level;
                        //elevator[i].speedY -= 1;
                        for(let j=0; j<emeletszam; j++){
                            elevatorButton[this.ID][j].y -= level;
                        }
                    

                    this.currentFloor++;
                }

                moveDown(){         
                    elevator[this.ID].y += level;
                        //elevator[i].speedY -= 1;
                        for(let j=0; j<emeletszam; j++){
                            elevatorButton[this.ID][j].y += level;
                        }
                    

                    this.currentFloor--;
                }

                printRequests(){
                    for(let i = 0; i < this.requestArray.Size(); i++){
                        this.requestArray.print();
                    }
                }

            };

        //Request
            class Request {
                constructor(floor, dir) {
                    this.initialFloor = floor;
                    this.direction = dir;
                    this.pushedButtons = []; // liften belüli gombnyomások

                }

                getDirection(){
                    return this.direction;
                }

                getFloor(){
                    
                    return this.initialFloor;
                }

                toString(){
                    
                    return ( "(" + this.initialFloor + ", " + this.direction + ")" ); 
                    //még a pushedButtonst is add hozzá for ciklussal köszi ;)

                }
            };

    //Algoritmus

        function liftCall(level,upOrDown){  //call lift Functionok ide futnak egybe
            try{

                console.log("hívás emelet: " + level + ", " + upOrDown);
                generateRequest(upOrDown,level);
            }catch(globalRequests){
                DelegateRequest();
            }
        }

        function generateRequest(upOrDown, requestFloorCalled){
            let newRequest = new Request(requestFloorCalled, upOrDown);
            globalRequests.push(newRequest);
            console.log("new request: " + newRequest.toString());
            throw globalRequests;
        }

        async function DelegateRequest(){ 
            do{

                RequestAddToLift();
                await delay(1000);
                Ride();
            }while(getAllRequestFromElevators() > 0);
        }

        function getAllRequestFromElevators(){
            let result = 0;
            for(let i = 0; i< elevators.length; i++){
                result += elevators[i].requestArray.length;
            }
            return result;
        }

        function RequestAddToLift(){
            //sorba hozzáadjuk a requesteket a liftekhez, 0. req-> 0. lift, 1. req -> 1.lift
            
            
            //ideigelenes teszt
            let line = "global requestek: "
                        
                        for(let i = 0; i < globalRequests.length; i++){
                            line += globalRequests[i].toString() + ", ";
                        }
                        console.log(line);
            //ideigelenes teszt


            for(let i = 0; i< liftszam ; i++){
                if(globalRequests.length > 0){  //a globálrequest ne legyen üres
                    elevators[i].addRequest(globalRequests[0]);
                    globalRequests.shift();
                    elevators[i].isBusy = true; //ha hozzáadtuk a requestet akkor busy legyen
                }
            }
        }

        function Ride(){

            for(let i = 0; i< liftszam ; i++){
                if(elevators[i].requestArray.length != 0){
                    if (elevators[i].start(elevators[i].requestArray[0].getFloor())){
                        //elevators[i].requestArray.shift();   //itt éri el a szintet, kitöröljük a requestjét
                        elevators[i].isBusy = false;            //most már újra elérhető a lift
                    }
                    
                }
                
            }

        }

        function ButtonInsideLift(i,goTo){
            elevators[i].requestArray[0].pushedButtons.push(goTo);

            console.log(i + ". lift, ide kell mennem: " + elevators[i].requestArray[0].pushedButtons[0]);

            while(elevators[i].currentFloor != elevators[i].requestArray[0].pushedButtons[0]){    
                     
                elevators[i].start(elevators[i].requestArray[0].pushedButtons[0]);
            }

            elevators[i].requestArray.shift(); // kitöröljük a requestet a végén

            /*
                try{
                    elevators[i].requestArray[0].pushedButtons.push(goTo);
                    throw goTo;
                }catch(goTo){
                    do{
                        
                        while(elevators[i].currentFloor != elevators[i].requestArray[0].pushedButtons[0]){
                            
                            elevators.getLift(i).start(elevators[i].requestArray[0].pushedButtons[0]);
                        }
                        elevators[i].requestArray[0].pushedButtons.shift();
                        console.log(i + ". lift odaért: " + goTo);

                    }while(elevators[i].requestArray[0].pushedButtons != 0);
                    elevators[i].requestArray.shift();
                }
            */
            

        }


    //kis functionok

        function delay(milliseconds){
            return new Promise(resolve => {
                setTimeout(resolve, milliseconds);
            });
        }

    //main
        var globalRequests = [];
        var elevators = [];

        for(let i = 0; i< liftszam ; i++){
            elevators.push(new Lift(i));
        }

  </script>
  <div class="form">
   <form action="lift.php" method="POST"> 
    <b>Emelet darabszám:</b>
    <input type="number" name="emelet_num" value="<?php echo $_POST["emelet_num"]; ?>" min="1" max="60"></input> <br>
	<b>Lift darabszám:&emsp;&emsp;</b>
    <input type="number" name="lift_num" value="<?php echo $_POST["lift_num"]; ?>" min="1" max="60"></input> <br>
    <div class="gombok">
	<input type="submit" name="insert" value="RAJZOL"></input>
    </div>
   </form>
  </div>
 </body>
</html>
