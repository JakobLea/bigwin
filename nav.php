<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document test</title>
    <link rel="stylesheet" href="/bigwin/nav.css" />
</head>

<script>
    import { initializeApp } from "firebase/app";
    import { getDatabase } from "firebase/database";

    // const database = getDatabase();

    var firebaseConfig = {
    apiKey: "AIzaSyB3PWjhLgvX8yvbA3OcJP3qoS3-tp8d_BU",
    authDomain: "bigwin-a63cb.firebaseapp.com",
    databaseURL: "https://bigwin-a63cb-default-rtdb.europe-west1.firebasedatabase.app",
    projectId: "bigwin-a63cb",
    storageBucket: "bigwin-a63cb.appspot.com",
    messagingSenderId: "524008852003",
    appId: "1:524008852003:web:e9cdcf404ae8e1fc16bf96",
    measurementId: "G-6FVGVMWTFW"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  // Initialize variables
  const auth = firebase.auth()
  const database = firebase.database()

  const db = getDatabase();
const coinsdb = ref(db, 'users/' + user.uid + '/coins');
onValue(coinsdb, (snapshot) => {
  var coin = snapshot.val();
  updateStarCount(postElement, data);

console.log("hei" + coin)
});
  


  document.getElementById("coins").innerHTML = "coin";
</script>

<body>
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
                <div id="coinCount"><p id="coins">10</p></div>
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