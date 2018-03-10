<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=320">
    <title>Video Upload</title>
    <script src="scripts.js"></script>
    <style type="text/css">
        progress {
            display: none;
            background-color: #eee;
            border-radius: 2px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25) inset;
            margin: 0pt;
            margin-bottom: 5pt;
            width: 100%;
        }

        #main {
            padding: 10pt;
            display: flex;
            align-items: center;
            flex-direction: column;
            align-items: stretch;
        }

        body {
            font-family: "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            background: linear-gradient(180deg, cornflowerblue, skyblue);
        }

        html, body {
            height: 100%;
            width: 100%;
            padding: 0;
            margin: 0;
            background-repeat: no-repeat;
        }

        input[type="file"] {
            display: none;
        }

        input[type="submit"] {

        }

        .part {
            margin: 0pt;
            margin-bottom: 5pt;
            font-size: 15pt;
            text-align: center;
            width: 100%;
            border-radius: 5pt;

            padding: 0;
            padding-top: 10pt;
            padding-bottom: 10pt;
            border: 0;
        }


        .button {
            border-radius: 5pt;
            background: linear-gradient(0deg, white, paleturquoise);
            cursor: pointer;
        }
    </style>
</head>
<body>
<div id="main">
    <form id="form" enctype="multipart/form-data" method="post">
        <input id="name" class="part" type="text" name="name" oninput="updateName();" onkeyup="updateName();" onchange="updateName();" placeholder="Name hier eingeben">
        <input type="hidden" name="MAX_FILE_SIZE" value="128000000" />
        <div class="button">
            <label class="button part">
                <input name="file" type="file" id="file" accept="video/*" onchange="fileSelected();"/>
                <div class="part" id="file-name">Video auswählen</div>
            </label>
        </div>

        <input id="submit" class="button part" type="button" value="Hochladen" onclick="uploadFile();"/>
        <progress id="file-progress" value="0" max="100"></progress>
        <div id="videos-label" style="text-align: center; display: none">Deine videos:</div>
        <div id="allFiles" class="part">

        </div>
    </form>
</div>
</body>
</html>
