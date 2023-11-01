<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Blackjack Game</title>
        <link rel="stylesheet" href="bj.css">
        <link rel="stylesheet" href="nav.css">
        <link rel="icon" type="image/x-icon" href="Logo/Favicon.png">
    </head>

    <script src="jonsfiler/jquery-3.7.1.min.js"></script>

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
                    <div id="coinCount"></div>
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
            <div>
                <div class="buttons">
                    <p class="error-message" id="errorMessage"></p>
                    <div id="boxforinp">
                        <input type="number" id="coinsToSpend" placeholder="Enter coins">
                    </div>
                    <div class="hitstand">
                        <button id="hit-button">Hit</button>
                        <button id="stand-button">Stand</button>
                    </div>
                    <div class="deal">
                        <button id="deal-button">Deal</button>
                    </div>
                </div>
            </div>
            <div id="container">
                <div id="game">
                    <div id="dealer">
                        <div class="counter" id="dealer-counter"></div>
                        <div id="dealer-hand" class="hand"></div>
                    </div>
                    <div id="player">
                        <div class="counter" id="player-counter"></div>
                        <div id="player-hand" class="hand"></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <p>Not enough coins to start the game.</p>
                <button id="Deposit" onclick="location.href = 'Penger.php';">Deposit</button>
            </div>
        </div>



        <script src="mines.js"></script>

        <script>
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
            const suits = ["Hearts", "Diamonds", "Clubs", "Spades"];
            const ranks = ["2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K", "A"];

            let deck = [];
            let playerHand = [];
            let dealerHand = [];

            const playerHandElement = document.getElementById("player-hand");
            const dealerHandElement = document.getElementById("dealer-hand");
            const playerCounterElement = document.getElementById("player-counter");
            const dealerCounterElement = document.getElementById("dealer-counter");
            const dealButton = document.getElementById("deal-button");
            const hitButton = document.getElementById("hit-button");
            const standButton = document.getElementById("stand-button");
            let dealerCardHidden = true; // Dealer's first card is hidden.
            hitButton.disabled = true;
            standButton.disabled = true;

            function formatCoinCount(coins) {
                return parseFloat(coins.toFixed(2));
            }

            function createDeck() {
                for (let suit of suits) {
                    for (let rank of ranks) {
                        deck.push({ suit, rank });
                    }
                }
            }

            function shuffleDeck() {
                for (let i = deck.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [deck[i], deck[j]] = [deck[j], deck[i]];
                }
            }


            // Update the dealInitialCards function to deal face-down cards and flip them
            function dealInitialCards() {
                if (deck.length < 4) {
                    // If there are fewer than 4 cards left, reshuffle the deck.
                    createDeck();
                    shuffleDeck();
                }

                // Clear previous cards only when the game is redealt.
                dealButton.disabled = true;
                playerHand = [];
                dealerHand = [];
                dealerCardHidden = true; // Reset dealer's first card as hidden.

                const dealInterval = setInterval(() => {
                    if (playerHand.length < 2) {
                        // Deal one face-down card to the player
                        if (deck.length === 0) {
                            // If the deck is empty, reshuffle the deck.
                            createDeck();
                            shuffleDeck();
                        }
                        playerHand.push(deck.pop());
                        renderHands();
                    } else if (dealerHand.length < 2) {
                        // Deal one face-down card to the dealer
                        if (deck.length === 0) {
                            // If the deck is empty, reshuffle the deck.
                            createDeck();
                            shuffleDeck();
                        }
                        dealerHand.push(deck.pop());
                        renderHands();
                        // Flip the dealer's face-down card after a delay
                        setTimeout(() => {
                            dealerCardHidden = false;
                            renderHands();
                        }, 1000);
                    } else {
                        // Both player and dealer have two cards, stop dealing
                        clearInterval(dealInterval);
                        hitButton.disabled = false;
                        standButton.disabled = false;

                        // Check if the player has blackjack
                        checkPlayerBlackjack();
                    }
                }, 1000); // Adjust the interval as needed (in milliseconds)
            }





            // Function to check if the player has blackjack (initial hand value of 21)
            function checkPlayerBlackjack() {
                if (calculateHandValue(playerHand) === 21) {
                    dealerCardHidden = false;
                    renderHands();
                    if (calculateHandValue(dealerHand) === 21) {
                        endGame("It's a push!");
                    } else {
                        endGame("You win!");
                    }
                }
            }


            function renderHands() {
                playerHandElement.innerHTML = playerHand.map(card => getCardImageURL(card)).join('');
                dealerHandElement.innerHTML = dealerHand.map((card, index) => getCardImageImageHTML(card, index)).join('');

                // Calculate the total of the dealer's hand based on the shown cards
                const dealerShownCards = dealerHand.slice(dealerCardHidden ? 1 : 0); // Start from the hidden card if it's hidden
                dealerCounterElement.textContent = `Total: ${calculateHandValue(dealerShownCards)}`;
                playerCounterElement.textContent = `Total: ${calculateHandValue(playerHand)}`;
            }




            function getCardImageURL(card) {
                const suitSymbol = getSuitSymbol(card.suit);
                const rankSymbol = getRankSymbol(card.rank);

                return `<img class="card-image" src="Cards/${rankSymbol}${suitSymbol}.png" alt="${card.rank} of ${card.suit}">`;
            }

            function getCardImageImageHTML(card, index) {
                const suitSymbol = getSuitSymbol(card.suit);
                const rankSymbol = getRankSymbol(card.rank);
                const cardImageHTML = `<img class="card-image" src="Cards/${rankSymbol}${suitSymbol}.png" alt="${card.rank} of ${card.suit}">`;

                // If the dealer's first card is hidden, show the back of the card.
                if (index === 0 && dealerCardHidden) {
                    return '<img class="card-image" src="Cards/bak.png" alt="Card Back">';
                }

                return cardImageHTML;
            }

            function getSuitSymbol(suit) {
                switch (suit) {
                    case "Hearts":
                        return "H";
                    case "Diamonds":
                        return "D";
                    case "Clubs":
                        return "C";
                    case "Spades":
                        return "S";
                }
            }

            function getRankSymbol(rank) {
                return rank === "10" ? "T" : rank;
            }

            function calculateHandValue(hand) {
                let value = 0;
                let hasAce = false;

                for (let card of hand) {
                    if (card.rank === "A") {
                        hasAce = true;
                    }
                    if (card.rank === "K" || card.rank === "Q" || card.rank === "J") {
                        value += 10;
                    } else if (card.rank === "A") {
                        value += 11;
                    } else {
                        value += parseInt(card.rank);
                    }
                }

                if (hasAce && value > 21) {
                    value -= 10; // Convert one Ace from 11 to 1.
                }

                return value;
            }

            function endGame(outcome) {
                let coinsToReceive = document.getElementById("coinsToSpend").value * 1;
                dealerCardHidden = false;
                renderHands();

                if (outcome === "You Lost") {
                    const playerCardImages = playerHandElement.querySelectorAll('.card-image');
                    playerCardImages.forEach(image => image.classList.add('player-loose-card'));
                } else if (outcome === "You win!") {
                    coinsToReceive = document.getElementById("coinsToSpend").value * 2;
                    const playerCardImages = playerHandElement.querySelectorAll('.card-image');
                    playerCardImages.forEach(image => image.classList.add('player-win-card'));
                    changeCoins(coinsToReceive); // Award coins based on the multiplier
                } else if (outcome === "It's a push!") {
                    const playerCardImages = playerHandElement.querySelectorAll('.card-image');
                    playerCardImages.forEach(image => image.classList.add('player-push-card'));
                    changeCoins(coinsToReceive); // Award coins based on the multiplier
                }

                hitButton.disabled = true;
                standButton.disabled = true;
                dealButton.disabled = false;
            }

            function checkPlayerWin() {
                const playerValue = calculateHandValue(playerHand);
                const dealerValue = calculateHandValue(dealerHand);

                if (playerValue === 21) {
                    if (dealerValue === 21) {
                        endGame("It's a push!");
                    } else {
                        endGame("You win!");
                    }
                    document.getElementById("coinsToSpend").disabled = false; // Enable the input
                }
            }



            createDeck();
            shuffleDeck();
            renderHands();



            // Event listener for the "Deal" button
            dealButton.addEventListener("click", () => {
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
                    document.getElementById("coinsToSpend").disabled = true; // Disable the input
                    dealInitialCards();
                }
            });



            hitButton.addEventListener("click", () => {
                if (playerHand.length < 5) {
                    if (deck.length === 0) {
                        createDeck();
                        shuffleDeck();
                    }
                    playerHand.push(deck.pop());
                    renderHands();
                    if (calculateHandValue(playerHand) > 21) {
                        endGame("You Lost");
                        document.getElementById("coinsToSpend").disabled = false; // Enable the input
                    }
                    checkPlayerWin();
                }
            });

            standButton.addEventListener("click", () => {
                while (calculateHandValue(dealerHand) < 17) {
                    if (deck.length === 0) {
                        // If the deck is empty, reshuffle the deck.
                        createDeck();
                        shuffleDeck();
                    }
                    dealerHand.push(deck.pop());
                }
                renderHands();

                if (calculateHandValue(dealerHand) > 21 || calculateHandValue(playerHand) > calculateHandValue(dealerHand)) {
                    endGame("You win!");
                    document.getElementById("coinsToSpend").disabled = false; // Enable the input
                } else if (calculateHandValue(playerHand) < calculateHandValue(dealerHand)) {
                    endGame("You Lost");
                    document.getElementById("coinsToSpend").disabled = false; // Enable the input
                } else {
                    endGame("It's a push!");
                    document.getElementById("coinsToSpend").disabled = false; // Enable the input
                }
            });
        </script>
    </body>

    </html>

    <?php
} else {
    header("Location: index.php");
    exit();
}
?>