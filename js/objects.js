
   
        class File {
            constructor(name, path) {
                this.name = name
                this.path = path
            }
        }

        importedFiles = [];

        function getFilePath(name) {
            for(i=0;i<importedFiles.length;i++) {
                if (name == importedFiles[i].name) {
                    return importedFiles[i].path;
                }
            }
        }
        function getFile() {
        let radioButtons = document.querySelectorAll('input[name="objectType"]');
        let myFile = "";
        let i = 0;
        for (const radioButton of radioButtons) {
          if (radioButton.checked) {
            return getFilePath(document.getElementsByTagName("label")[i].innerHTML);
            break;
          } else {
            i++;
          }
        }
        }
        function getOwnFilePath(name) {
            let file = new File(name,"assets/"+name+".glb");
            return file.path;
        }

        function getOwnFile() {
            let radioButtons = document.querySelectorAll('input[name="objectType"]');
            let myFile = "";
            let i = 0;
            for (const radioButton of radioButtons) {
              if (radioButton.checked) {
                console.log(i)
                console.log(document.getElementsByTagName("label")[i].innerHTML);
                return getOwnFilePath(document.getElementsByTagName("label")[i].innerHTML);
                break;
              } else {
                i++;
              }
            }
        }

////////////////////////////////////////////////////////////////////////
        let cube = new File("Cube","assets/cube.glb");
        let submarine = new File("Submarine","assets/submarine.glb");
        let coral = new File("Coral","assets/coralBlue.glb");

        //let a = new File("a","assets/a.glb");
        
        temporaryImport(cube);
        temporaryImport(submarine);
        temporaryImport(coral);
        //temporaryImport(a);

        function temporaryImport(file) {
            importedFiles.push(file)
        }
 //////////////////////////////////////////////////////////////////////// 

 class Object2 {
    constructor(name,file,x,y,z) {
        this.name = name;
        this.file = file;
        this.x = x;
        this.y = y;
        this.z = z;
        this.mesh = null
    }
}
      
function checkForRepeats(name) {
    for (i=0;i<renderedObjects.length;i++) {
        if (renderedObjects[i].name==name) {
            return i;
        } 
    }
}


        renderedObjects = [];

        function renderObject(object) {
            if (object.file==null) {
                alert("Error: Cannot render object as a file has not been selected")
                return;
            } else {
                BABYLON.SceneLoader.ImportMesh("", "./", object.file, scene, function (meshes) {
                    let mesh = meshes[0];
                    mesh.name = object.name;
                    mesh.position = new BABYLON.Vector3(object.x, object.y, object.z);
                    object.mesh = mesh;
                })
                renderedObjects.push(object);
                updateDefaultName();
            }
            listObject(object);
        }


        function newObject2 () {
            myObject = new Object2;
            myObject.file = getFile();
            myObject.x = document.getElementById("positionX").value;
            myObject.y = document.getElementById("positionY").value;
            myObject.z = document.getElementById("positionZ").value;
            myObject.name = document.getElementById("name").value;
            if(checkForRepeats(myObject.name)!=null) {
                alert("Error: An Object with this name already exists")
            } else {
                renderObject(myObject);
            }
        }

        function newOwnObject2 () {
            myObject = new Object2;
            myObject.file = getOwnFile();
            myObject.x = document.getElementById("positionX").value;
            myObject.y = document.getElementById("positionY").value;
            myObject.z = document.getElementById("positionZ").value;
            myObject.name = document.getElementById("name").value;
            if(checkForRepeats(myObject.name)!=null) {
                alert("Error: An Object with this name already exists")
            } else {
                renderObject(myObject);
            }
        }

      
        function updateDefaultName() {
            document.getElementById('name').value = "Object" + defaultName++;
        }

        function deleteObject(objectName) {
            for(i=0;i<moveableObjects.length;i++) {
                if (moveableObjects[i]===objectName) {
                    moveableObjects.splice(i,1);
                }
            }
            renderedObjects.splice(checkForRepeats(objectName),1)
            scene.getMeshByName(objectName).dispose()
            document.getElementById(objectName).outerHTML = "";
        }

       

        /******************************************************/

       

        /*function importFile(file) {
            if (!file.endsWith(".glb")) {
                alert("Cannot import file: File names must end with .glb");
            } else if (importedFiles.findIndex(file)>0){
                alert("There is already a file with this name");
            } else {
                importedFiles.push(file);
            }
        }*/



        function toggleMoving(object) {
          for(i=0;i<moveableObjects.length;i++) {
            if (moveableObjects[i]===object) {
                moveableObjects.splice(i,1);
                document.getElementById(object).outerHTML = "<div class='renderedObject' id="+object+"><p>"+object+"</p><button onclick=toggleMoving(\'"+object+"\')>Select</button><button onclick=deleteObject(\'"+object+"\')>del</button></div>"
                return;
            }
          }
          moveableObjects.push(object);
          document.getElementById(object).outerHTML = "<div class='selectedObject' id="+object+"><p>"+object+"</p><button onclick=toggleMoving(\'"+object+"\')>Deselect</button><button onclick=deleteObject(\'"+object+"\')>del</button></div>"
        }

        

        /******************************************************/
        //GUI Stuff

        function listObject(object) {
            let rightGui = document.getElementById("rightGUI");
            rightGui.innerHTML += "<div class='renderedObject' id="+object.name+"><p>"+object.name+"</p><button onclick=toggleMoving(\'"+object.name+"\')>Select</button><button onclick=deleteObject(\'"+object.name+"\')>del</button></div>"
        }
        
        function tempNameImport(importedFiles) {
            for(i=0;i<importedFiles.length;i++) {
                let radioLabel = document.getElementsByTagName("label")[i];
                radioLabel.innerHTML = importedFiles[i].name;
            }
        }
         /******************************************************/

let editMode = false;
let moveableObjects = [];
let defaultName = 2
document.getElementById('name').value = "Object1"
tempNameImport(importedFiles);



        // Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("edit");

// Get the <span> element that closes the modal


// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
  toggleEditMode()
}
function toggleEditMode() {
    if (!editMode) {
        modal.style.display = "block";
        editMode = true;
        

    } else {
        modal.style.display = "none";
        editMode = false;
    }
}

function exit() {
    modal.style.display = "none";
    toggleEditMode()
}



$(document).keydown(function(event) {
    if ((event.ctrlKey || event.metaKey) && event.keyCode == 69) {
        toggleEditMode();
    }});


    


    
  