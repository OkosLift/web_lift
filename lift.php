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
        //Ali
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
            var door = new Array(liftszam);

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
                    elevator[i] = new component(lift.width, lift.height, "red", lift.padding+(2*lift.padding+lift.width)*i, (emeletszam-1)*level, i);
                    
                    var akt = liftGomb.sorNum-1;
                    for(let j = 0; j<emeletszam; j++){
                        if(j%2==0){
                            elevatorButton[i][j] = new component(liftGomb.width, liftGomb.height, "lime", lift.padding + liftGomb.padding + padlo.width*i,						(emeletszam-1)*level + liftGomb.padding + ((liftGomb.padding + liftGomb.height) * akt), j);
                        }
                        if(j%2==1){
                            elevatorButton[i][j] = new component(liftGomb.width, liftGomb.height, "lime", lift.padding + liftGomb.padding*2 + liftGomb.width + padlo.width*i,	(emeletszam-1)*level + liftGomb.padding + ((liftGomb.padding + liftGomb.height) * akt), j);
                            akt--;
                        }	
                    }
                    door[i] = new component(lift.width, lift.height, "skyblue", lift.padding+(2*lift.padding+lift.width)*i, (emeletszam-1)*level, i);
                }
                
                for(let i = 0; i<emeletszam; i++){
                    floor[i] = new component(padlo.width * liftszam, padlo.height, "green", 0, lift.height + (level*i), "");
                    
                    if(i==0){
                        floorButton[i][0] = new component(emeletGomb.width, emeletGomb.height, "magenta", padlo.width*liftszam, lift.height + (level*i) - emeletGomb.padding - emeletGomb.height, "↓");
                    }else if(i==emeletszam-1){
                            floorButton[i][1] = new component(emeletGomb.width, emeletGomb.height, "magenta", padlo.width*liftszam, lift.height + (level*i) - emeletGomb.padding*2 - emeletGomb.height - emeletGomb.height, "↑");
                            }else{
                                floorButton[i][0] = new component(emeletGomb.width, emeletGomb.height, "magenta", padlo.width*liftszam, lift.height + (level*i) - emeletGomb.padding - emeletGomb.height, "↓");
                                floorButton[i][1] = new component(emeletGomb.width, emeletGomb.height, "magenta", padlo.width*liftszam, lift.height + (level*i) - emeletGomb.padding*2 - emeletGomb.height*2, "↑");
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
                        door[i].update();
                    }
                },

                clear : function() {
                    this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
                }
            };

            function component(width, height, color, x, y, num) {
                this.width = width;
                this.height = height;
                this.speedX = 0;
                this.speedY = 0;
                this.x = x;
                this.y = y;
                this.color = color;
                this.update = function() {
                    ctx = liftAkna.context;
                    ctx.fillStyle = this.color;
                    ctx.fillRect(this.x, this.y, this.width, this.height);
                    ctx.font = "bold 14pt arial";
                    ctx.fillStyle = "black";
                    ctx.fillText(num, this.x+(this.width/2)-5, this.y+(this.height/2)+7);
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
                    //door[i].update();
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

                            if(elevators[i].requestArray.length != 0 || elevators[i].plan.length != 0){ //ideiglenes
                                elevatorButton[i][j].color = "blue";
                                isButtonPushed_global = true;
								//floorButton[emeletszam-1-elevators[i].requestArray[0].initialFloor][elevators[i].requestArray[0].getDirection()].color = "magenta";
								// my time to shine *******************************************************************************************************************
								ButtonInsideLift(i,j);
                            }else
                                console.log("nem hívtad a liftet");
                        }
                    }
                }
                
                // emeletek gombjai
                for(let i=0; i<emeletszam; i++){
                    if(i==0){
                        // legfelso emelet (1 gomb)
                        if (isInsideButton(mousePos, floorButton[i][0])) {
                            floorButton[i][0].color = "pink";
                            liftCall(e-i,0);    //Direction DOWN
                        }
                        //legalso emelet (1 gomb)
                    }else if(i==emeletszam-1){
                        if (isInsideButton(mousePos, floorButton[i][1])) {
                            floorButton[i][1].color = "pink";
                            liftCall(e-i,1);    //Direction UP
                        }
                        }else{
                            //koztes emeletek le/fel gombjai
                            if (isInsideButton(mousePos, floorButton[i][0])) {
                                floorButton[i][0].color = "pink";
                                liftCall(e-i,0);    //Direction DOWN
                            }
                            if (isInsideButton(mousePos, floorButton[i][1])) {
                                floorButton[i][1].color = "pink";
                                liftCall(e-i,1);    //Direction UP
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
                            this.requestArray = [];
                            this.direction = 2;     //0 - DOWN, 1 - UP, 2 or else - IDLE

                            this.plan = [];
                        }

                        reset(){
                            this.direction = 2;
                        }

                        getCurrentFloor(){
                            return this.currentFloor;
                        }

                        addRequest(request){
                            this.requestArray.push(request);
                        }

                        setDirection(){
                            if(this.requestArray[0].initialFloor > this.currentFloor)
                                this.direction = 1;         //UP
                            else if(this.requestArray[0].initialFloor < this.currentFloor)
                                this.direction = 0;         //DOWN
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
                                door[this.ID].y -= level;

                            this.currentFloor++;
                        }

                        moveDown(){         
                            elevator[this.ID].y += level;
                                //elevator[i].speedY -= 1;
                                for(let j=0; j<emeletszam; j++){
                                    elevatorButton[this.ID][j].y += level;
                                }
                                door[this.ID].y += level;

                            this.currentFloor--;
                        }

                        printRequests(){
                            let print = this.ID + ". lift requests: ";
                            print += this.requestArray.toString() + ", ";
                            
                            //console.log(print);
                        }

                    };

                //Request
                    class Request {
                        constructor(floor, dir) {
                            this.initialFloor = floor;
                            this.direction = dir;
                        }

                        initFloorReached(){
                            this.initialFloor = undefined;
                        }

                        isRequestFull(){
                            return isFull;
                        }

                        getDirection(){
                            return this.direction;
                        }

                        toStringDirection(){
                            if(this.direction == 0)
                                return "DOWN";
                            else if(this.direction == 1)
                                return "UP";
                            else
                                return "IDLE";
                        }

                        getFloor(){
                            
                            return this.initialFloor;
                        }

                        toString(){
                            
                            return ( "(" + this.initialFloor + ", " + this.toStringDirection() +
                                       (this.pushedButton == undefined ? "" : ", " + this.pushedButton) + ")"

                            ); 
                            //még a pushedButtonst is add hozzá for ciklussal köszi ;)

                        }
                    };

            //Algoritmus
                function liftCall(level,upOrDown){  //call lift Functionok ide futnak egybe
                    isButtonPushed_global = false;
                    try{
                        generateRequest(upOrDown,level);
                    }catch(globalRequests){
                        DelegateRequest(level,upOrDown);
                    }
                }

                function generateRequest(upOrDown, requestFloorCalled){
                    let newRequest = new Request(requestFloorCalled, upOrDown);
                    globalRequests.push(newRequest);
                    throw globalRequests;
                }
                
                async function DelegateRequest(level,upOrDown){ 
                    do{
                        CalculateRequestWhereToAdd();
                        await delay(liftSpeed);   //lift sebessége
                        
						Ride();     //request algoritmus teszteléshez kommenteld ki
						//floorButton[emeletszam-1-level][upOrDown].color = "magenta";
                    }while(!isButtonPushed_global);
                    //while(getAllRequestFromElevators() > 0);
                }

                function CalculateRequestWhereToAdd(){
                    //ideigelenes teszt Kiiratás
                    let line = "global requestek: ";          
                                for(let i = 0; i < globalRequests.length; i++){
                                    line += globalRequests[i].toString() + ", ";
                                }
                                //console.log(line);
                    //ideigelenes teszt


                    // A MOD KAPCSOLÓVAL LEHET SZABÁLYOZNI HOGY
                    // MILYEN ALGORITMUS ALAPJÁN MŰKÖDJÖN A LIFT
                    // "TEST"       -   Sorban kiosztós algoritmus
                    // "GYUJTO"     -   Gyűjtő algoritmus
                    // "CSAKEGY"    -   csak egy lifthez osztja ki algoritmus
                    // "PONTOZO"    -   Pontozó algoritmus

                    let mod = "PONTOZO";

                    if(mod == "TEST"){
                    //TEST ALGORITMUS
                        for(let i = 0; i< liftszam ; i++){
                            if(globalRequests.length > 0 && !elevators[i].requestArray.length != 0){  //a globálrequest ne legyen üres
                                elevators[i].addRequest(globalRequests[0]);
                                globalRequests.shift();
                                elevators[i].printRequests();
                            }
                        }
                    }   
                    else if(mod == "GYUJTO"){
                    //GYUJTO ALGORITMUS

                        for(let i = 0; i< liftszam ; i++)
                        {
                            if(globalRequests.length > 0)   //a globálrequest ne legyen üres
                            {  
                                if(elevators[i].requestArray.length != 0)   //ha a lift nem szabad
                                {  
                                    if(elevators[i].requestArray[0].direction == globalRequests[0].direction)   
                                    //A lift csak azonos direction-t vehet fel a liftRequestek közé
                                    {
                                        if(elevators[i].direction == 1)    //UP
                                        {
                                            if(elevators[i].requestArray[0].initialFloor > globalRequests[0].initialFloor)   
                                            {
                                                AddRequestToLift(i);
                                            }
                                        }
                                        if(elevators[i].direction == 0)    //DOWN
                                        {
                                            if(elevators[i].requestArray[0].initialFloor < globalRequests[0].initialFloor)
                                            {
                                                AddRequestToLift(i);
                                            }
                                        }
                                    }else   //ha külömbözik a direction akkor a távolságmérést kell szemügyre venni
                                    {

                                    }
                                }else  //ha a lift szabad
                                { 

                                    //console.log("szabad a lift, kiosztok neki feladatot");
                                    AddRequestToLift(i);
                                }
                            }
                        }
                    }
                    else if(mod == "CSAKEGY"){
                        if(globalRequests.length > 0)
                            AddRequestToLift(0);
                    }

                    else if(mod == "PONTOZO"){
                        //EZ EGY OLYAN MÓD LENNE AHOL PONTOKAT SZÁMÍT KI,
                        //AKINEK TÖBB PONTJA VAN AZ KAPJA A REQUESTET
                        if(globalRequests.length > 0)
                        {
                            let points = [];
                            for(let i = 0; i < elevators.length; i++){
                                points[i] = 0;
                            }
    
                            for(let i = 0; i < elevators.length; i++){
                                //lift távolsága az adott hívástól
                                    let distance = getDistance(elevators[i].currentFloor, globalRequests[0].initialFloor);
                                    if(distance < emeletszam * 0.2) //20 % os eltérés
                                    {
                                        //console.log(distance + " < " + emeletszam * 0.2);
                                        points[i] += 9;
                                    }else if(distance < emeletszam * 0.4) //40 % os eltérés
                                    {
                                        //console.log(distance + " < " + emeletszam * 0.4);
                                        points[i] += 7;
                                    }
                                    else if(distance < emeletszam * 0.6) //60 % os eltérés
                                    {
                                        //console.log(distance + " < " + emeletszam * 0.6);
                                        points[i] += 5;
                                    }
                                    else //60% os eltérésnél nagyobb
                                    {
                                        //console.log(distance + " < " + "nagy eltérés");
                                        points[i] += 2;
                                    }
    
                                //Ha a lift szabad
                                    if(elevators[i].requestArray.length == 0)
                                        points[i] += 10;
    
                                //Request direction Up vagy Down
                                    if(elevators[i].requestArray.length != 0){
                                        if(elevators[i].requestArray[0].direction == globalRequests[0].direction)
                                            points[i] += 5;
                                    }
                            }
    
                            //console.log(points);
    
                            const max = Math.max(...points);
                            const index = points.indexOf(max);
                            //console.log(index); // 👉️ 3
    
                            AddRequestToLift(index);

                        }
                    }

                    //console.log("elevators[0] direction: " + elevators[0].direction);
                    //console.log( "global[0] direction: " + globalRequests[0].toString());    //ez mért nem megy?
                }

                function Ride(){
                    for(let i = 0; i< liftszam ; i++){
                        if(elevators[i].requestArray.length != 0){
                            elevators[i].start(elevators[i].requestArray[0].getFloor());
                        }
                        
                    }
                }
                
            //Liften belüli hívás
                async function ButtonInsideLift(i,goTo)
                {
                    //console.log(goTo+" meg színezek is");
                    //megnyomtuk a gombot utána kéne egy kicsit várni hátha még nyomunk rá egyet
                    //floorButton[emeletszam-1-elevators[i].requestArray[0].getFloor()][elevators[i].requestArray[0].getDirection()].color = "magenta";
                
                //összes requestet beletesszük a plan-be
                    elevators[i].plan.push(goTo);
                    elevators[i].requestArray.shift();
                
                    while(elevators[i].requestArray.length > 0)
                    {    
                        elevators[i].plan.push( elevators[i].requestArray[0].initialFloor );
                        elevators[i].requestArray.shift();
                    }
                //sorba rendezés
                    if(elevators[i].direction == 1) // ha felfele megy
                    {
                        elevators[i].plan.sort();       //sorba rendezés növekvő
                    }else          //ha a lift lefelé megy
                    {
                        elevators[i].plan.sort();       //növekvő sorrenbe rendezzük
                        elevators[i].plan.reverse();    //majd megfordítjuk
                    }
                //addíg megy a lift amíg van plan
                    let maxPlanSize = elevators[i].plan.length + 2;

                    while(elevators[i].plan.length > 0){
                        console.log(elevators[i].plan);
                        //console.log(elevators[i].plan);
                        let nextDest = elevators[i].plan[0];

                        while(elevators[i].currentFloor != nextDest){    
                            await delay(liftSpeed);   //lift sebessége
                            elevators[i].start(nextDest);
                        }

                        elevatorButton[i][nextDest].color = "lime";     //gomb visszaszínezése

                        elevator[i].color = "yellow";
                        await delay((maxPlanSize - elevators[i].plan.length) * 3000);   //várakozási idő
                        elevator[i].color = "red";
                        
                        elevators[i].plan.shift();
                        
                    }

                }
                    
            //kis functionok

                function getDistance(liftFloor, callFloor){
                    return Math.abs(liftFloor - callFloor);
                }

                function removeLastChar(string){
                    let result = "";
                    for(let i = 0; i < string.length-1; i++)
                        result += string[i];
                    return result;
                }

                function AddRequestToLift(i){
                    elevators[i].addRequest(globalRequests[0]);
                    globalRequests.shift();
                    elevators[i].setDirection();

                    //request rendezés lift direction alapján
                    if(elevators[i].direction == 1) //ha UP fele megy
                        elevators[i].requestArray.sort((r1, r2) => (r1.initialFloor < r2.initialFloor) ? -1 : (r1.initialFloor > r2.initialFloor) ? 1 : 0);
                    else if(elevators[i].direction == 0) //ha DOWN fele megy
                        elevators[i].requestArray.sort((r1, r2) => (r1.initialFloor < r2.initialFloor) ? 1 : (r1.initialFloor > r2.initialFloor) ? -1 : 0);


                    elevators[i].printRequests();
                }

                function getPushedButtonsLength(lift_id){
                    if(!elevators[lift_id].requestArray.length)
                        return elevators[lift_id].requestArray[0].pushedButtons.length;
                    else 
                        return 0;
                }

                function getAllRequestFromElevators(){
                    let result = 0;
                    for(let i = 0; i< elevators.length; i++){
                        result += elevators[i].requestArray.length;
                    }
                    return result;
                }

                function delay(milliseconds){
                    return new Promise(resolve => {
                        setTimeout(resolve, milliseconds);
                    });
                }

            //main
                var liftSpeed = 600;

                var isButtonPushed_global = false;  //delegateRequest while-ért felel, gombnyomással változik az értéke, azért hogy megállítsuk a ciklust
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
