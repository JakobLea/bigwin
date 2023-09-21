<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BigWin</title>
    <link rel="icon" type="image/x-icon" href="Logo/Favicon.png">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="home.css">
    <style>
        
    </style>
</head>



<script>

    function includeHTML() {
        var z, i, elmnt, file, xhttp;
        /*loop through a collection of all HTML elements:*/
        z = document.getElementsByTagName("*");
        for (i = 0; i < z.length; i++) {
            elmnt = z[i];
            /*search for elements with a certain attribute:*/
            file = elmnt.getAttribute("w3-include-html");
            if (file) {
                /*make an HTTP request using the attribute value as the file name:*/
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) { elmnt.innerHTML = this.responseText; }
                        if (this.status == 404) { elmnt.innerHTML = "Page not found."; }
                        /*remove the attribute, and call this function once more:*/
                        elmnt.removeAttribute("w3-include-html");
                        includeHTML();
                    }
                }
                xhttp.open("GET", file, true);
                xhttp.send();
                /*exit the function:*/
                return;
            }
        }
    };

</script>



<body style="background-color:#333333">

    <div w3-include-html="nav.php"></div>

    <div class="velkommen">
        <h1>
            Velkommen tilbake, "Navnt"
        </h1>
        <h2>
            Trykk her får å legge til penger
        </h2>
        <a class="penger" href="Penger.html">Penger</a>
    </div>

 

    <div class="overskrift-container">
        <div>Dette er de mest populære spillene</div>
    </div>

    <div class="flex-container">
        <div><img onclick="location.href = 'crash.html';" src="Stake bilder/Crash.png" width=139px, height=187x></div>
        <div><img onclick="location.href = 'dice.html';" src="Stake bilder/Dice.png" width=139px, height=187px></div>
        <div><img onclick="location.href = 'mines.php';" src="Stake bilder/Mines.png" width=139px, height=187px></div>
        <div><img onclick="location.href = 'hilo.html';" src="Stake bilder/Hilo.png" width=139px, height=187px></div>
        <div><img onclick="location.href = 'plinko.html';" src="Stake bilder/Plinko.png" width=139px, height=187px></div>
    </div>

</body>



<script>

    includeHTML();

</script>



</html>