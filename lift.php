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
            <button onclick="moveup()">FEL</button><br><br>
            <button onclick="movedown()">LE</button>
        </div>
    </body>
</html>
