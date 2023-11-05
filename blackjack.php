<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>BigWin | Blackjack</title>
        <link rel="stylesheet" href="bj.css">
        <link rel="stylesheet" href="nav.css">
        <link rel="icon" type="image/x-icon" href="Logo/Favicon.png">
    </head>

    <script src="jonsfiler/jquery-3.7.1.min.js"></script>

    <body style="background-color:#2B3D5D">
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
                    <a href="dice.php" class="nav-link">Dice</a>
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

        <!--Selve brettet til spillet-->
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
            // Funksjon for å endre antall mynter (knyttet til spillersaldo)
            function changeCoins(changeBy) {
                var coinsChanged = document.getElementById("coins").innerHTML;

                // Funksjon for å hente gjeldende myntsaldo
                coinsChanged = parseInt(coinsChanged) + changeBy;

                document.cookie = "coins=" + coinsChanged + "; max-age=5; path=/";
                $("#coinCount").load("updateCoins.php");
            }

            // Funksjon for å hente gjeldende myntsaldo
            function getCoins() {
                var gottenCoins = document.getElementById("coins").innerHTML;

                return gottenCoins;
            }


            // Definisjon av kortstokk
            const suits = ["Hearts", "Diamonds", "Clubs", "Spades"];
            const ranks = ["2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K", "A"];

            let deck = [];
            let playerHand = [];
            let dealerHand = [];

            // Henter elementer fra HTML
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

            // Funksjon for å formatere mynttelleren med kun to desimaler
            function formatCoinCount(coins) {
                return parseFloat(coins.toFixed(2));
            }

            // Opprett en ny kortstokk
            function createDeck() {
                for (let suit of suits) {
                    for (let rank of ranks) {
                        deck.push({ suit, rank });
                    }
                }
            }

            // Bland kortstokken
            function shuffleDeck() {
                for (let i = deck.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [deck[i], deck[j]] = [deck[j], deck[i]];
                }
            }


            // Oppdater funksjonen dealInitialCards for å dele ut kort med noen med forsiden ned og andre vist
            function dealInitialCards() {
                if (deck.length < 4) {
                    // Hvis det er færre enn 4 kort igjen, stokk kortstokken på nytt                    
                    createDeck();
                    shuffleDeck();
                }

                // Fjern tidligere kort kun når spillet deles ut på nytt
                dealButton.disabled = true;
                playerHand = [];
                dealerHand = [];
                dealerCardHidden = true; // Tilbakestill den første kortet til dealeren som skjult

                const dealInterval = setInterval(() => {
                    if (playerHand.length === 0) {
                        // Deal deal det første kortet med ansiktet opp til spiller
                        if (deck.length === 0) {
                            // Hvis kortstokken er tom, stokk kortene og del ut på nytt
                            createDeck();
                            shuffleDeck();
                        }
                        playerHand.push(deck.pop());
                        renderHands();
                    } else if (dealerHand.length === 0) {
                        // Deal deal det første kortet med ansiktet ned til dealer for å skule det
                        if (deck.length === 0) {
                            // Hvis kortstokken er tom, stokk kortene og del ut på nytt
                            createDeck();
                            shuffleDeck();
                        }
                        dealerHand.push(deck.pop());
                        renderHands();
                    } else if (playerHand.length === 1) {
                        // Deal det andre kortet til spiller også med aksiktet opp
                        if (deck.length === 0) {
                            // Hvis kortstokken er tom, stokk kortene og del ut på nytt
                            createDeck();
                            shuffleDeck();
                        }
                        playerHand.push(deck.pop());
                        renderHands();
                    } else if (dealerHand.length === 1) {
                        // Deal det andre kortet til dealer med anskiktet opp
                        if (deck.length === 0) {
                            // Hvis kortstokken er tom, stokk kortene og del ut på nytt
                            createDeck();
                            shuffleDeck();
                        }
                        dealerHand.push(deck.pop());
                        renderHands();
                    } else {
                        // Når både dealer og spiller har to kort hver, stop å dele ut
                        clearInterval(dealInterval);
                        hitButton.disabled = false;
                        standButton.disabled = false;

                        // Sjekk om spiller har blackjakc på starten slik at spillet avsluttes med en gang hvis blackjack
                        checkPlayerBlackjack();
                    }
                }, 400); // Tiden mellom utdeling av hvert kort i millisekunder
            }






            // Funksjon for å sjekke om spilleren har blackjack
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

            // Oppdater visningen av kortene på skjermen
            function renderHands() {
                playerHandElement.innerHTML = playerHand.map(card => getCardImageURL(card)).join('');
                dealerHandElement.innerHTML = dealerHand.map((card, index) => getCardImageImageHTML(card, index)).join('');

                // Regn ut totalen av dealer sin hånd basert på kortene som vises
                const dealerShownCards = dealerHand.slice(dealerCardHidden ? 1 : 0);
                dealerCounterElement.textContent = `Total: ${calculateHandValue(dealerShownCards)}`;
                playerCounterElement.textContent = `Total: ${calculateHandValue(playerHand)}`;
            }



            // Henter kortbildene 
            function getCardImageURL(card) {
                const suitSymbol = getSuitSymbol(card.suit);
                const rankSymbol = getRankSymbol(card.rank);

                return `<img class="card-image" src="Cards/${rankSymbol}${suitSymbol}.png" alt="${card.rank} of ${card.suit}">`;
            }

            // funksjonen for å hente HTML til kortbildene inkludert baksiden
            function getCardImageImageHTML(card, index) {
                const suitSymbol = getSuitSymbol(card.suit);
                const rankSymbol = getRankSymbol(card.rank);
                const cardImageHTML = `<img class="card-image" src="Cards/${rankSymbol}${suitSymbol}.png" alt="${card.rank} of ${card.suit}">`;

                // Hvis dealeren sitt første kort er skjult skal det vises ett bilde av baksiden av kortet
                if (index === 0 && dealerCardHidden) {
                    return '<img class="card-image" src="Cards/bak.png" alt="Card Back">';
                }

                return cardImageHTML;
            }

            // Funksjon for å få symbolet for en kortfarge
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

            // Funksjon for å få symbolet for en kortverdi.
            function getRankSymbol(rank) {
                return rank === "10" ? "T" : rank;
            }

            // Funksjon for å legge sammen verdien av en hånd
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
                    value -= 10; // Gjør om ess til 1 hvis kortenes verdi er over 21
                }

                return value;
            }

            // Funksjon for å avslutte spillet og håndtere resultatene
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
                    changeCoins(coinsToReceive); // Gi mynter tilbake bastert på multiplier som er 2x
                } else if (outcome === "It's a push!") {
                    const playerCardImages = playerHandElement.querySelectorAll('.card-image');
                    playerCardImages.forEach(image => image.classList.add('player-push-card'));
                    changeCoins(coinsToReceive); // Gi mynter tilbake bastert på multiplier som er 1x
                }

                hitButton.disabled = true;
                standButton.disabled = true;
                dealButton.disabled = false;
            }

            // Sjekker om spiller har vunnet med blackjack
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


            // lag, stokk og del ut kortene
            createDeck();
            shuffleDeck();
            renderHands();



            // Legger til forskjellige hendelser for deal knappen
            dealButton.addEventListener("click", () => {
                const coinsToSpendInput = document.getElementById("boxforinp");
                const errorMessage = document.getElementById("errorMessage");

                // Hvis brukeren taster inn ett tall likt som eller under 0, eller skriver ett tall med mer enn 2 desimaler, display en error melding
                const coinsToSpend = parseFloat(document.getElementById("coinsToSpend").value);
                if (isNaN(coinsToSpend) || coinsToSpend <= 0 || coinsToSpend.toString().split(".")[1]?.length > 2) {
                    errorMessage.style.display = "block";
                    coinsToSpendInput.classList.add("error");
                    coinsToSpendInput.style.border = "2px solid red";
                    errorMessage.textContent = "Invalid Number.";
                } else if (coinsToSpend > getCoins()) { //hvis brukeren taster inn ett tall høyere enn det de har på brukeren, så dukker det opp en popup med mulighete til å legge til mere coins
                    // Skjul error meldingen, men behold den røde kanten
                    errorMessage.style.display = "none";
                    coinsToSpendInput.style.border = "2px solid red";
                    // vis popupen med knapp til å legge til mer coins
                    const modal = document.getElementById("myModal");
                    modal.style.display = "block";

                    // Lukk popupen npr man trykker utenfor boksen
                    window.onclick = function (event) {
                        if (event.target === modal) {
                            modal.style.display = "none";
                        }
                    };
                } else {
                    errorMessage.style.display = "none";
                    coinsToSpendInput.style.border = "";
                    changeCoins(-coinsToSpend); // Hvis ett godjent nummer skrives inn trekkes det fra brukeren sine coins
                    document.getElementById("coinsToSpend").disabled = true; // Deaktivere input-feltet frem til spillet er over.
                    dealInitialCards(); // del ut kortene og spillet starter.
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
                        endGame("You Lost"); //hvis spillerhånd har mer enn 21 taper spilleren
                        document.getElementById("coinsToSpend").disabled = false; 
                    }
                    checkPlayerWin();
                }
            });

            standButton.addEventListener("click", () => {
                while (calculateHandValue(dealerHand) < 17) {
                    if (deck.length === 0) {
                        // Hvis kortstokken er tom, stokk kortene
                        createDeck();
                        shuffleDeck();
                    }
                    dealerHand.push(deck.pop());
                }
                renderHands();

                if (calculateHandValue(dealerHand) > 21 || calculateHandValue(playerHand) > calculateHandValue(dealerHand)) {
                    endGame("You win!");
                    document.getElementById("coinsToSpend").disabled = false; 
                } else if (calculateHandValue(playerHand) < calculateHandValue(dealerHand)) {
                    endGame("You Lost");
                    document.getElementById("coinsToSpend").disabled = false; 
                } else {
                    endGame("It's a push!");
                    document.getElementById("coinsToSpend").disabled = false; 
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