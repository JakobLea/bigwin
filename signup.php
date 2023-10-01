<!DOCTYPE html>
<html>

<head>
     <title>Registrer</title>
     <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
     <form action="signup-check.php" method="post">
          <h2>Registrer</h2>
          <?php if (isset($_GET['error'])) { ?>
               <p class="error"><?php echo $_GET['error']; ?></p>
          <?php } ?>

          <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
          <?php } ?>

          <label>Navn</label>
          <?php if (isset($_GET['name'])) { ?>
               <input type="text" name="name" placeholder="Name" value="<?php echo $_GET['name']; ?>"><br>
          <?php } else { ?>
               <input type="text" name="name" placeholder="Name"><br>
          <?php } ?>

          <label>Brukernavn</label>
          <?php if (isset($_GET['uname'])) { ?>
               <input type="text" name="uname" placeholder="User Name" value="<?php echo $_GET['uname']; ?>"><br>
          <?php } else { ?>
               <input type="text" name="uname" placeholder="User Name"><br>
          <?php } ?>


          <label>passord</label>
          <input type="password" name="password" placeholder="Password"><br>

          <label>Skriv passord på nytt</label>
          <input type="password" name="re_password" placeholder="Re_Password"><br>

          <button type="submit">Registrer</button>
          <a href="index.php" class="ca">Har du bruker, Logg inn her!</a>
     </form>
</body>

</html>