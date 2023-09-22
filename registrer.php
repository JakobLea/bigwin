<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.4.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.4.0/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
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
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
        CreateRequest request = new CreateRequest()
    .setEmail("user@example.com")
    .setEmailVerified(false)
    .setPassword("secretPassword")
    .setPhoneNumber("+11234567890")
    .setDisplayName("John Doe")
    .setPhotoUrl("http://www.example.com/12345678/photo.png")
    .setDisabled(false);

UserRecord userRecord = FirebaseAuth.getInstance().createUser(request);
System.out.println("Successfully created new user: " + userRecord.getUid());
    </script>

</body>
</html>