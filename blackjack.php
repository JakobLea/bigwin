<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="Logo/Favicon.png">
    <title>Blackjack Game</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="bj.css">
    <style>
        .container {
            text-align: center;
        }

        #message {
            font-size: 24px;
            margin-bottom: 10px;
        }

        #cards {
            font-size: 18px;
        }
    </style>
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
            <div>
                <button class="velg" id="deal-button">Deal</button>
                <button class="velg" id="hit-button">Hit</button>
                <button class="velg" id="stand-button">Stand</button> 
            </div>


            <div>
                <button id="startButton" onclick="startGame()">Start Game</button>
                <button id="resetButton" style="display:none;">Reset</button>
            </div>
            <div id="multiplier" style="display: none;">Multiplier: 1x</div>
        </div>

        <!-- <button onclick="changeCoins(5)">Trykk</button> -->

        <div class="container" id="container">
            <div class="container">
                <h1>Blackjack Game</h1>
                <div id="message">Welcome to Blackjack!</div>
                <div id="cards">
                    <div id="dealer"></div>
                    <div id="player"></div>
                    <!-- Player: <span id="player-hand"></span><br>
                    Dealer: <span id="dealer-hand"></span> -->
                </div>
            </div>
        </div>
        <div></div>
    </div>

    <script>
        // Define the card values
        const cardValues = [
            '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'
        ];

        // Create a deck of cards
        let deck = [];
        for (let i = 0; i < cardValues.length; i++) {
            for (let j = 0; j < 4; j++) {
                deck.push(cardValues[i]);
            }
        }

        // Initialize hands
        let playerHand = [];
        let dealerHand = [];

        // Shuffle the deck
        function shuffleDeck() {
            for (let i = deck.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [deck[i], deck[j]] = [deck[j], deck[i]];
            }
        }

        // Deal two cards to a hand
        function dealHand(hand) {
            hand.push(deck.pop());
            hand.push(deck.pop());
        }

        // Calculate the hand value
        function calculateHandValue(hand) {
            let sum = 0;
            let numAces = 0;

            for (const card of hand) {
                if (card === 'A') {
                    numAces++;
                    sum += 11;
                } else if (card === 'K' || card === 'Q' || card === 'J') {
                    sum += 10;
                } else {
                    sum += parseInt(card);
                }
            }

            while (sum > 21 && numAces > 0) {
                sum -= 10;
                numAces--;
            }

            return sum;
        }

        // Display hands
        function displayHands() {
            document.getElementById('player').textContent = playerHand.join(', ');
            document.getElementById('dealer').textContent = dealerHand[0] + ', ?';
        }

        // Check for a win, lose, or draw
        function checkResult() {
            const playerValue = calculateHandValue(playerHand);
            const dealerValue = calculateHandValue(dealerHand);

            if (playerValue > 21) {
                return 'You busted! Dealer wins.';
            }

            if (dealerValue > 21) {
                return 'Dealer busted! You win.';
            }

            if (playerValue === 21 && playerHand.length === 2) {
                return 'Blackjack! You win.';
            }

            if (dealerValue === 21 && dealerHand.length === 2) {
                return 'Dealer has blackjack. Dealer wins.';
            }

            if (playerValue > dealerValue) {
                return 'You win!';
            } else if (playerValue < dealerValue) {
                return 'Dealer wins.';
            } else {
                return 'It\'s a draw!';
            }
        }

        // Initialize the game
        function startGame() {
            shuffleDeck();
            playerHand = [];
            dealerHand = [];
            dealHand(playerHand);
            dealHand(dealerHand);
            displayHands();
            document.getElementById('message').textContent = 'Your turn. Hit or Stand?';
            document.getElementById('deal-button').disabled = true;
            document.getElementById('hit-button').disabled = false;
            document.getElementById('stand-button').disabled = false;
        }

        // Deal button click event
        document.getElementById('deal-button').addEventListener('click', startGame);

        // Hit button click event
        document.getElementById('hit-button').addEventListener('click', () => {
            playerHand.push(deck.pop());
            displayHands();

            const playerValue = calculateHandValue(playerHand);
            if (playerValue > 21) {
                document.getElementById('message').textContent = 'You busted! Dealer wins.';
                endGame();
            }
        });

        // Stand button click event
        document.getElementById('stand-button').addEventListener('click', () => {
            document.getElementById('message').textContent = 'Dealer\'s turn.';

            while (calculateHandValue(dealerHand) < 17) {
                dealerHand.push(deck.pop());
            }

            displayHands();

            const result = checkResult();
            document.getElementById('message').textContent = result;
            endGame();
        });

        // End the game and disable buttons
        function endGame() {
            document.getElementById('deal-button').disabled = false;
            document.getElementById('hit-button').disabled = true;
            document.getElementById('stand-button').disabled = true;
        }

        // Initial setup
        startGame();
    </script>
</body>

</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>