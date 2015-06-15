<?php
// This code puts the canvas image on the server
if(isset($GLOBALS['HTTP_RAW_POST_DATA'])){
    $rawImage = $GLOBALS['HTTP_RAW_POST_DATA'];
    $removeHeaders = substr($rawImage, strpos($rawImage, ",")+1);
    $decode = base64_decode($removeHeaders);
    $filename = time()."card".mt_rand();
    $fopen = fopen('card-images/'.$filename.'.png', 'wb');
    fwrite($fopen, $decode);
    fclose($fopen);
    echo $filename;
    exit();
}
?><!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Customize your Business Card</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        #theform {
            background: url(template-images/card.png) no-repeat;
            width: 351px;
            height: 631px;
            margin: 0px auto;
        }

        #theform > div {
            margin: 0px 0px 0px 30px;
            width: 180px;
            position: relative;
            top: 215px;
        }

        #theform > div > input {
            display: block;
            padding: 4px;
        }

        #theform > div > input {
            margin-top: 8px;
        }

        #theform > div > #streetAddress {
            margin-top: 25px;
        }

        #theform > div > #email {
            margin-top: 90px;
            margin-left: 50px;
        }

        .menu {
            width: 600px;
            margin: 0px auto;
            text-align: center;
            padding: 20px;
        }

        .menu > button {
            font-size: 19px;
            padding: 10px 30px;
            cursor: pointer;
        }

        #card_canvas {
            display: block;
            width: 351px;
            height: 631px;
            margin: 0px auto;
        }
    </style>
    <script>
        function _(x) {
            return document.getElementById(x);
        }
        var demo_card_1 = new Image();
        demo_card_1.src = "template-images/card.png";

        var fb = new Image();
        fb.src = "template-images/fb-icon.png";

        function preview() {
            var name = _("name").value;
            var number = _("number").value;
            var street = _("streetAddress").value;
            var city = _("city").value;
            var email = _("email").value;
            var web = "www.flippenlekkaspice.co.za";
            var facebook = "/flippenlekkaspice";
            var position = _("position").value;
            if (name == "" || position == "") {
                alert("Please fill in both fields");
                return false;
            }
            var ctx = _('card_canvas').getContext('2d');
            ctx.drawImage(demo_card_1, 0, 0);
            ctx.drawImage(fb, 70, 560, 25, 25);
            ctx.fillStyle = '#000000';
            ctx.textAlign = 'left';
            ctx.font = 'bold 26px "Corbel", arial';
            ctx.shadowOffsetX = 1;
            ctx.shadowOffsetY = 1;
            ctx.shadowBlur = 2;
            ctx.fillText(name, 30, 230, 320);
            ctx.font = 'italic 24px "Corbel", arial';
            ctx.fillText(position, 30, 260, 320);
            ctx.font = '25px "Corbel", arial';
            ctx.fillText(number, 30, 290, 320);
            ctx.fillText(street, 30, 370, 320);
            ctx.fillText(city, 30, 400, 320);
            ctx.textAlign = 'center';
            ctx.fillStyle = '#FFFFFF';
            ctx.fillText(email, 178, 520, 320);
            ctx.fillText(web, 178, 550, 320);
            ctx.fillText(facebook, 188, 580, 320);
        }

        function render() {
            _("renderbtn").style.display = "none";
            _("canvas_save_status").innerHTML = "rendering... please wait...";
            var ctx = _('card_canvas').getContext('2d');
            var imgdata = ctx.canvas.toDataURL("image/jpg");
            var hr = new XMLHttpRequest();
            hr.open("POST", "index.php", true);
            hr.setRequestHeader("Content-type", "canvas/upload");
            hr.onreadystatechange = function () {
                if (hr.readyState == 4 && hr.status == 200) {
                    window.location = "card.php?id=" + hr.responseText;
                }
            }
            hr.send("cd=" + imgdata);
        }
    </script>
</head>

<body>
    <form id="theform" onsubmit="return false">
        <div>
            <input id="name" placeholder="Your Name">
            <input id="position" placeholder="Position eg: Agent">
            <input id="number" placeholder="Contact Number">
            <input id="streetAddress" placeholder="Street Address">
            <input id="city" placeholder="City">

            <input id="email" placeholder="Email">

        </div>
    </form>
    <div class="menu">
        <button id="btn1" onclick="preview()">&darr; Preview &darr;</button>
    </div>
    <canvas id="card_canvas" width="351px" height="631"></canvas>
    <div class="menu">
        <button id="renderbtn" onclick="render()">Render</button>
        <span id="canvas_save_status"></span>
    </div>
    <div style="height:200px;"></div>
</body>

</html>
