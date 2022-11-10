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
            <button id="c3u"> Call 3 UP </button>
            <button id="c3d"> Call 3 DOWN </button><br>
            <button id="c2u"> Call 2 UP </button>
            <button id="c2d"> Call 2 DOWN </button><br>
            <button id="c1u"> Call 1 UP </button>
            <button id="c1d"> Call 1 DOWN </button><br>
            <button id="c0u"> Call 0 UP </button>
            <button id="c0d"> Call 0 DOWN </button><br><br>
            <button id="start"> Start </button>
        </div>

        <script>
        //Button functionok
            function getLiftCurrentLevel(){
                return currentLevel[getSelectedLift()];
            }

            const enableButton = (button) => {
                button.disabled = false;
            }

            async function disableButton (button) {
                button.disabled = true;
                await delay(2000);
                enableButton(button);
            };

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

            const startButton = document.getElementById("start");
            startButton.addEventListener("click", DelegateRequest);





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

        // lift algoritmus

            //classok
            class Request {
                constructor() {
                    this.direction = [];
                    this.initialFloor = [];
                    this.isRequestCompleted = false;
                    console.log("Request létrehozva");
                }

                Add(direct, initalF) {
                    this.direction.push(direct);
                    this.initialFloor.push(initalF);
                }

                Complete(){
                    this.isRequestCompleted = true;
                }

                PopFront(){
                    this.direction.shift();
                    this.initialFloor.shift();
                }

                print(){
                    for(let i = 0; i < this.direction.length; i++){
                        //console.log(i + ". request: " + getInitialFloor(i) + ", " + this.direction[i] + "\n");
                        console.log(i +". Request:  " + this.initialFloor[i] + ", " + this.direction[i]);
                    }
                }
            };
        //Class Request

            //call lift Functionok ide futnak egybe
            function liftCall(level,upOrDown){
                generateRequest(upOrDown,level);
            }

            function generateRequest(upOrDown, requestFloorCalled){

                request.Add(upOrDown,requestFloorCalled);
                console.log("New Request asdasdAdded:\n");
                request.print();

            }


            //LiftMove
            function getLift(i){
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

            function getLiftCurrentLevel(){
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


            function calculateMove(level){
                while (getLiftCurrentLevel() != level){
                    if (getLiftCurrentLevel() < level){
                        //felfele megy
                        moveThatLift_UP(getSelectedLift());
                    } else if (getLiftCurrentLevel() > level){
                        //lefele megy
                        moveThatLift_DOWN(getSelectedLift());
                    }
                    
                }
            }



            function delay(milliseconds){
                return new Promise(resolve => {
                    setTimeout(resolve, milliseconds);
                });
            }

            function calculateSelectLift(){ // ezt kell megoldani
                
                let lowestDistance = emeletszam;

                for(let i = 0 ; i < lift.length; i++){
                    actualLift = i;
                    console.log(i + "= selected lift");
                    let distance = Math.abs(request.initialFloor[0] - currentLevel[i]); //abszolut érték
                    console.log("--------Distance =" + distance);
                    
                    if (distance < lowestDistance){
                        lowestDistance = distance;
                        selectedLift = actualLift;
                        console.log("megvan: " + getSelectedLift());
                    }
                    console.log("--------LowDistance =" + lowestDistance);
                    console.log(i + ".");
                }
            }


            async function DelegateRequest(){
                
                calculateSelectLift();

                while(request.initialFloor.length > 0){
                    console.log("requests:")
                    request.print();
                    console.log("first to do: " + request.initialFloor[0]);
                    await delay(500);
                    calculateMove(request.initialFloor[0]);
                    request.PopFront();
                }
            }




            //main
            request = new Request();





        </script>




        
    </body>
</html>
