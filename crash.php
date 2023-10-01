
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gambling Room</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="styles/style2.css">

    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
</head>

<body>
    <main>
        <form id="form" action="crash.php" method="post">
            <article class="wrapper">
                <header>
                    <button type="button" id="menu-btn" onclick="location.replace('room-selection.php')"></button>
                    <h1><span id="money"></span>
                        <img id="coin-img" src="img/coin.png" alt="-C">
                    </h1>

                </header>
                <div class="container-fluid">
                    <h2>Bet: <input id="betMoney" required style="width:8rem" type="number" min="10" max="<?php echo json_encode($_SESSION["money"]) ?>" value="<?php if (isset($_POST["betMoney"]))
                                                                                                                                                                    echo $_POST["betMoney"];
                                                                                                                                                                else
                                                                                                                                                                    echo "10" ?>" name="betMoney"></h2>
                    <h2 style="position:relative" class="container-fluid">Reward:
                        <input id="numberRange" name="numberRange" type="range" min="2" max="100" value="<?php if (isset($_POST["numberRange"]))
                                                                                                                echo $_POST["numberRange"];
                                                                                                            else
                                                                                                                echo "0" ?>" name="userNumber" />
                        <button id="numberRangeDiv">
                            <?php if (isset($_SESSION["numberRange"]))
                                echo round($reward, 2);
                            else
                                echo 0 ?>
                        </button>
                    </h2>
                </div>
                <button type="submit" style="width:30%">Play</button>
                <footer class="game-footer">
                    <h2 class="container-fluid" style="position:relative">
                        <div id="progress-bar">
                            <progress id="progress" value="0" max="200">
                            </progress>
                            <div id="bet-bar" style="left:<?php echo isset($_SESSION["numberRange"]) ? $_SESSION["numberRange"] - 0.5 :
                                                                "0;display:none" ?>%">
                            </div>
                        </div>

                    </h2>
                </footer>
            </article>
        </form>
    </main>
    <script src="js/crash.js"></script>
    <script>
        const moneyDisplay = document.getElementById("money");
        let money = <?php echo json_encode($_SESSION["money"]); ?>;
        let spin = <?php if (isset($spin))
                        echo json_encode($spin);
                    else
                        echo -99; ?>;
        const progressDisplay = document.getElementById("progress");
        let bet = <?php if (isset($_SESSION["numberRange"]))
                        echo json_encode($_SESSION["numberRange"]); ?>;

        animateProgress();
        let win = <?php echo json_encode($win); ?>;
        moneyDisplay.innerText = (money - win).toFixed(2);
    </script>
</body>

</html>