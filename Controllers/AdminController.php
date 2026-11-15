<?php
   session_start();
   require "../Models/AdminModel.php";
   /*inclut de fichier contenant des fonctions définies*/
    require "../Models/fonctions.php";
    $conn=connexion();
    modif_statut($conn);//mettre à jour le statut des alertes expirées et notifications liée
   if(!isset($_SESSION['id_user'])){
    header("Location:../Views/connexion.php");
    exit;
   }
    //verifier l'existance de nouvelles alertes ou notification
    $notif_alertes = nouvelle_alerte($conn);
    $notif_questions = nbr_ligne($conn,"question_reponse","reponse IS NULL");
    // données nécessaire pour la view
    $admin =getAdmin($conn, $_SESSION['id_user']);//$admin :table associatif contenant les données de l'admin 
    $Donneurs = getDonneursComplets($conn);//retourne un PDO
    $Centres=getCentreComplets($conn);//PDO
    $Alertes=getAlertes($conn);//PDO
    $QRS=recupere_table($conn,"question_reponse","1");
    $res=recupere_table($conn,"donneur","id_user=".$_SESSION['id_user']);
    $res->execute([]);
    $donneur=$res->fetch(PDO::FETCH_ASSOC);
    
    //recuperer les statistiques
    require "../Models/statistique.php";
    //si l 'un des etat du compte n'existe pas dans la table
    if(!isset($stat_donneur['active']))
        $stat_donneur['active']=0;
    if(!isset($stat_donneur['desactive']))
        $stat_donneur['desactive']=0;
    if(!isset($stat_donneur['inactive']))
        $stat_donneur['inactive']=0;
    $dataDonneur = array( array("label"=>"Actifs", "y"=>$stat_donneur['active']),
	                                    array("label"=>"Désactifs", "y"=>$stat_donneur['desactive']),
	                                    array("label"=>"Inactifs", "y"=>$stat_donneur['inactive']));
    // si un ou plusieur  groupe ne correspond à aucune alerte 
    if(!isset($stat_alerte['A+']))
        $stat_alerte['A+']=0;
    if(!isset($stat_alerte['A-']))
        $stat_alerte['A-']=0;
    if(!isset($stat_alerte['B+']))
        $stat_alerte['B+']=0;
    if(!isset($stat_alerte['B-']))
        $stat_alerte['B-']=0;
    if(!isset($stat_alerte['O+']))
        $stat_alerte['O+']=0;
    if(!isset($stat_alerte['O-']))
        $stat_alerte['O-']=0;
    if(!isset($stat_alerte['AB+']))
        $stat_alerte['AB+']=0;
    if(!isset($stat_alerte['AB-']))
        $stat_alerte['AB-']=0;
    $dataAlerte= array(array("y" => $stat_alerte['A+'], "label" => "A+" ),
	                                    array("y" => $stat_alerte['A-'], "label"=>"A-" ),
	                                    array("y" => $stat_alerte['B+'], "label"=>"B+"),
                                        array("y" => $stat_alerte['B-'], "label"=>"B-"),
                                        array("y" => $stat_alerte['O+'], "label"=>"O+"),
                                        array("y" => $stat_alerte['O-'], "label"=>"O-"),
                                        array("y" => $stat_alerte['AB+'], "label"=>"AB+"),
                                        array("y" => $stat_alerte['AB-'], "label"=>"AB-"));
    // si l un des statut du RDV n existe pas dans la table
    if(!isset($stat_RDV['confirmé']))
        $stat_RDV['confirmé']=0;
    if(!isset($stat_RDV['effectué']))
        $stat_RDV['effectué']=0;
    if(!isset($stat_RDV['non effectué']))
        $stat_RDV['non effectué']=0;
    $dataRDV= array(array("y" => $stat_RDV['confirmé'], "label" => "confirmé" ),
	                                    array("y" => $stat_RDV['effectue'], "label"=>"effectué" ),
	                                    array("y" => $stat_RDV['non effectue'], "label"=>"non effectué"));
    // si l un des statut de la notifications n existe pas dans la table
    if(!isset($stat_notif['accepté']))
        $stat_notif['accepté']=0;
    if(!isset($stat_notif['refusé']))
        $stat_notif['refusé']=0;
    if(!isset($stat_notif['Expiree']))
        $stat_notif['Expiree']=0;
    $dataNotifications = array(array("label"=>"Autres","y"=>100-($stat_notif['accepté']+$stat_notif['refusé']+$stat_notif['Expiree'])),
	                                   array("label"=>"Acceptée","y"=>$stat_notif['accepté']),
                                       array("label"=>"Refusée","y"=>$stat_notif['refusé']),
                                       array("label"=>"Expirée","y"=>$stat_notif['Expiree'])
                                );
    //suppression de l'alertes de la table alertes avec ces notifications
   if(isset($_POST['delete_A'])){
        $cond="id_alerte=".$_POST['id_alerte'];
        delete_Data($conn,"alertes",$cond);
        header('Location:../Views/admin.php');
        exit;
   }//supprimer un donneur
   if(isset($_POST['delete_D'])){
        $cond="id_user=".$_POST['id_user'];
        delete_Data($conn,"user",$cond);
        delete_Data($conn,"donneur",$cond);
        header('Location:../Views/admin.php');
        exit;
   }//desactiver un donneur
   if(isset($_POST['inactive_D'])){
       $cond="id_user=".$_POST['id_user'];
       inactivate_Data($conn,"user",$cond);
        header('Location:../Views/admin.php');
        exit;
   }//reactiver un donneur
   if(isset($_POST['active_D'])){
       $cond="id_user=".$_POST['id_user'];
        activate_Data($conn,"user",$cond);
        header('Location:../Views/admin.php');
        exit;
   }//supprimer un centre
   if(isset($_POST['delete_c'])){
       $cond="id_user=".$_POST['id_user'];
       delete_Data($conn,"user",$cond);
       header('Location:../Views/admin.php');
       exit;
   }//supprimer une question 
   if(isset($_POST['delete_Q'])){
       $cond="id_QR=".$_POST['QR'];
       delete_Data($conn,"question_reponse",$cond);
       header('Location:../Views/admin.php');
       exit;
   }
?>