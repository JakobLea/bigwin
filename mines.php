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
        <title>Mines Game</title>
        <link rel="stylesheet" href="mines.css">
        <link rel="stylesheet" href="nav.css">
    </head>

    <script src="jonsfiler/jquery-3.7.1.min.js"></script>

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
    
        <!-- Jon igjen :) -->
        <script src="mines.js"></script>

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



        <!--
    <div class="coin-container">
        <div><label for="coinCount">Coins:</label></div>
        <div id="coinCount">10</div>
    </div>
-->

        <div class="flex-container">

            <div class="selectbox">
                <div><label id="mineCountLabel" for="mineCount">Mines</label></div>
                <div>
                    <p class="error-message" id="errorMessage"></p>
                </div>
                <!-- <div>
                <p class="Bet">Bet amount</p>
            </div> -->
                <div id="boxforinp">
                    <input type="number" id="coinsToSpend" placeholder="Enter coins">
                    <button id="addRemainingCoinsButton">MAX</button>
                </div>

                <div><label for="mineCount">Number of Mines:</label></div>
                <div> <select id="mineCount">
                        <option value="1">1 Mines</option>
                        <option value="2">2 Mines</option>
                        <option value="3">3 Mines</option>
                        <option value="4">4 Mines</option>
                        <option value="5">5 Mines</option>
                        <option value="6">6 Mines</option>
                        <option value="7">7 Mines</option>
                        <option value="8">8 Mines</option>
                        <option value="9">9 Mines</option>
                        <option value="10">10 Mines</option>
                        <option value="11">11 Mines</option>
                        <option value="12">12 Mines</option>
                        <option value="13">13 Mines</option>
                        <option value="14">14 Mines</option>
                        <option value="15">15 Mines</option>
                        <option value="16">16 Mines</option>
                        <option value="17">17 Mines</option>
                        <option value="18">18 Mines</option>
                        <option value="19">19 Mines</option>
                        <option value="20">20 Mines</option>
                        <option value="21">21 Mines</option>
                        <option value="22">22 Mines</option>
                        <option value="23">23 Mines</option>
                    </select></div>


                <div>
                    <button id="startButton" onclick="startGame()">Start Game</button>
                    <button id="resetButton" style="display:none;">Reset</button>
                </div>
                <div id="multiplier" style="display: none;">Multiplier: 1x</div>
            </div>

            <div class="container" id="container"></div>
            <div></div>
        </div>

        <div id="popup" class="popup" style="display: none;">
            <div class="popup-content">
                <p><span id="popup-multiplier"></span></p>
                <hr>
                <p><span id="popup-coins"></span><img id="chip" src="Logo/Chip_grønn.png" width=12px, height=12px></p>
            </div>
        </div>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <p>Not enough coins to start the game.</p>
                <button id="Deposit" onclick="location.href = 'Penger.php';">Deposit</button>
            </div>
        </div>

        <audio id="coinSound" src="Sound/Coin Sound3.mp3"></audio>
        <audio id="explosionSound" src="Sound/Explosion.mp3"></audio>
        <audio id="cashoutSound" src="Sound/Cashout.wav"></audio>
        <audio id="startGameSound" src="Sound/Click.mp3"></audio>
        <audio id="resetSound" src="Sound/Reset.mp3"></audio>
        <script>
            const gridSize = 5; // Updated to 5 rows and columns
            const numMines = 5; // Adjust as needed
            const mineCountDropdown = document.getElementById("mineCount");
            const coinSound = document.getElementById("coinSound");
            const explosionSound = document.getElementById("explosionSound");
            const multiplierSystems = {
                1: [1, 1.03, 1.08, 1.12, 1.18, 1.24, 1.30, 1.37, 1.46, 1.50, 1.55, 1.65, 1.77, 1.90, 2.06, 2.25, 2.47, 3.09, 3.54, 4.12, 4.95, 6.19, 8.25, 12.38, 24.75],
                2: [1, 1.08, 1.17, 1.29, 1.41, 1.56, 1.74, 1.94, 2.18, 2.47, 2.83, 3.26, 3.81, 4.50, 5.40, 6.60, 8.25, 10.61, 14.14, 19.80, 29.70, 49.50, 99.00, 297.00,],
                3: [1, 1.12, 1.29, 1.48, 1.71, 2.00, 2.35, 2.79, 3.35, 4.07, 5.00, 6.26, 7.96, 10.35, 13.80, 18.97, 27.11, 40.66, 65.06, 113.85, 227.70, 569.25, 2277.00],
                4: [1, 1.18, 1.41, 1.71, 2.09, 2.58, 3.23, 4.09, 5.26, 6.88, 9.17, 2.51, 17.52, 25.30, 37.95, 59.64, 99.39, 178.91, 357.81, 834.90, 2504, 12523],
                5: [1, 1.24, 1.56, 2.00, 2.58, 3.39, 4.52, 6.14, 8.50, 12.04, 17.52, 26.27, 40.87, 66.41, 113.85, 208.72, 417.45, 939.26, 2504.00, 8766.00, 52598.99], // For 5 mines
                6: [1, 1.30, 1.74, 2.35, 3.23, 4.52, 6.46, 9.44, 14.17, 21.89, 35.03, 58.38, 102.17, 189.75, 379.50, 834.90, 2087, 6261, 25047, 175329],
                7: [1, 1.37, 1.94, 2.79, 4.09, 6.14, 9.44, 14.95, 24.47, 41.60, 73.95, 138.66, 277.33, 600.87, 1442, 3965, 13219, 59486, 475893],
                8: [1, 1.46, 2.18, 3.35, 5.26, 8.50, 14.17, 24.47, 44.05, 83.20, 166.4, 356.56, 831.98, 2163, 6489, 23794, 118973, 1070759],
                9: [1, 1.55, 2.47, 4.07, 6.88, 12.04, 21.89, 41.60, 83.20, 176.80, 404, 1010, 2828, 9193, 36773, 202254, 2022545],
                10: [1, 1.65, 2.83, 5.00, 9.17, 17.52, 35.03, 73.95, 166.40, 404, 1077, 3232, 11314, 49031, 294188, 3236072], // For 10 mines
                11: [1, 1.77, 3.26, 6.26, 12.51, 26.77, 58.38, 138.66, 356.56, 1010, 3232, 12123, 56574, 367735, 4412826],
                12: [1, 1.90, 3.81, 7.96, 17.52, 40.87, 102.17, 277.33, 813.98, 2828, 11314, 56574, 396022, 5148297],
                13: [1, 2.06, 4.50, 10.35, 25.30, 66.41, 189.75, 600.87, 2163, 9193, 49031, 367735, 5148297],
                14: [1, 2.25, 5.4, 13.80, 37.95, 113.85, 379.5, 1442, 6489, 36773, 294188, 4412826],
                15: [1, 2.47, 6.6, 18.97, 59.64, 208.72, 834.9, 3965, 23794, 202254, 3236072],
                16: [1, 2.75, 8.25, 27.11, 99.39, 417.45, 2087, 13219, 118973, 2022545],
                17: [1, 3.09, 10.61, 40.66, 178.91, 939.26, 6261, 59486, 1070759],
                18: [1, 3.54, 14.14, 65.06, 357.81, 2504, 25047, 475893],
                19: [1, 4.12, 19.80, 113.85, 834.90, 8766, 175329],
                20: [1, 4.95, 29.70, 227.70, 2504, 52598],
                21: [1, 6.19, 49.50, 569.25, 12523],
                22: [1, 8.25, 99, 2277],
                23: [1, 12.37, 297],
                24: [1, 24.75],
                // Add more systems for different mine counts if needed
            };
            let selectedMineCount = parseInt(mineCountDropdown.value);

            mineCountDropdown.addEventListener("change", function () {
                selectedMineCount = parseInt(mineCountDropdown.value);
            });

            

            let mines = [];
            let points = 0;
            let coins = $("#coins").val();;


            let gameStarted = false; // Flag to track if the game has started
            let cellsClicked = false; // Flag to track whether a cell has been clicked
            let cashOutClicked = false; // Flag to track if the cash-out button has been clicked
            let multiplier = 1; // Initial multiplier
            let multiplierVisible = false; // Track if the multiplier is visible
            let mineFreeCellsClicked = 0; // Track mine-free cells clicked in the current round




            mineCountDropdown.addEventListener("change", function () {
                selectedMineCount = parseInt(mineCountDropdown.value);
            });

            // Function to remove the "cash-out-disabled" class from the button
            function enableCashOutButton() {
                const startButton = document.getElementById("startButton");
                startButton.classList.remove("cash-out-disabled");
                startButton.disabled = false; // Re-enable the button
            }

            // Function to format the coin count with two decimal places
            function formatCoinCount(coins) {
                return parseFloat(coins.toFixed(2));
            }



            function placeMines(count) {
                // Clear existing mines
                mines = [];

                for (let i = 0; i < count; i++) {
                    let row, col;
                    do {
                        row = Math.floor(Math.random() * gridSize);
                        col = Math.floor(Math.random() * gridSize);
                    } while (mines.some(mine => mine.row === row && mine.col === col));
                    mines.push({ row, col });
                }
            }


            function initializeGame() {
                for (let i = 0; i < gridSize; i++) {
                    for (let j = 0; j < gridSize; j++) {
                        const cell = document.createElement("div");
                        cell.classList.add("cell");
                        cell.dataset.row = i;
                        cell.dataset.col = j;
                        cell.addEventListener("click", revealCell);
                        document.getElementById("container").appendChild(cell);
                    }
                }
            }

            function startGame() {
                if (!gameStarted) {
                    const startGameSound = document.getElementById("startGameSound");
                    startGameSound.play();
                    const coinsToSpendInput = document.getElementById("boxforinp");
                    const errorMessage = document.getElementById("errorMessage");

                    const coinsToSpend = parseFloat(document.getElementById("coinsToSpend").value);

                    if (isNaN(coinsToSpend) || coinsToSpend <= 0 || coinsToSpend.toString().split(".")[1]?.length > 2) {
                        errorMessage.style.display = "block";
                        coinsToSpendInput.classList.add("error");
                        coinsToSpendInput.style.border = "2px solid red";
                        errorMessage.textContent = "Invalid Number.";
                    } else if (coinsToSpend > coins) {
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
                        coins -= coinsToSpend; // Deduct the specified number of coins to start the game
                        document.getElementById("coinCount").textContent = formatCoinCount(Math.floor(coins * 100) / 100);
                        gameStarted = true; // Set the game as started
                        // Show the multiplier if it's not visible
                        // Reset the multiplier
                        multiplier = 1;
                        if (!multiplierVisible) {
                            document.getElementById("multiplier").style.display = "block";
                            multiplierVisible = true;
                        }
                        enableCells(); // Enable the cells for gameplay
                        mineCountDropdown.disabled = true;
                        document.getElementById("coinsToSpend").disabled = true; // Disable the input
                        document.getElementById("startButton").textContent = "Cash Out"; // Change button text
                        document.getElementById("startButton").classList.add("cash-out-disabled"); // Add the disabled class
                        //mineCountDropdown.disabled = true;
                        cellsClicked = false; // Reset cellsClicked flag for the new game
                        const mineCount = parseInt(document.getElementById("mineCount").value);
                        placeMines(mineCount); // Place mines based on user selection
                    }
                } else if (gameStarted && cellsClicked) {
                    cashOut();
                }
            }



            function enableCells() {
                const cells = document.querySelectorAll(".cell");
                cells.forEach(cell => {
                    cell.classList.add("enabled");
                });
            }

            // Event listener for the reset button
            document.getElementById("resetButton").addEventListener("click", resetGame);





            function revealCell(event) {
                if (!gameStarted) {
                    return;
                }

                const row = parseInt(event.target.dataset.row);
                const col = parseInt(event.target.dataset.col);

                if (event.target.classList.contains("revealed")) {
                    // Cell is already revealed, do nothing
                    return;
                }

                const coinsToSpendInput = document.getElementById("coinsToSpend");
                const coinsToSpend = parseFloat(coinsToSpendInput.value);

                if (mines.some(mine => mine.row === row && mine.col === col)) {
                    event.target.classList.add("mine");
                    event.target.classList.add("clicked"); // Add the "clicked" class to the mine
                    const mineImage = document.createElement("img");
                    //mineImage.src = "Logo/Bomb2.png";
                    //mineImage.alt = "Mine";
                    mineImage.classList.add("revealed");
                    event.target.appendChild(mineImage);
                    revealAllCells(); // Reveal all cells and end the game
                    hideCashOutButton(); // Hide the cash-out button
                    showResetButton(); // Show the reset button
                    // Play the explosion sound when a mine is hit
                    explosionSound.currentTime = 0; // Reset the playback position
                    explosionSound.play();
                    // Change the text of the button to "Reset" after a mine is hit
                    document.getElementById("startButton").textContent = "Reset";

                    return; // Stop the game
                } else {
                    event.target.classList.add("revealed");
                    event.target.style.backgroundColor = "#000000"; // Change background color
                    const safeImage = document.createElement("img");
                    safeImage.src = "Logo/Chip_grønn.png";
                    safeImage.alt = "Safe";
                    safeImage.classList.add("revealed");
                    event.target.appendChild(safeImage);
                    points++;


                    mineFreeCellsClicked++;

                    // Play the coin sound when a safe cell is revealed
                    coinSound.currentTime = 0; // Reset the playback position
                    coinSound.play();

                    if (points === gridSize * gridSize - selectedMineCount) {
                        cashOutClicked = true; // Set cashOutClicked flag if all cells are correct
                        cashOut();
                    }

                }


                cellsClicked = true;
                enableCashOutButton();
                updateMultiplier();
            }


            function updateMultiplier() {
                if (multiplierSystems[selectedMineCount]) {
                    multiplier = multiplierSystems[selectedMineCount][points];
                }
                const multiplierField = document.getElementById("multiplier");
                multiplierField.textContent = `Multiplier: ${multiplier.toFixed(2)}x`;
            }


            function revealAllCells() {
                const cells = document.querySelectorAll(".cell");
                for (let cell of cells) {
                    const row = parseInt(cell.dataset.row);
                    const col = parseInt(cell.dataset.col);

                    if (!cell.classList.contains("revealed")) {
                        if (!cell.classList.contains("mine")) { // Exclude mines from gray-out
                            cell.classList.add("revealed");
                            cell.classList.add("unrevealed"); // Add unrevealed class to gray out cells
                            cell.style.opacity = 0.3; // Set opacity to gray out cells
                        }
                        if (mines.some(mine => mine.row === row && mine.col === col)) {
                            cell.classList.add("mine");
                            const mineImage = document.createElement("img");
                            mineImage.src = "Logo/Bomb2.png";
                            mineImage.alt = "Mine";
                            mineImage.classList.add("revealed");
                            cell.appendChild(mineImage);
                        } else {
                            cell.style.backgroundColor = "#000000"; // Change background color
                            const safeImage = document.createElement("img");
                            safeImage.src = "Logo/Chip_grønn.png";
                            safeImage.alt = "Safe";
                            safeImage.classList.add("revealed");
                            cell.appendChild(safeImage);
                        }
                    }
                }
            }

            function revealAllMines() {
                const cells = document.querySelectorAll(".cell");
                for (let cell of cells) {
                    const row = parseInt(cell.dataset.row);
                    const col = parseInt(cell.dataset.col);
                    if (mines.some(mine => mine.row === row && mine.col === col)) {
                        cell.classList.add("mine");
                        const mineImage = document.createElement("img");
                        mineImage.src = "Logo/Bomb2.png";
                        mineImage.alt = "Mine";
                        mineImage.classList.add("revealed");
                        cell.appendChild(mineImage);
                    }
                    cell.removeEventListener("click", revealCell); // Remove click event listeners
                }
                if (!cashOutClicked) {
                    resetGame(); // Reset the game if cash-out was not clicked
                }
                cells.forEach(cell => {
                    cell.classList.add("revealed");
                });
            }



            function cashOut() {
                if (gameStarted && cellsClicked) {
                    if (!minesHit()) {
                        let coinsToReceive;
                        let currentMultiplier; // Store the current multiplier
                        if (points < multiplierSystems[selectedMineCount].length) {
                            currentMultiplier = multiplierSystems[selectedMineCount][points]; // Store the current multiplier
                            coinsToReceive = document.getElementById("coinsToSpend").value * currentMultiplier;
                        } else {
                            // If all cells are correct, use the last multiplier
                            currentMultiplier = multiplierSystems[selectedMineCount][multiplierSystems[selectedMineCount].length - 1]; // Store the current multiplier
                            coinsToReceive = document.getElementById("coinsToSpend").value * currentMultiplier;
                        }
                        coins += coinsToReceive; // Award coins based on the multiplier
                        document.getElementById("coinCount").textContent = formatCoinCount(coins);
                        // Play the cashout sound
                        const cashoutSound = document.getElementById("cashoutSound");
                        cashoutSound.play();
                        // Display the popup with multiplier and coins cashed out
                        document.getElementById("popup-multiplier").textContent = currentMultiplier.toFixed(2) + "x"; // Display the correct multiplier
                        document.getElementById("popup-coins").textContent = formatCoinCount(coinsToReceive);
                        document.getElementById("popup").style.display = "block";
                        points++; // Increment points to match the next cell to be clicked
                    }
                    revealAllCells(); // Reveal all cells and end the game
                    hideCashOutButton(); // Hide the cash-out button
                    showResetButton(); // Show the reset button
                } else {
                }
            }


            // Function to close the popup
            function closePopup() {
                document.getElementById("popup").style.display = "none";
            }

            // Function to check if any mines were hit
            function minesHit() {
                const cells = document.querySelectorAll(".cell");
                for (let cell of cells) {
                    if (cell.classList.contains("mine")) {
                        return true;
                    }
                }
                return false;
            }



            function resetGame() {
                gameStarted = false; // Reset the game flag
                mineCountDropdown.disabled = false;
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
                const resetSound = document.getElementById("resetSound");
                resetSound.play();
            }


            // Add an event listener to handle changes in the dropdown menu
            mineCountDropdown.addEventListener("change", function () {
                // Ensure the dropdown is disabled when the game has started
                if (gameStarted) {
                    mineCountDropdown.disabled = true;
                }
            });

            // Event listener for the "Add All Coins" button
            document.getElementById("addRemainingCoinsButton").addEventListener("click", addAllCoins);

            function addAllCoins() {
                const availableCoins = Math.floor(coins * 100) / 100; // Round down to two decimal places
                document.getElementById("coinsToSpend").value = availableCoins.toFixed(2); // Display the available coins in the input field
                coinsToSpendInput.value = coins.toFixed(2);
            }



            // Function to hide the cash-out button
            function hideCashOutButton() {
                const cashOutButton = document.getElementById("startButton");
                cashOutButton.style.display = "none";
            }

            // Function to show the cash-out button
            function showCashOutButton() {
                const cashOutButton = document.getElementById("startButton");
                cashOutButton.style.display = "block";
            }

            // Function to show the reset button
            function showResetButton() {
                const resetButton = document.getElementById("resetButton");
                resetButton.style.display = "block";
            }

            // Function to hide the reset button
            function hideResetButton() {
                const resetButton = document.getElementById("resetButton");
                resetButton.style.display = "none";
            }



            initializeGame();
        </script>
    </body>

    </html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>