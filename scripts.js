/**
 * Created by infinisil on 18.11.16.
 */

var n="13";

var localNameKey="name" + n;
var localIsSetKey="userNameSet1" + n;

function name_field() {
    return document.getElementById("name");
}

function fileSelected() {
    if (document.getElementById('file').files[0]) {
        var name = file.name;
        if (name.length > 12) {
            name = name.substring(0, 12);
        }
        document.getElementById('file-name').innerHTML = name;
    }
}

function updateName() {
    if (localStorage[localIsSetKey] != "true") {
        localStorage[localNameKey] = name_field().value;
    }

    updateFileList();
    console.log("hi");
}

function uploadFile() {
    updateName();

    if (localStorage[localNameKey] == "") {
        alert("Bitte geben Sie einen Namen ein.");
        return;
    }

    var file = document.getElementById('file').files[0];
    if (!file) {
        alert("Bitte wählen Sie ein Video aus.");
        return;
    }

    if (file.size > 128000000) {
        alert("Video zu gross!");
        return;
    }

    var xhr = new XMLHttpRequest();
    var fd = new FormData(document.getElementById('form'));

    /* event listners */
    xhr.upload.addEventListener("progress", uploadProgress, false);
    xhr.addEventListener("load", uploadComplete, false);
    xhr.addEventListener("error", uploadFailed, false);
    xhr.addEventListener("abort", uploadCanceled, false);
    xhr.open("POST", "upload.php");
    xhr.send(fd);

    document.getElementById("file-progress").style.display = 'inherit';
    document.getElementById('submit').onclick = '';
}

function uploadProgress(evt) {
    var progress = document.getElementById('file-progress');

    if (evt.lengthComputable) {
        var percentComplete = Math.round(evt.loaded * 100 / evt.total);
        console.log(percentComplete);
        progress.value = percentComplete;
    }
}

function uploadComplete(evt) {
    if (evt.target.status == 200) {
        var file = document.getElementById('file');
        file.value = file.defaultValue;
        localStorage[localIsSetKey] = "true";
        name_field().readOnly = true;

        updateFileList();
    } else {
        alert(evt.target.responseText);
    }
    document.getElementById("file-progress").style.display = 'none';
    document.getElementById('file-name').innerHTML = "Video auswählen";
    document.getElementById('submit').onclick = 'uploadFile();';
}

function uploadFailed(evt) {
    alert("There was an error attempting to upload the file.");
}

function uploadCanceled(evt) {
    console.log("Upload canceled");
}

function filesReceived(evt) {
    var jsonString = evt.target.responseText;
    var json = JSON.parse(jsonString);

    var number = json.number;
    var videos = json.videos;

    var div = document.getElementById("allFiles");


    while (div.firstChild) {
        div.removeChild(div.firstChild);
    }

    if (videos.length > 0) {
        document.getElementById('videos-label').style.display = 'block';
    }

    for (i = 0; i < videos.length; i++) {
        var element = document.createElement('div')
        element.setAttribute('class', 'link');
        var name = "";
        if (videos[i].length > 12) {
            name = videos[i].substring(0, 12);
        } else {
            name = videos[i];
        }
        element.innerHTML = '<a target="_blank" href="' + 'files/' + number + '/' + videos[i] + '">' + name + '</a>';
        div.appendChild(element);
    }

}

function updateFileList() {
    var getFiles = new XMLHttpRequest();

    getFiles.addEventListener("load", filesReceived, false);
    getFiles.open("GET", "allVideos.php");
    getFiles.setRequestHeader("name", localStorage[localNameKey]);
    getFiles.send(null);
}

window.onload = function() {
    if (typeof localStorage[localNameKey] == "string" && localStorage[localNameKey] != "") {
        name_field().value = localStorage[localNameKey];
        name_field().placeholder = "";
    }

    if (localStorage[localIsSetKey] == "true") {
        name_field().readOnly = true;
        updateFileList();
    }
}