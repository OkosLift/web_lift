
function getLift(i){
    if (i >= liftszam)
        i = liftszam-1;
    else if (i < 0)
        i = 0;

    return lift[i]; 
}

var currentLevel = 0;

function getCurrentLevel(){
    return currentLevel;
}


function moveLiftUp(){

    moveup();

    currentLevel++;
    console.log(getCurrentLevel());
}

function moveLiftDown(){

    movedown();

    currentLevel--;
    console.log(getCurrentLevel());
}


async function calculateMove(level){
    while (getCurrentLevel() != level){
        await delay(200);
        if (getCurrentLevel() < level){
            //felfele megy
            moveLiftUp();
        } else if (getCurrentLevel() > level){
            //lefele megy
            moveLiftDown();
        }
    }
}



function delay(milliseconds){
    return new Promise(resolve => {
        setTimeout(resolve, milliseconds);
    });
}