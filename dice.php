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

    <body style="background-color:#2B3D5D">
        <nav class="navbar">
            <a href="home.php" class="nav-branding"> <img style="border:0px solid black;" src="Logo/BigWin3.png" width=100px, height=50px></a>

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
                        <input type="range" id="slider" min="2" max="98" step="1" value="50">
                        <p>Tallet ditt er <span id="guessValue">50</span><br>Du vil få <span id="multi">1.9800</span>x vis tallet er høyere enn ditt</p>
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
            const multi = document.getElementById("multi");
            const checkButton = document.getElementById("startButton");
            const message = document.getElementById("message");

            let gameStarted = false; // Flag to track if the game has started

            slider.addEventListener("input", () => {
                guessValue.textContent = slider.value;
                multi.textContent = multiplierSystems[slider.value];
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
            

            const multiplierSystems = [1, 1, 1.0102, 1.0206, 1.0313, 1.0421, 1.0532, 1.0645, 1.0761, 1.0879, 1.1000, 1.1124, 1.1250, 1.1379, 1.1512, 1.1647, 1.1786, 1.1928, 1.2073, 1.2222, 1.2375, 1.2532, 1.2692, 1.2857, 1.3026, 1.3200, 1.3378, 1.3562, 1.3750, 1.3944, 1.4143, 1.4348, 1.4559, 1.4776, 1.5000, 1.5231, 1.5469, 1.5714, 1.5968, 1.6230, 1.6500, 1.6780, 1.7069, 1.7368, 1.7679, 1.8000, 1.8333, 1.8679, 1.9038, 1.9412, 1.9800, 2.0204, 2.0625, 2.1064, 2.1522, 2.2000, 2.2500, 2.3023, 2.4146, 2.4750, 2.5385, 2.6053, 2.6757, 2.7500, 2.8286, 2.9118, 3.0000, 3.0938, 3.1935, 3.3000, 3.3000, 3.4138, 3.5357, 3.6667, 3.8077, 3.9600, 4.1250, 4.3043, 4.5000, 4.7143, 4.9500, 5.2105, 5.5000, 5.8235, 6.1875, 6.6000, 7.0714, 7.6154, 8.2500, 9.0000, 9.9000, 11.0000, 12.3750, 14.1429, 16.5000, 19.8000, 24.7500, 33.0000, 49.5000];

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
                        window.onclick = function(event) {
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

                        if (userGuess < targetNumber) {
                            tall = multiplierSystems[slider.value] * coinsToSpend
                            message.textContent = "Tallet var høyere, du vant " + tall + " coins, tallet var " + targetNumber;
                            changeCoins((multiplierSystems[slider.value] * coinsToSpend));
                            gameStarted = false; // Reset the game flag
                            document.getElementById("startButton").classList.remove("cash-out-disabled"); // Remove disabled class
                            document.getElementById("startButton").disabled = false; // Enable the "Start Game" button
                            document.getElementById("startButton").textContent = "Start Game"; // Reset button text
                            document.getElementById("coinsToSpend").disabled = false; // Enable the input
                            document.getElementById("multiplier").style.display = "none"; // Hide the multiplier
                            multiplierVisible = false; // Reset multiplierVisible flag
                            document.getElementById("container").innerHTML = "";
                            mines = [];
                            points = 0;
                            multiplier = 1; // Reset the multiplier to 1
                            updateMultiplier();
                            hideResetButton(); // Hide the reset button
                            showCashOutButton(); // Show the cash-out button
                            initializeGame();
                            closePopup();
                            mineFreeCellsClicked = 0;
                        } else {
                            message.textContent = "Tallet var lavere, du tapte, tallet var " + targetNumber;
                            gameStarted = false; // Reset the game flag
                            document.getElementById("startButton").classList.remove("cash-out-disabled"); // Remove disabled class
                            document.getElementById("startButton").disabled = false; // Enable the "Start Game" button
                            document.getElementById("startButton").textContent = "Bet"; // Reset button text
                            document.getElementById("coinsToSpend").disabled = false; // Enable the input
                            document.getElementById("multiplier").style.display = "none"; // Hide the multiplier
                            multiplierVisible = false; // Reset multiplierVisible flag
                            document.getElementById("container").innerHTML = "";
                            mines = [];
                            points = 0;
                            multiplier = 1; // Reset the multiplier to 1
                            updateMultiplier();
                            hideResetButton(); // Hide the reset button
                            showCashOutButton(); // Show the cash-out button
                            initializeGame();
                            closePopup();
                            mineFreeCellsClicked = 0;
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