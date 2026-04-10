<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
    <title>Soumission du vote - Élections au conseil de faculté </title>  
  </head>

<body>

  <?php

    $conn = mysql_connect("Localhost","lamm2102","wyxndg5d");

    if (!$conn) 
      {
      die('Connexion impossible : '.mysql_error());
      }

    $identifiant = mysql_escape_string($_POST['numero_identification']);
    $choix = mysql_escape_string($_POST['choix_candidat']);

    // Formulation de la requête
    // C'est la meilleur façon d'exécuter une requête SQL
    // Pour plus d'exemples, voir mysql_real_escape_string()
    $query = sprintf("SELECT id, has_voted FROM lamm2102.logins_elections WHERE id = '$identifiant'");

    // Exécution de la requête
    $result = mysql_query($query);
    $donnees = mysql_fetch_array($result);

    // Vérification du résultat
    // Ceci montre la requête envoyée à MySQL ainsi que l'erreur. Utile pour déboguer.
    if (!$result) 
      {
      $message = 'Requête invalide : ' . mysql_error() . "\n";
      $message .= 'Requête complète : ' . $query;
      die($message); 
      }

    $nb_resultats = mysql_num_rows($result);
    if ($nb_resultats == 0) 
      {
      echo 'Cet identifiant n\'est pas valide. Veuillez recommencer.';
      }
    else 
      {
      if ($donnees['has_voted'] == '1') 
        {
        echo 'Votre vote à déjà été enregistré. <br>Il ne vous est plus possible de voter.<br> <h3>Merci d\'avoir pris le temps de voter!</h3>';
        }
      else 
        {
        $query=sprintf("UPDATE lamm2102.resultats_elections SET nb_votes=nb_votes+1 WHERE nom = '$choix'");
        $result=mysql_query($query);
        if (!$result) 
          {
          $message = 'Requête invalide : ' . mysql_error() . "\n";
          $message .= 'Requête complète : ' . $query;
          die($message);
          }
        else
          {
          $query=sprintf("UPDATE lamm2102.logins_elections SET has_voted='1',date=now() WHERE id = '$identifiant'");
          $result=mysql_query($query);
          if (!$result) 
            {
            $message = 'Requête invalide : ' . mysql_error() . "\n";
            $message .= 'Requête complète : ' . $query;
            die($message);
            }
          else
            {
            echo 'Vos données ont bien été transmises.<br><b>Numéro identification :</b> '.$identifiant.'<br><b>Candidat :</b> '.$choix.'<br>';
            echo '<h3>Merci d\'avoir pris le temps de voter!</h3>';
            }
          }
        }
      }
  ?>
 
</body>

</html>

 

<?php
mysql_free_result($result);
mysql_close($link);
?> 