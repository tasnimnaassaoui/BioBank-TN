<?php
   //STATISTIQUE DONNEUR
   $stat_donneur=[];
   $req=$conn->query("SELECT COUNT(*) AS total FROM donneur");
   $TD=$req->fetch(PDO::FETCH_ASSOC);
   $total_donneur=$TD['total'];//totale des donneurs
      //% donneurs actifs _% donneurs inactifs
      $req=$conn->query("SELECT etat,COUNT(*) AS total FROM user  
                        WHERE id_user IN(SELECT id_user FROM donneur)
                        GROUP BY etat");
      $donneurs=$req->fetchAll(PDO::FETCH_ASSOC);
      foreach($donneurs as $val){
         if($total_donneur!=0){
          $stat_donneur[$val['etat']]=($val['total']/$total_donneur)*100;
         }else
           $stat_donneur[$val['etat']]=0;
      }

    //STATISTIQUE ALERTE
    $stat_alerte=[];
    $req=$conn->query("SELECT COUNT(*) AS total FROM alertes");
    $TA=$req->fetch(PDO::FETCH_ASSOC);
    $total_alerte=$TA['total'];//total des alertes
      //% des alertes selon le groupe sanguin
      $req=$conn->query("SELECT groupe_sanguin_rhesus,COUNT(*) AS total FROM alertes 
                          GROUP BY  groupe_sanguin_rhesus");
      $alertes=$req->fetchAll(PDO::FETCH_ASSOC);
      foreach($alertes as $val){
         if($total_alerte!=0){
          $stat_alerte[$val['groupe_sanguin_rhesus']]=($val['total']/$total_alerte)*100;
         }else
           $stat_alerte[$val['groupe_sanguin_rhesus']]=0;
      }
    

    //STATISTIQUE NOTIFICATION
    $stat_notif=[];
    $req=$conn->query("SELECT COUNT(*) AS total FROM notifications");
    $TN=$req->fetch(PDO::FETCH_ASSOC);
    $total_notification=$TN['total'];//total des notifications
      //% notification accepte_% notifications refuser_notification sans reponse (Expiree)
      $req=$conn->query("SELECT statut,COUNT(*) AS total FROM notifications 
                         GROUP BY statut");
      $notifications=$req->fetchALL(PDO::FETCH_ASSOC);
      foreach($notifications as $val){
         if($total_notification!=0){
          $stat_notif[$val['statut']]=($val['total']/$total_notification)*100;
         }else
           $stat_notif[$val['statut']]=0;
      }
      

   //STATISTIQUE RDV
   $stat_RDV=[];
    $req=$conn->query("SELECT COUNT(*) AS total FROM rendez_vous");
    $TRDV=$req->fetch(PDO::FETCH_ASSOC);
    $total_RDV=$TRDV['total'];//totale des RDV
      //% RDV effectues_% RDV non effectue_% RDV confirme
      $req=$conn->query("SELECT statut,COUNT(*) AS total FROM rendez_vous
                         GROUP BY statut");
      $RDV=$req->fetchAll(PDO::FETCH_ASSOC);
      foreach($RDV as $val){
         if($total_RDV!=0){
          $stat_RDV[$val['statut']]=($val['total']/$total_RDV)*100;
         }else
           $stat_RDV[$val['statut']]=0;
      }

    $req=$conn->query("SELECT COUNT(*) AS total FROM rendez_vous WHERE statut= 'effectue'");
    $RDV=$req->fetch(PDO::FETCH_ASSOC);
    $total_RDVconf=$RDV['total'];
    if($total_notification!=0)
      $taux=round(($total_RDVconf/$total_notification)*100,2);
    else
      $taux=0;
?>