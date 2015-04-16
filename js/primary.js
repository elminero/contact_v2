/**
 * Created by ian on 6/8/14.
 */

var seconds = 0;

function tick() {


    seconds++;

    if(seconds < 10) {
        displaySeconds = "0" + String(seconds);
    } else {
        displaySeconds = String(seconds);
    }


    document.getElementById("timer").innerHTML = displaySeconds;


}






function timer() {

    document.getElementById("timer").innerHTML = "0:00";
    setInterval(tick, 1000);

}





function preparePage() {

   timer();


}


window.onload = function() {
    preparePage();
};



