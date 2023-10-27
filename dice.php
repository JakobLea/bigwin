<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

?>
<!DOCTYPE html>
<html>

<head>
    <script src="jonsfiler/jquery-3.7.1.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="Logo/Favicon.png">
    <title>Dice</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="dice.css">
</head>

<body style="background-color:#333333">
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
                <a href="Kontakt.html" class="nav-link">Kontakt</a>
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

    <div class="flex-container">

        <div class="selectbox">
            <div><label id="mineCountLabel" for="mineCount">Dice</label></div>
            <div>
                <p class="error-message" id="errorMessage"></p>
            </div>
            <!-- <div>
            <p class="Bet">Bet amount</p>
        </div> -->
            <div id="boxforinp">
                <input type="number" id="coinsToSpend" placeholder="Enter coins">
                <button id="addRemainingCoinsButton">Max</button>
            </div>

            <div>
                <button class="velg" onclick="startGame()" id="startButton">Bet</button>
            </div>
            <!-- <div id="multiplier" style="display: none;">Multiplier: 1x</div> -->
        </div>

        <div class="container" id="container">
            <div class="container">
                <h1>Dice</h1>
                <div class="game">
                    <input type="range" id="slider" min="1" max="100" step="1" value="50">
                    <p>Your Guess: <span id="guessValue">50</span></p>
                    <p id="message"></p>
                </div>

            </div>
        </div>
        <div></div>
    </div>
    <script src="mines.js"></script>
    <script>
        const slider = document.getElementById("slider");
        const guessValue = document.getElementById("guessValue");
        const checkButton = document.getElementById("startButton");
        const message = document.getElementById("message");

        let gameStarted = false; // Flag to track if the game has started

        slider.addEventListener("input", () => {
            guessValue.textContent = slider.value;
        });

        function changeCoins(changeBy) {
                var coinsChanged = document.getElementById("coins").innerHTML;

                coinsChanged = parseInt(coinsChanged) + changeBy;

                document.cookie = "coins=" + coinsChanged + "; max-age=5; path=/";
                $("#coinCount").load("updateCoins.php");
            }

            function getCoins() {
                var gottenCoins = document.getElementById("coins").innerHTML;

                return gottenCoins;
            }

        function startGame() {
            if (!gameStarted) {
                const coinsToSpendInput = document.getElementById("boxforinp");
                const errorMessage = document.getElementById("errorMessage");

                const coinsToSpend = parseFloat(document.getElementById("coinsToSpend").value);

                if (isNaN(coinsToSpend) || coinsToSpend <= 0 || coinsToSpend.toString().split(".")[1]?.length > 2) {
                    errorMessage.style.display = "block";
                    coinsToSpendInput.classList.add("error");
                    coinsToSpendInput.style.border = "2px solid red";
                    errorMessage.textContent = "Invalid Number.";
                } else if (coinsToSpend > getCoins()) {
                    // Hide the error message and remove the 'error' class from the input
                    errorMessage.style.display = "none";
                    coinsToSpendInput.style.border = "2px solid red";
                    // Show the modal
                    const modal = document.getElementById("myModal");
                    modal.style.display = "block";

                    // Close the modal when clicking outside of it
                    window.onclick = function (event) {
                        if (event.target === modal) {
                            modal.style.display = "none";
                        }
                    };
                } else {
                    errorMessage.style.display = "none";
                    coinsToSpendInput.style.border = "";
                    changeCoins(-coinsToSpend); // Deduct the specified number of coins to start the game
                    //    document.getElementById("coinCount").textContent = formatCoinCount(Math.floor(coins * 100) / 100);
                    gameStarted = true; // Set the game as started
                    // Show the multiplier if it's not visible
                    // Reset the multiplier
                    // multiplier = 1;
                    // if (!multiplierVisible) {
                    //     document.getElementById("multiplier").style.display = "block";
                    //     multiplierVisible = true;
                    // }
                    document.getElementById("coinsToSpend").disabled = true; // Disable the input
                    document.getElementById("startButton").textContent = "Cash Out"; // Change button text
                    document.getElementById("startButton").classList.add("cash-out-disabled"); // Add the disabled class

                    const targetNumber = Math.floor(Math.random() * 100) + 1;


                // checkButton.addEventListener("click", () => {
                    const userGuess = parseInt(slider.value, 10);

                    if (userGuess > targetNumber) {
                        message.textContent = "Congratulations! You guessed correctly. The target number was lower.";
                    } else {
                        message.textContent = "Try a higher number.";
                    }
                // });
                }
            }
            // else if (gameStarted && cellsClicked) {
            //     cashOut();
            // }
        }

    </script>
</body>

</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>