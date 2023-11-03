<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="Logo/Favicon.png">
        <title>Daglig Penger</title>
        <link rel="stylesheet" href="nav.css">
        <link rel="stylesheet" href="Penger.css">
    </head>

    <script src="jonsfiler/jquery-3.7.1.min.js"></script>

    <body style="background-color:#333333">

        <script src="mines.js"></script>

        <nav class="navbar">
            <a href="home.php" class="nav-branding"> <img style="border:0px solid black;" src="Logo/BigWin3.png"
                    width=100px, height=50px></a>

            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="mines.php" class="nav-link">Mines</a>
                </li>
                <li class="nav-item">
                    <a href="Penger.php" class="nav-link">Penger</a>
                </li>
                <li class="nav-item">
                    <a href="blackjack.php" class="nav-link">Blackjack</a>
                </li>
                <li class="nav-item">
                <a href="dice.php" class="nav-link">Dice</a>
                </li>
            </ul>
            <div class="login-container">
                <li class="nav-item">
                    <div id="coinCount">

                    </div>
                </li>

                <li class="nav-item">
                    <a href="Login.html" class="nav-link">Login</a>
                </li>
            </div>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>

        <input type="button" value="spin" style="float:left;" id='spin' />
        <canvas class="lykkehjul" id="canvas" width="1000" height="1000"></canvas>

        <script>
            var options = ["0", "10", "0", "50", "100", "10", "5000", "0", "500", "0", "-10", "20", "30", "20", "50", "20", "100"];

            var startAngle = 0;
            var arc = Math.PI / (options.length / 2);
            var spinTimeout = null;

            var spinArcStart = 10;
            var spinTime = 0;
            var spinTimeTotal = 0;

            var ctx;

            function changeCoins(changeBy) {
                var coinsChanged = document.getElementById("coins").innerHTML;

                // Parse the current number of coins
                coinsChanged = parseFloat(coinsChanged);

                // Round to the nearest integer
                coinsChanged = Math.round(coinsChanged + changeBy);

                document.cookie = "coins=" + coinsChanged + "; max-age=5; path=/";
                $("#coinCount").load("updateCoins.php");
            }


            document.getElementById("spin").addEventListener("click", spin);

            function byte2Hex(n) {
                var nybHexString = "0123456789ABCDEF";
                return String(nybHexString.substr((n >> 4) & 0x0F, 1)) + nybHexString.substr(n & 0x0F, 1);
            }

            function RGB2Color(r, g, b) {
                return '#' + byte2Hex(r) + byte2Hex(g) + byte2Hex(b);
            }

            function getColor(item, maxitem) {
                var phase = 0;
                var center = 128;
                var width = 127;
                var frequency = Math.PI * 2 / maxitem;

                red = Math.sin(frequency * item + 2 + phase) * width + center;
                green = Math.sin(frequency * item + 0 + phase) * width + center;
                blue = Math.sin(frequency * item + 4 + phase) * width + center;

                return RGB2Color(red, green, blue);
            }

            function drawRouletteWheel() {
                var canvas = document.getElementById("canvas");
                if (canvas.getContext) {
                    var outsideRadius = 200;
                    var textRadius = 160;
                    var insideRadius = 125;

                    ctx = canvas.getContext("2d");
                    ctx.clearRect(0, 0, 500, 500);

                    ctx.strokeStyle = "black";
                    ctx.lineWidth = 2;

                    ctx.font = 'bold 12px Helvetica, Arial';

                    for (var i = 0; i < options.length; i++) {
                        var angle = startAngle + i * arc;
                        //ctx.fillStyle = colors[i];
                        ctx.fillStyle = getColor(i, options.length);

                        ctx.beginPath();
                        ctx.arc(250, 250, outsideRadius, angle, angle + arc, false);
                        ctx.arc(250, 250, insideRadius, angle + arc, angle, true);
                        ctx.stroke();
                        ctx.fill();

                        ctx.save();
                        ctx.shadowOffsetX = -1;
                        ctx.shadowOffsetY = -1;
                        ctx.shadowBlur = 0;
                        ctx.shadowColor = "rgb(220,220,220)";
                        ctx.fillStyle = "black";
                        ctx.translate(250 + Math.cos(angle + arc / 2) * textRadius,
                            250 + Math.sin(angle + arc / 2) * textRadius);
                        ctx.rotate(angle + arc / 2 + Math.PI / 2);
                        var text = options[i];
                        ctx.fillText(text, -ctx.measureText(text).width / 2, 0);
                        ctx.restore();
                    }

                    //Arrow
                    ctx.fillStyle = "black";
                    ctx.beginPath();
                    ctx.moveTo(250 - 4, 250 - (outsideRadius + 5));
                    ctx.lineTo(250 + 4, 250 - (outsideRadius + 5));
                    ctx.lineTo(250 + 4, 250 - (outsideRadius - 5));
                    ctx.lineTo(250 + 9, 250 - (outsideRadius - 5));
                    ctx.lineTo(250 + 0, 250 - (outsideRadius - 13));
                    ctx.lineTo(250 - 9, 250 - (outsideRadius - 5));
                    ctx.lineTo(250 - 4, 250 - (outsideRadius - 5));
                    ctx.lineTo(250 - 4, 250 - (outsideRadius + 5));
                    ctx.fill();
                }
            }

            function spin() {
                spinAngleStart = Math.random() * 10 + 10;
                spinTime = 0;
                spinTimeTotal = Math.random() * 3 + 4 * 1000;
                rotateWheel();
            }

            function rotateWheel() {
                spinTime += 30;
                if (spinTime >= spinTimeTotal) {
                    stopRotateWheel();
                    return;
                }
                var spinAngle = spinAngleStart - easeOut(spinTime, 0, spinAngleStart, spinTimeTotal);
                startAngle += (spinAngle * Math.PI / 180);
                drawRouletteWheel();
                spinTimeout = setTimeout('rotateWheel()', 30);
            }

            function stopRotateWheel() {
                clearTimeout(spinTimeout);
                var degrees = startAngle * 180 / Math.PI + 90;
                var arcd = arc * 180 / Math.PI;
                var index = Math.floor((360 - degrees % 360) / arcd);
                ctx.save();
                ctx.font = 'bold 30px Helvetica, Arial';
                var text = options[index]
                changeCoins(parseInt(text))
                ctx.fillText(text, 250 - ctx.measureText(text).width / 2, 250 + 10);
                ctx.restore();
            }

            function easeOut(t, b, c, d) {
                var ts = (t /= d) * t;
                var tc = ts * t;
                return b + c * (tc + -3 * ts + 3 * t);
            }

            drawRouletteWheel();
        </script>
    </body>

    </html>
    <?php
} else {
    header("Location: index.php");
    exit();
}
?>