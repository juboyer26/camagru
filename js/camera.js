var video = document.querySelector("#videoElement");
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUsermedia ||
    navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;
if (navigator.getUserMedia) {
    navigator.getUserMedia({
        video: true
    }, handleVideo, videoError);
}

function handleVideo(localStream) {
    self.video.srcObject = localStream;
}

function videoError(e) { }
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
capture.addEventListener("click", function () {
    context.drawImage(video, 0, 0, 400, 300);
});

var pepe = document.querySelector("#pepe")
pepe.addEventListener("click", function () {
    var img = document.getElementById("test1");
    context.drawImage(img, 0, 0, 100, 100);
})

var troll = document.querySelector("#troll")
troll.addEventListener("click", function () {
    var img = document.getElementById("test3");
    context.drawImage(img, 0, 0, 100, 100);
})
var baby = document.querySelector("#baby")
baby.addEventListener("click", function () {
    var img = document.getElementById("test2");
    context.drawImage(img, 0, 0, 100, 100);
})


save.addEventListener("click", function () {

    var data = "img=" + canvas.toDataURL();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //  alert("submitted");
        }
    };
    xhttp.open("POST", "../controller/cameraSave.php", true);
    // xhttp.open("POST", "gallery.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //xhttp.send("alpha="+alpha);
    xhttp.send(data);
    setTimeout(function () {
        document.getElementById("gall").click()

    }, 300)

});