
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Beyond Reality | Immersive Hub</title>

        <link rel="stylesheet" type="text/css" href="css/hubstyle.css">
        <link rel="stylesheet" type="text/css" href="css/options.css">
        <style>
            html, body {
                overflow: hidden;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }

            #renderCanvas {
                width: 100%;
                height: 100%;
                touch-action: none;
            }
        </style>

        <script src="babylon.max.js"></script>
        <script src="https://cdn.babylonjs.com/babylon.js"></script>
        <script src="https://cdn.babylonjs.com/loaders/babylonjs.loaders.min.js"></script>
        <script src="https://preview.babylonjs.com/babylon.js"></script>
        <script src="https://preview.babylonjs.com/loaders/babylonjs.loaders.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    </head>
    <body>
      <?php
      if(!isset($_SESSION))
        session_start()
      ?>
    <div class="avatar"></div>
    <nav>
         <p>Immersive Hub</p>
         <ul>
       <li><a href="#">Options</a>
        <ul>
           <li><button id="save">Save&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></li><br> 
           <li><button id="import" onclick="window.location.href='../html/upload_asset.html';">Import&nbsp;&nbsp;&nbsp;</button></li><br>
           <li><button type = "button" id="edit" onclick=edit()>Edit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></li>
           <li><button id="help">Help&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></li><br>
        </ul>
     </li>
     <li><a href="#" >&nbsp;&nbsp;</a></li>
     <li><a href="#">Menu</a>
        <ul>
           <li><a href="../html/about.html">About us&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
           <?php
           if(isset($_SESSION['user'])){
            echo "<li><a href='php/logout.php'>Log out</a></li>";
           }else{
            echo "<li><a href='html/login.html'>Log in</a></li>";
            echo "<li><a href='html/registration.html'>Registration</a></li>";
           }
           ?>
        </ul>
     </li>
   </ul>
     </nav>
<div id="immersiveHub">
	<canvas id="renderCanvas" touch-action="none"></canvas>
   
</div>

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Left UI of Edit Popup - Will allow new objects to be spawned -->
    <!-- Radio buttons will be styled to look like the boxes in the wireframe containing imported models -->
    <!-- The user will select the model they want, input co-ords and a name then press the create button-->

    <div class="modal-content left">
      <form>
        ??<input type="radio" id="import0" name="objectType" checked="true">
        <label for="import0">1</label><br>
        <input type="radio" id="import1" name="objectType">
        <label for="import1">2</label><br>
        ??<input type="radio" id="import2" name="objectType">
        <label for="import2">3</label><br>
        <input type="radio" id="import3" name="objectType">
        <label for="import3">4</label><br>
        ??<input type="radio" id="import4" name="objectType">
        <label for="import4">5</label><br>
        <input type="radio" id="import5" name="objectType">
        <label for="import5">6</label><br>
        ??<input type="radio" id="import6" name="objectType">
        <label for="import6">7</label><br>
        <input type="radio" id="import7" name="objectType">
        <label for="import7">8</label><br>

        <?php
    	$sname= "localhost";

      $email= "root";
    
      $password = "";
    
      $db_name = "beyondrealityDB";
    
      if(isset($_SESSION['user'])){
        $dsn = "mysql:host=localhost;dbname=$db_name";
        $dbh = new PDO($dsn, $email, $password);
        
        $stmt = $dbh->prepare("SELECT * FROM assets WHERE user = ?");
        $stmt->bindParam(1,$_SESSION['user']);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $i = 8;
        $user = $_SESSION['user'];
        foreach ($stmt->fetchAll() as $value)
          $name = $value['name'];
          $description = $value['description'];
          $category = $value['category'];
          $asset = $value['asset'];
          $decoded_asset = json_decode($asset);
  
  
          $myfile = fopen("C:/xampp/htdocs/BeyondReality/assets/$name.glb", "a") or die("Unable to open location for log file !");
          $txt = $asset;
          fwrite($myfile, $txt);
          fclose($myfile);
  
          echo "<input type='radio' id='import$i' name='objectType'>
                <label for='import$i'>$name</label><br>";
          echo "<input type='hidden' id='asset$i' name='asset' value='$decoded_asset'>";
          echo "<input type='button' value='Create New Own Object' onclick='newOwnObject2()'>";
          $i++;
      }
      ?>
        <label for="name">Name:</label>
        <input type="text" id="name"><br>

        <label for="position">X:</label>
        <input type="number" id="positionX" name="position" min="-5" max="5" value="0"><br>
        <label for="position">Y:</label>
        <input type="number" id="positionY" name="position" min="-5" max="5" value="0"><br>
        <label for="position">Z:</label>
        <input type="number" id="positionZ" name="position" min="-5" max="5" value="0"><br>
        <input type="button" value="Create New Object" onclick="newObject2()">
      </form>
    </div>

    <!-- Center UI of Edit Popup - Exit button -->
    <button class="modal-content close" onclick="exit()">Exit Edit Mode</button>


    <!-- Right UI of Edit Popup - Will show a list of existing objects and let them be edited/deleted -->
    <div class="modal-content right" id="rightGUI"><p>My Objects</p>

      </div>
  </div>



	<script>
        const canvas = document.getElementById("renderCanvas"); // Get the canvas element
        const engine = new BABYLON.Engine(canvas, true); // Generate the BABYLON 3D engine

        const createScene = function () {
            // This creates a basic Babylon Scene object (non-mesh)
            const scene = new BABYLON.Scene(engine);

            // This creates and positions a free camera (non-mesh)
            const camera = new BABYLON.FreeCamera("camera1", new BABYLON.Vector3(-3, 2, -9), scene);

            // This targets the camera to scene origin
            camera.setTarget(BABYLON.Vector3.Zero());

            // This attaches the camera to the canvas
            camera.attachControl(canvas, true);

            // This creates a light, aiming 0,1,0 - to the sky (non-mesh)
            const light = new BABYLON.HemisphericLight("light", new BABYLON.Vector3(0, 1, 0), scene);

            // Default intensity is 1. Let's dim the light a small amount
            light.intensity = 0.5;


            //Render the Ocean Environment
            BABYLON.SceneLoader.ImportMesh("", "assets/", "oceanEnvironment.glb", scene, function (meshes) {
            const mesh = meshes[0];
            mesh.position = new BABYLON.Vector3(6, 5, 1);
            })
            BABYLON.SceneLoader.ImportMesh("", "assets/", "Cargoship.glb", scene, function (meshes) {
            const mesh = meshes[0];
            mesh.position = new BABYLON.Vector3(6, 10, 1);
            })

            return scene;
        };





        const scene = createScene(); //Call the createScene function

        // Register a render loop to repeatedly render the scene
        engine.runRenderLoop(function () {
                scene.render();
        });

        // Watch for browser/canvas resize events
        window.addEventListener("resize", function () {
                engine.resize();
        });

      
	</script>
     <script src="js/objects.js"></script>
     <script src="js/keyboardcontrols.js"></script>


   </body>

</html>