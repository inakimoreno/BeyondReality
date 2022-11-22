

function moveObjectUp(objectName) {
    scene.getMeshByName(objectName).position.y++
}   
function moveObjectDown(objectName) {
    scene.getMeshByName(objectName).position.y--
}
function moveObjectLeft(objectName) {
    scene.getMeshByName(objectName).position.x--
}
function moveObjectRight(objectName) {
    scene.getMeshByName(objectName).position.x++
}
function moveObjectForward(objectName) {
    scene.getMeshByName(objectName).position.z--
}
function moveObjectBack(objectName) {
    scene.getMeshByName(objectName).position.z++
}


$(document).keydown(function(event) {
    if(editMode) {
        if ((event.ctrlKey || event.metaKey) && event.keyCode == 38) {
            moveableObjects.forEach(moveObjectBack)
        }
    }
});

$(document).keydown(function(event) {
    if(editMode) {
        if ((event.ctrlKey || event.metaKey) && event.keyCode == 40) {
            moveableObjects.forEach(moveObjectForward)
        }
    }
});




$(document).keydown(function(event) {
    if(editMode) {
        if (event.keyCode == 39) {
            moveableObjects.forEach(moveObjectRight)
        }
    }
});

$(document).keydown(function(event) {
    if(editMode) {
        if (event.keyCode == 37) {
            moveableObjects.forEach(moveObjectLeft)
        }
    }
});

    
$(document).keydown(function(event) {
    if(editMode) {
        if (!(event.ctrlKey || event.metaKey) && event.keyCode == 38) {
            moveableObjects.forEach(moveObjectUp)
        }
    }
});

$(document).keydown(function(event) {
    if(editMode) {
        if (!(event.ctrlKey || event.metaKey) && event.keyCode == 40) {
            moveableObjects.forEach(moveObjectDown)
        }
    }
});


