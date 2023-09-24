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
                    <option value="1">1 Mine</option>
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
                    <option value="24">24 Mines</option>
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

    <audio id="coinSound" src="Sound/Coin Sound.mp3"></audio>
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
            1: [1, 1.01, 1.08, 1.12, 1.18, 1.24, 1.30, 1.37, 1.46, 1.55, 1.65, 1.77, 1.90, 2.06, 2.25, 2.47, 3.09, 3.54, 4.12, 4.95, 6.19, 8.25, 12.38, 24.75],
            2: [1],
            3: [1],
            4: [1],
            5: [1, 1.24, 1.56, 2.00, 2.58, 3.39, 4.52, 6.14, 8.50, 12.04, 17.52, 26.27, 40.87, 66.41, 113.85, 208.72, 417.45, 939.26, 2504.00, 8766.00, 52598.99], // For 5 mines
            6: [1],
            7: [1],
            8: [1],
            9: [1],
            10:[0.18, 0.18, 0.24, 0.24, 0.30, 0.30, 0.36, 0.36, 0.42, 0.42], // For 10 mines
            // Add more systems for different mine counts if needed
        };
        let selectedMineCount = parseInt(mineCountDropdown.value);

        mineCountDropdown.addEventListener("change", function () {
            selectedMineCount = parseInt(mineCountDropdown.value);
            updateMultiplier(); // Update the multiplier based on the selected mine count
        });

        let mines = [];
        let points = 0;
        let coins = 10; // Initial number of coins
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
                    document.getElementById("coinsToSpend").disabled = true; // Disable the input
                    document.getElementById("startButton").textContent = "Cash Out"; // Change button text
                    document.getElementById("startButton").classList.add("cash-out-disabled"); // Add the disabled class
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

            if (!multiplierVisible) {
                // Show the multiplier if it's not visible
                multiplierField.style.display = "block";
                multiplierVisible = true;
            }
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
                    const coinsToReceive = document.getElementById("coinsToSpend").value * multiplier;
                    coins += coinsToReceive; // Award coins based on the multiplier
                    document.getElementById("coinCount").textContent = formatCoinCount(Math.floor(coins * 100) / 100);
                    // Play the cashout sound
                    const cashoutSound = document.getElementById("cashoutSound");
                    cashoutSound.play();
                    // Display the popup with multiplier and coins cashed out
                    document.getElementById("popup-multiplier").textContent = multiplier.toFixed(2) + "x";
                    document.getElementById("popup-coins").textContent = formatCoinCount(coinsToReceive);
                    document.getElementById("popup").style.display = "block";
                }
                revealAllCells(); // Reveal all cells and end the game
                hideCashOutButton(); // Hide the cash-out button
                showResetButton(); // Show the reset button
            } else {
                alert("You must click at least one cell before cashing out.");
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
    <script>

        includeHTML();

    </script>



</body>

</html>