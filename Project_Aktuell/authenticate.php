<?php
 session_start();
 /**
  *  Datenbankverbindung wird abgefragt
  */
 require_once('connect.php'); 
 /**
  * Logindaten werden aus der Datenbank geladen und mit dem eingegeben aus dem Frontend verglichen
  */
 if ( !isset($_POST['username'], $_POST['password'] )) exit($_SESSION['infoMsg'] = "Bitte Benutzername und Passwort eingeben!"); 
 if ($abfrage=$connect->prepare('SELECT ID, passwort, active2FA FROM benutzer WHERE eMail=?'))
 {
  $abfrage->bind_param('s',$_POST['username']);
  $abfrage->execute();
  $abfrage->store_result();
if ($abfrage->num_rows > 0) 
 {
  $abfrage->bind_result($id, $password, $active2FA);
  $abfrage->fetch();
  if (password_verify($_POST['password'], $password)) 
   { 
    session_regenerate_id(); 
    $_SESSION['loggedin'] = TRUE; 
    $_SESSION['name'] = $_POST['username']; 
    $_SESSION['id'] = $id;

    if($active2FA)
    {
      header('Location: verify_Anzeige.php');
    }else {
    header('Location: startseite.php');
    }
   } 
  else 
   { 
    $_SESSION['infoMsg'] = "Leider ist entweder der Benutzername oder das Passwort falsch."; 
    header('Location: index.php');
   }
  } 
 else 
  { 
    $_SESSION['infoMsg'] = "Leider ist entweder der Benutzername oder das Passwort falsch."; 
    header('Location: index.php');
  }
 $abfrage->close();
}
?>