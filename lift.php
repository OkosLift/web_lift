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
        
        <script type='text/javascript' src = 'lift.js'>
            //include-oljuk a js file-t amiben már a globális változók elérhetőek
        </script>
        <div style="text-align:center;width:400px;">
            <button onclick="moveTo6()">6. Emeletre</button><br><br>
            <button onclick="moveTo5()">5. Emeletre</button><br><br>
            <button onclick="moveTo4()">4. Emeletre</button><br><br>
            <button onclick="moveTo3()">3. Emeletre</button><br><br>
            <button onclick="moveTo2()">2. Emeletre</button><br><br>
            <button onclick="moveTo1()">1. Emeletre</button><br><br>
            <button onclick="moveTo0()">0. Emeletre</button><br><br>

            <button onclick="selectLift0()">Select 0. lift</button>
            <button onclick="selectLift1()">Select 1. lift</button>
            <button onclick="selectLift2()">Select 2. lift</button>
            <button onclick="selectLift3()">Select 3. lift</button>

        </div>
    </body>
</html>
