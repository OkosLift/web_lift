
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

function getCurrentLevel(){
    return currentLevel[getSelectedLift()];
}


function moveThatLift_UP(i){
    getLift[i];

    lift[i].y -= kovi;

    currentLevel[getSelectedLift()]++;
    console.log(getCurrentLevel());
}

function moveThatLift_DOWN(i){
    getLift[i];

    lift[i].y += kovi;

    currentLevel[getSelectedLift()]--;
    console.log(getCurrentLevel());
}


async function calculateMove(level){
    while (getCurrentLevel() != level){
        await delay(200);
        if (getCurrentLevel() < level){
            //felfele megy
            moveThatLift_UP(selectedLift);
        } else if (getCurrentLevel() > level){
            //lefele megy
            moveThatLift_DOWN(selectedLift);
        }
    }
}



function delay(milliseconds){
    return new Promise(resolve => {
        setTimeout(resolve, milliseconds);
    });
}

