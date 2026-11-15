<?php
  /*fonction retourne le nombre des alertes active non gérer*/
     function nouvelle_alerte($conn){
        $nb=$conn->query("SELECT id_alerte FROM alertes
                           WHERE statut='active' AND id_alerte NOT IN (SELECT id_alerte FROM notifications)");
        return $nb->rowCount();
     }
    /*fonction retourne le nombre de ligne d'une $table*/
    function nbr_ligne($conn,$table,$cond){
        $req=$conn->query("SELECT COUNT(*) AS total FROM $table WHERE $cond");
        $val=$req->fetch(PDO::FETCH_ASSOC);
        return $val['total'];
    }
  function getAdmin($conn, $id){
        $req = $conn->prepare("SELECT * FROM user WHERE id_user=?");
        $req->execute([$id]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }
     //table des  donneurs avec toutes leurs données
    function getDonneursComplets($conn){
     return $conn->query("SELECT u.id_user , u.nom , u.prenom , u.telephone ,
                         u.etat , d.gov , d.groupe_sanguin_rhesus , d.dernier_don ,
                         d.anomalie 
            FROM user u,donneur d
            WHERE u.type_user = 'Donneur' AND u.id_user=d.id_user");
    }

    function getCentreComplets($conn){
        return $conn->query("SELECT u.id_user,c.id_centre, u.nom,u.telephone,c.gov,c.adresse,c.horaire_open,c.horaire_close 
                            FROM user u,centres c
                            WHERE u.id_user=c.id_user
                            ");
    }
    function getstock_centre($id,$conn){
        $req=$conn->query("SELECT * FROM stocks_sanguins WHERE id_centre=$id");
        return $req->fetch(PDO::FETCH_ASSOC);
    }
    function getAlertes($conn){
         return $conn->query("SELECT * FROM alertes a,centres c,user u
                              WHERE a.id_user=u.id_user AND c.id_user=u.id_user ");
    }
    function filtrer_donneur($conn,$gouv,$gsr){
        // donneur sans anomalie ayant gsr et ville données et un compte active
        $req=$conn->prepare('SELECT u.id_user , u.nom,u.prenom,u.telephone,D.gov,D.groupe_sanguin_rhesus,D.dernier_don FROM user u, donneur D 
                             WHERE D.groupe_sanguin_rhesus=? AND D.gov=? AND D.anomalie IS NULL
                    AND D.id_user = u.id_user AND u.etat="active"');
       $req->execute(array($gsr,$gouv));
       return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    /*ajouter les notifications à la BD */
    function envoi_notification($conn,$id_alerte,$id_user){
        $conn->query("INSERT INTO notifications (id_user,id_alerte,statut) 
                     VALUES ($id_user,$id_alerte,'active')");
    }/*modifier une ou plusieur données (Admin)*/
    function modif_infoAdmin($conn,$col,$val){
    $req=$conn->prepare("UPDATE user SET $col=? WHERE id_user=?");
                $req->execute([$val,$_SESSION['id_user']]);
    }
    function ajout_admin($conn,$nom,$prenom,$tel,$psw,$code){
        $req=$conn->prepare("INSERT INTO user (nom,prenom,telephone,mot_de_passe,type_user,code_securite)
                                     VALUES (?,?,?,?,?,?)");
                $req->execute([$nom,$prenom,$tel,$psw,'Admin',$code]);
    }
    function autreAdmin_existe($conn,$val){
        $test=0;
        $req=$conn->prepare("SELECT *  FROM user WHERE type_user='Admin' AND id_user != ?");
                $req->execute([$val]);
         return $req->fetch(PDO::FETCH_ASSOC);
    }
    function reponder_question($conn,$rep,$id){
       $req=$conn->prepare('UPDATE question_reponse SET reponse=? WHERE id_QR=?');
       return $req->execute([$rep,$id]);
    }
?>