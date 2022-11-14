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

        <script type='text/javascript'>
            //globális változókká válnak itt
            var emeletszam = <?php echo $emelet_num; ?>;
            var liftszam = <?php echo $lift_num; ?>;
        </script>

        <script>
            //<script type='text/javascript' src = 'lib1.js'>
            //<script type='text/javascript' src = 'lib2.js'>
            //<script type='text/javascript' src = 'lib3.js'>
            //így kell includeolni annyi js fájlt amennyit akarok
        </script>

        <div style="text-align:center;width:400px;">
            <button id="c4"> Call 4</button><br>
            <button id="c3"> Call 3</button><br>
            <button id="c2"> Call 2</button><br>
            <button id="c1"> Call 1</button><br>
            <button id="c0"> Call 0</button><br><br>
            <button id="start"> Start </button><br>
        </div>

        <script>
        //Button functionok
            const enableButton = (button) => {
                button.disabled = false;
            }

            async function disableButton (button) {
                button.disabled = true;
                await delay(2000);
                enableButton(button);
            };

            function disableButtonForever (button) {
                button.disabled = true;
            };

            function stateHandle(button) {
                console.log("stateHandle");
                if(elevator.getSelectedLiftCurrentLevel() === request.NextFloor()) {
                    enableButton(button);
                } else {
                    disableButtonForever(button);
                }
            }

        //Buttonok
            const button0 = document.getElementById("c0");
            button0.addEventListener("click", callLift0);
            button0.addEventListener("click",async function ()
                {   disableButton(button0);
                });

            const button1 = document.getElementById("c1");
            button1.addEventListener("click", callLift1);
            button1.addEventListener("click",function ()
                { disableButton(button1);
                });

            const button2 = document.getElementById("c2");
            button2.addEventListener("click", callLift2);
            button2.addEventListener("click",function ()
                { disableButton(button2);
                });

            const button3 = document.getElementById("c3");
            button3.addEventListener("click", callLift3);
            button3.addEventListener("click",function ()
                { disableButton(button3);
                });
 
            const button4 = document.getElementById("c4");
            button4.addEventListener("click", callLift4);
            button4.addEventListener("click",function ()
                { disableButton(button4);
                });

            const startButton = document.getElementById("start");
            startButton.addEventListener("click", DelegateRequest);

            /*

            const go0Button =document.getElementById("go0");
            go0Button.addEventListener("click", function(){ liftCall(0,""); });
            
            const go1Button =document.getElementById("go1");
            go1Button.addEventListener("click", function(){ liftCall(1,""); });

            const go2Button =document.getElementById("go2");
            go2Button.addEventListener("click", function(){ liftCall(2,""); });

            const go3Button =document.getElementById("go3");
            go3Button.addEventListener("click", function(){ liftCall(3,""); });

            const go4Button =document.getElementById("go4");
            go4Button.addEventListener("click", function(){ liftCall(4,""); });
            */
            //disableButtonForever(go0Button);
            //disableButtonForever(go1Button);
            //disableButtonForever(go2Button);
            //disableButtonForever(go3Button);
            //disableButtonForever(go4Button);

        //Canva
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



            /*
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
            */
            /////////////////////////////////////////////

        //kiválasztás gombok

        //liften belüli gombok
        //hivás gombok

            function callLift0(){
                liftCall(0,"");
            }

            function callLift1(){
                liftCall(1,"");
            }

            function callLift2(){
                liftCall(2,"");
            }

            function callLift3(){
                liftCall(3,"");
            }

            function callLift4(){
                liftCall(4,"");
            }

        //classok

            class LiftArray{
                constructor(){
                    //belső változók
                    this.myLiftArray = [new Lift(), new Lift()];
                    this.selectedLift = 0;

                    //inicializálás
                    console.log("lift mérete: " + this.myLiftArray.length);
                }

            //függvények
                getSelectedLiftID(){
                    return this.selectedLift;
                }

                getSelectedLift(){

                    return this.myLiftArray[this.selectedLift];
                }
            
                getSelectedLiftCurrentLevel(){
                    return this.getSelectedLift().getCurrentLevel();    //itt mindig 0-át ad vissza,
                }

                selectLift(i){
                    //if (i > liftszam-1)
                    //    i = liftszam-1;

                    this.selectedLift = i;
                }

                getLift(i){
                    return this.myLiftArray[i];
                }

                setSelectedLift(i){
                    //if (i > liftszam-1)
                    //    i = liftszam-1;

                    this.selectedLift = i;
                }

                getCurrentLevelOf(i){
                    return this.myLiftArray[i].getCurrentLevel();
                }

            };

            class Lift{
                constructor(){
                    this.currentLevel = 0;
                    this.isBusy = false;
                }

                getBusy(){
                    return this.isBusy;
                }

                getCurrentLevel(){
                    return this.currentLevel;
                }

            };


            class Request {
                constructor() {
                    this.direction = [];
                    this.initialFloor = [];
                }

                
                Add(direct, initalF) {
                    this.direction.push(direct);
                    this.initialFloor.push(initalF);
                    
                    this.initialFloor.sort();
                    console.log("requests:");
                    this.print();
                }
            

                PopFront(){ //visszaadja és kitörli
                    let dir   = this.direction[0];
                    let floor = this.initialFloor[0];

                    this.direction.shift();
                    this.initialFloor.shift();

                    return floor;
                }

                NextFloor(){
                    return this.initialFloor[0];
                }

                print(){
                    let consoleLog = "Requests: ";
                    for(let i = 0; i < this.direction.length; i++){
                        //console.log(i + ". request: " + getInitialFloor(i) + ", " + this.direction[i] + "\n");
                        consoleLog += this.initialFloor[i] + ", ";
                    }
                    console.log(consoleLog);
                }
            };

        //Algoritmus

            function liftCall(level,upOrDown){  //call lift Functionok ide futnak egybe
                try{
                    generateRequest(upOrDown,level);
                }catch(request){
                    DelegateRequest();
                }
            }

            function generateRequest(upOrDown, requestFloorCalled){
                request.Add(upOrDown,requestFloorCalled);
                throw request;
            }

            async function DelegateRequest(){   //start gombbal indul
                console.log("selected level: "+ elevators.getSelectedLiftCurrentLevel());
                while(request.initialFloor.length > 0){
                    request.print();
                    calculateSelectLift();
                    console.log(elevators.getSelectedLiftID() + ". Lift go to: " + request.NextFloor());
                    await delay(1000);
                    calculateMove(request.NextFloor());
                    if (request.NextFloor() == elevators.getSelectedLiftCurrentLevel()){
                        request.PopFront();
                        break;
                    }  
                     //else 
                        //break;  //itt biztosítjuk hogy minden emelet váltáskor álljon meg
                }
            }

            function calculateSelectLift(){ // ezt kell megoldani
                
                let lowestDistance = emeletszam;
                let destFloor = request.NextFloor();

                for(let i = 0 ; i < lift.length; i++){
                    actualLift = i; 
                    let distance = Math.abs(destFloor - elevators.getCurrentLevelOf(i)); //abszolut érték
                    
                    console.log(actualLift + ". Lift distance to " + destFloor + " is: " + distance);

                    if (distance < lowestDistance){
                        lowestDistance = distance;
                        elevators.setSelectedLift(actualLift);
                    }
                }

                console.log( elevators.getSelectedLiftID() + ". Lift is the nearest!");
            }

            function calculateMove(level){
                while (elevators.getSelectedLiftCurrentLevel() != level){
                    if (elevators.getSelectedLiftCurrentLevel() < level){
                        //felfele megy
                        moveThatLift_UP(elevators.getSelectedLiftID());
                        break;
                    } else if (elevators.getSelectedLiftCurrentLevel() > level){
                        //lefele megy
                        moveThatLift_DOWN(elevators.getSelectedLiftID());
                        break;
                    }
                    
                }
            }

        //kis functionok

            function getLift(i){    //ha túlindexelés van akkor helyre teszi
                if (i >= liftszam)
                    i = liftszam-1;
                else if (i < 0)
                    i = 0;

                return lift[i]; 
            }


            function moveThatLift_UP(i){
                //await delay(100);
                //getLift[i];

                lift[i].y -= kovi;

                elevators.getSelectedLift().currentLevel++;
                //console.log(getCurrentLevel());
            }

            function moveThatLift_DOWN(i){
                //await delay(100);
                //getLift[i];

                lift[i].y += kovi;

                elevators.getSelectedLift().currentLevel--;
                //console.log(getCurrentLevel());
            }


            function delay(milliseconds){
                return new Promise(resolve => {
                    setTimeout(resolve, milliseconds);
                });
            }

        //main
            request = new Request();
            elevators = new LiftArray();

        </script>




        
    </body>
</html>
