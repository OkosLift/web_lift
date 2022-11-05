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

        <script type='text/javascript' src = 'liftMove.js'></script>
        <script type='text/javascript' src = 'lift.js'></script> 
        <div style="text-align:center;width:400px;">
            <button onclick="moveTo3()">3. Emeletre</button><br><br>
            <button onclick="moveTo2()">2. Emeletre</button><br><br>
            <button onclick="moveTo1()">1. Emeletre</button><br><br>
            <button onclick="moveTo0()">0. Emeletre</button><br><br>

            <button onclick="selectLift0()">Select 0. lift</button>
            <button onclick="selectLift1()">Select 1. lift</button><br><br>

            <button onclick="callLift3Up()"     >call 3 UP</button>
            <button onclick="callLift3Down()"   >call 3 DOWN</button><br>
            <button onclick="callLift2Up()"     >call 2 UP</button>
            <button onclick="callLift2Down()"   >call 2 DOWN</button><br>
            <button onclick="callLift1Up()"     >call 1 UP</button>
            <button onclick="callLift1Down()"   >call 1 DOWN</button><br>
            <button onclick="callLift0Up()"     >call 0 UP</button>
            <button onclick="callLift0Down()"   >call 0 DOWN</button><br>

            

        </div>
    </body>
</html>
