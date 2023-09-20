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
                <input type="number" id="coinsToSpend" placeholder="Enter coins">
                <button id="startButton" onclick="startGame()">Start Game</button>
                <div><button id="resetButton" style="display:none;">Reset</button></div>
            </div>
        </div>

        <div class="container" id="container"></div>
        <div></div>
    </div>
    <script>
        const gridSize = 5; // Updated to 5 rows and columns
        const numMines = 5; // Adjust as needed
        let mines = [];
        let points = 0;
        let coins = 10; // Initial number of coins
        let gameStarted = false; // Flag to track if the game has started
        let cellsClicked = false; // Flag to track whether a cell has been clicked
        let cashOutClicked = false; // Flag to track if the cash-out button has been clicked
        let multiplier = 1; // Initial multiplier

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

            // Place mines randomly
            for (let i = 0; i < numMines; i++) {
                let row, col;
                do {
                    row = Math.floor(Math.random() * gridSize);
                    col = Math.floor(Math.random() * gridSize);
                } while (mines.some(mine => mine.row === row && mine.col === col));
                mines.push({ row, col });
            }
        }

        function startGame() {
            if (!gameStarted) {
                const coinsToSpend = parseFloat(document.getElementById("coinsToSpend").value);
                if (coinsToSpend <= coins && coinsToSpend > 0) {
                    coins -= coinsToSpend; // Deduct the specified number of coins to start the game
                    document.getElementById("coinCount").textContent = formatCoinCount(coins);
                    gameStarted = true; // Set the game as started
                    enableCells(); // Enable the cells for gameplay
                    document.getElementById("coinsToSpend").disabled = true; // Disable the input
                    document.getElementById("startButton").textContent = "Cash Out"; // Change button text
                    document.getElementById("startButton").classList.add("cash-out-disabled"); // Add the disabled class
                    cellsClicked = false; // Reset cellsClicked flag for the new game
                } else {
                    alert("Invalid number of coins or not enough coins to start.");
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
                alert("Please start the game first!");
                return;
            }

            const row = parseInt(event.target.dataset.row);
            const col = parseInt(event.target.dataset.col);

            if (event.target.classList.contains("revealed")) {
                // Cell is already revealed, do nothing
                return;
            }

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

                // Increase the multiplier by 0.3 for every correct cell clicked
                multiplier += 0.18;

                if (points === gridSize * gridSize - numMines) {
                    cashOutClicked = true; // Set cashOutClicked flag if all cells are correct
                    cashOut();
                }
            }


            cellsClicked = true;

            enableCashOutButton();
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
                    document.getElementById("coinCount").textContent = formatCoinCount(coins);
                    alert(`You've cashed out ${formatCoinCount(coinsToReceive)} coins!`);
                }
                resetGame(); // Reset the game in any case
            } else {
                alert("You must click at least one cell before cashing out.");
            }
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
            document.getElementById("container").innerHTML = "";
            mines = [];
            points = 0;
            multiplier = 1; // Reset the multiplier
            hideResetButton(); // Hide the reset button
            showCashOutButton(); // Show the cash-out button
            initializeGame();
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