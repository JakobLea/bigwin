<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
$values = $_SESSION;
 foreach ($values as $value) {
 print_r($value[4]) . " ";
 }
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BigWin</title>
        <link rel="icon" type="image/x-icon" href="Logo/Favicon.png">
        <link rel="stylesheet" href="nav.css">
        <link rel="stylesheet" href="home.css">
    </head>
    
    <script>
        $user_name = validate($_POST['user_name']);
        tets = SELECT * FROM users WHERE user_name='$user_name';
        console.log(tets)

    </script>

    <body style="background-color:#333333">
        <nav class="navbar">
            <a href="home.php" class="nav-branding"> <img style="border:0px solid black;" src="Logo/BigWin3.png"
                    width=100px, height=50px></a>

            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="mines.php" class="nav-link">Mines</a>
                </li>
                <li class="nav-item">
                    <a href="Tjenester.html" class="nav-link">Tjenester</a>
                </li>
                <li class="nav-item">
                    <a href="Omoss.html" class="nav-link">Om oss</a>
                </li>
                <li class="nav-item">
                    <a href="Kontakt.html" class="nav-link">Kontakt</a>
                </li>
            </ul>
            <div class="login-container">
                <li class="nav-item">
                    <div id="coinCount">
                        <p id="coins">10

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
        <script>
            const hamburger = document.querySelector(".hamburger");
            const navMenu = document.querySelector(".nav-menu");

            hamburger.addEventListener("click", () => {
                hamburger.classList.toggle("active");
                navMenu.classList.toggle("active");
            })

            document.querySelectorAll("nav-link").forEach(n => n.
                addEventListener("click", () => {
                    hamburger.classList.remove("active");
                    navMenu.classList.remove("active");
                })) 
        </script>


        <div class="velkommen">
            <h1>
                Velkommen tilbake,
                <?php echo $_SESSION['name']; ?>
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
            <div><img onclick="location.href = 'plinko.html';" src="Stake bilder/Plinko.png" width=139px, height=187px>
            </div>
        </div>

    </body>



    </html>
<?php
 } else {
    header("Location: index.php");
    exit();
}
?>