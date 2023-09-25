<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document test</title>
        <link rel="stylesheet" href="nav.css" />
    </head>

    <body>
        <script>
            let coin = '<?php echo $_SESSION["coins"]; ?>';
            // let coin = precoins; // Initial number of coins 
            document.getElementById("coins").innerHTML = coin;
            console.log(coin + " er på mongomåten")
        </script>
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
                        <p id="coins">

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

        </script>
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
    </body>

    </html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>