<!DOCTYPE html>
<html>

<head>
     <title>Registrer</title>
     <link rel="stylesheet" type="text/css" href="style.css">
     <link rel="icon" type="image/x-icon" href="Logo/Favicon.png">x
</head>

<body style="background-color:#2B3D5D">
     <form action="signup-check.php" method="post">
          <h2>BigWin | Registrer</h2>
          <?php if (isset($_GET['error'])) { ?>
               <p class="error"><?php echo $_GET['error']; ?></p>
          <?php } ?>

          <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
          <?php } ?>

          <label>Navn</label>
          <?php if (isset($_GET['name'])) { ?>
               <input type="text" name="name" placeholder="Navn" value="<?php echo $_GET['name']; ?>"><br>
          <?php } else { ?>
               <input type="text" name="name" placeholder="Navn"><br>
          <?php } ?>

          <label>Brukernavn</label>
          <?php if (isset($_GET['uname'])) { ?>
               <input type="text" name="uname" placeholder="Brukernavn" value="<?php echo $_GET['uname']; ?>"><br>
          <?php } else { ?>
               <input type="text" name="uname" placeholder="Brukernavn"><br>
          <?php } ?>


          <label>Passord</label>
          <input type="password" name="password" placeholder="Passord"><br>

          <label>Skriv passord på nytt</label>
          <input type="password" name="re_password" placeholder="Gjenta Passord"><br>

          <button type="submit">Registrer</button>
          <a href="index.php" class="ca">Har du bruker, Logg inn her!</a>
     </form>
</body>

</html>