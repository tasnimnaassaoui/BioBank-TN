<?php
    /*fonction retourne un PDO connecté à la BD*/ 
    function connexion(){
        try{
           return new PDO('mysql:host=localhost;dbname=biobank_tn','root','');
        }catch(Exception $e){
            die ("erreur de connexion à la base !!");
        }
    }function verif_code_securite($conn,$code){
        $test=0;
        $req=$conn->query("SELECT * FROM user WHERE code_securite=$code");
        if ($req->rowCount()>0)
           $test=1;
        return $test;
    }
    /*fonction retourne la durée de désactivation d'un compte*/
    function calcul_durée($conn,$id){
        $req=$conn->query("SELECT TIMESTAMPDIFF(DAY,date_desactivation,NOW()) AS duree FROM user WHERE id_user=$id ");
        $duree=$req->fetch(PDO::FETCH_ASSOC);
        return $duree['duree'];
    }
    /*fonction permet de modifier un mot de passe */
    function modifier_psw($conn,$table,$cond,$_nvpsw){
        $req=$conn->prepare("UPDATE user SET mot_de_passe=? WHERE id_user=?");
        $req->execute([$_nvpsw,$cond]);
    }

    /*fonction retourne les lignes d une table selon une condition  */
    function recupere_table($conn,$table,$cond){
        $req=$conn->prepare("SELECT * FROM $table WHERE $cond");
        $req->execute([]);
        return $req;
    }
    

    /* fonction permet de verifier la date limite de l'alerte si atteinte et modifier le statut en expirée
    ainsi que verifier la durée entre la date dernier don et la date actuelle si elle est >=56j alors le compte devient active*/
    function modif_statut($conn){
        //verifictaion alertes
    $conn->query("UPDATE alertes SET statut='Expire' WHERE date_limite<NOW() AND statut='active'");//empecher le sys à modifier l'alerte résolue
    $conn->query("UPDATE notifications SET statut='Expiree' 
                 WHERE id_alerte IN (SELECT id_alerte FROM alertes WHERE statut='Expire') AND statut='active'");
    
    //verification du compte donneur si la periode >=56j ou <56
    $req=$conn->query("SELECT dernier_don,id_user FROM donneur");
    while($donneur=$req->fetch(PDO::FETCH_ASSOC)){
        if($donneur['dernier_don']!=NULL){
           $dateDernierDon = new DateTime($donneur['dernier_don']);
           $dateActuelle = new DateTime();
           $diff = $dateDernierDon->diff($dateActuelle)->days;//difference en jour
           if($diff>=56)
               $conn->query("UPDATE user SET etat='active' WHERE id_user=".$donneur['id_user']);
           else
               $conn->query("UPDATE user SET etat='inactive' WHERE id_user=".$donneur['id_user']);
        }
    }
    }
     /*fonction permet de supprimer une ligne d'une tzable selon condition donnée en paramètre*/
     function delete_Data($conn,$table,$cond){
          $conn->query("DELETE FROM $table WHERE $cond");
    }
    function ajout_question($conn,$Q){
        $req=$conn->prepare('INSERT INTO question_reponse (question) VALUES (?)');
        return $req->execute([$Q]);
        
    }
?>