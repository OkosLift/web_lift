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
            <button id="c4u"> Call 4 UP </button>
            <button id="c4d"> Call 4 DOWN </button><br>
            <button id="c3u"> Call 3 UP </button>
            <button id="c3d"> Call 3 DOWN </button><br>
            <button id="c2u"> Call 2 UP </button>
            <button id="c2d"> Call 2 DOWN </button><br>
            <button id="c1u"> Call 1 UP </button>
            <button id="c1d"> Call 1 DOWN </button><br>
            <button id="c0u"> Call 0 UP </button>
            <button id="c0d"> Call 0 DOWN </button><br><br>
            <button id="start"> Start </button><br><br>
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
                if(getLiftCurrentLevel() === request.NextFloor()) {
                    enableButton(button);
                } else {
                    disableButtonForever(button);
                }
            }

        //Buttonok
            const button0 = document.getElementById("c0u");
            button0.addEventListener("click", callLift0Up);
            button0.addEventListener("click",async function ()
                {   disableButton(button0);
                });

            const button1 = document.getElementById("c0d");
            button1.addEventListener("click", callLift0Down);
            button1.addEventListener("click",function ()
            { disableButton(button1);
            });

            const button2 = document.getElementById("c1u");
            button2.addEventListener("click", callLift1Up);
            button2.addEventListener("click",function ()
                { disableButton(button2);
                });

            const button3 = document.getElementById("c1d");
            button3.addEventListener("click", callLift1Down);
            button3.addEventListener("click",function ()
                { disableButton(button3);
                });

            const button4 = document.getElementById("c2u");
            button4.addEventListener("click", callLift2Up);
            button4.addEventListener("click",function ()
                { disableButton(button4);
                });

            const button5 = document.getElementById("c2d");
            button5.addEventListener("click", callLift2Down);
            button5.addEventListener("click",function ()
                { disableButton(button5);
                });

            const button6 = document.getElementById("c3u");
            button6.addEventListener("click", callLift3Up);
            button6.addEventListener("click",function ()
                { disableButton(button6);
                });

            const button7 = document.getElementById("c3d");
            button7.addEventListener("click", callLift3Down);
            button7.addEventListener("click",function ()
                { disableButton(button7);
                });
            
            const button8 = document.getElementById("c4u");
            button8.addEventListener("click", callLift4Up);
            button8.addEventListener("click",function ()
                { disableButton(button8);
                });

            const button9 = document.getElementById("c4d");
            button9.addEventListener("click", callLift4Down);
            button9.addEventListener("click",function ()
                { disableButton(button9);
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
            var selectedLift = 0;   //max liftszám-1 

        //liften belüli gombok
        //hivás gombok

            function callLift0Up(){
                liftCall(0,"up");
            }

            function callLift0Down(){
                liftCall(0,"down");
            }

            function callLift1Up(){
                liftCall(1,"up");
            }

            function callLift1Down(){
                liftCall(1,"down");
            }

            function callLift2Up(){
                liftCall(2,"up");
            }

            function callLift2Down(){
                liftCall(2,"down");
            }

            function callLift3Up(){
                liftCall(3,"up");
            }

            function callLift3Down(){
                liftCall(3,"down");
            }

            function callLift4Up(){
                liftCall(4,"up");
            }

            function callLift4Down(){
                liftCall(4,"down");
            }

            function callLift5Up(){
                liftCall(5,"up");
            }

            function callLift5Down(){
                liftCall(5,"down");
            }

        //classok
            class Request {
                constructor() {
                    this.direction = [];
                    this.initialFloor = [];
                    this.isRequestCompleted = false;
                }

                
                Add(direct, initalF) {
                    this.direction.push(direct);
                    this.initialFloor.push(initalF);
                    
                    this.initialFloor.sort();
                    console.log("requests:");
                    this.print();
                }
                
                Complete(){
                    this.isRequestCompleted = true;
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
                generateRequest(upOrDown,level);
            }

            function generateRequest(upOrDown, requestFloorCalled){

                request.Add(upOrDown,requestFloorCalled);
            }

            async function DelegateRequest(){   //start gombbal indul

                while(request.initialFloor.length > 0){
                    request.print();
                    calculateSelectLift();
                    console.log(getSelectedLift() + ". Lift go to: " + request.NextFloor());
                    await delay(500);
                    calculateMove(request.NextFloor());
                    if (request.NextFloor() == getLiftCurrentLevel()){
                        request.PopFront();
                        break;
                    }  
                    else 
                        break;  //itt biztosítjuk hogy minden emelet váltáskor álljon meg
                }
            }

            function calculateSelectLift(){ // ezt kell megoldani
                
                let lowestDistance = emeletszam;
                let destFloor = request.NextFloor();

                for(let i = 0 ; i < lift.length; i++){
                    actualLift = i; 
                    let distance = Math.abs(destFloor - currentLevel[i]); //abszolut érték
                    
                    //console.log(actualLift + ". Lift distance to " + destFloor + " is: " + distance);

                    if (distance < lowestDistance){
                        lowestDistance = distance;
                        selectedLift = actualLift;
                    }
                }

                //console.log( getSelectedLift() + ". Lift is the nearest!");
            }

            function calculateMove(level){
                while (getLiftCurrentLevel() != level){
                    if (getLiftCurrentLevel() < level){
                        //felfele megy
                        moveThatLift_UP(getSelectedLift());
                        break;
                    } else if (getLiftCurrentLevel() > level){
                        //lefele megy
                        moveThatLift_DOWN(getSelectedLift());
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


            function getSelectedLift(){
                return selectedLift;
            }


            var currentLevel = [0, 0, 0, 0];

            function getLiftCurrentLevel(){ //selectedLift aktuális szintje
                return currentLevel[getSelectedLift()];
            }


            function moveThatLift_UP(i){
                //await delay(100);
                getLift[i];

                lift[i].y -= kovi;

                currentLevel[getSelectedLift()]++;
                //console.log(getCurrentLevel());
            }

            function moveThatLift_DOWN(i){
                //await delay(100);
                getLift[i];

                lift[i].y += kovi;

                currentLevel[getSelectedLift()]--;
                //console.log(getCurrentLevel());
            }


            

            function getLiftCurrentLevel(){
                return currentLevel[getSelectedLift()];
            }

            function delay(milliseconds){
                return new Promise(resolve => {
                    setTimeout(resolve, milliseconds);
                });
            }

        //main
            request = new Request();

        </script>




        
    </body>
</html>
