<?php
  function ajoutTableUser($conn,$nom,$prenom,$tel,$etat,$code){
        $req=$conn->prepare("INSERT INTO user (nom,prenom,telephone,type_user,etat,code_securite) VALUES (?,?,?,?,?,?)");
        $req->execute([$nom,$prenom,$tel,"Donneur",$etat,$code]);
  }function ajouter_password($conn,$psw,$id){
    $req=$conn->prepare("UPDATE user SET mot_de_passe=? WHERE id_user=?");
                $req->execute([$psw,$_SESSION['id_user']]);
  }
  function ajoutTableDonneur($conn,$id_user,$CIN,$gsr,$gouv,$poids,$date_don){
        $req=$conn->prepare("INSERT INTO donneur (id_user,CIN,groupe_sanguin_rhesus,gov,poids,dernier_don) VALUES (?,?,?,?,?,?)");
        $req->execute([$id_user,$CIN,$gsr,$gouv,$poids,$date_don]);
  }
  function recupererIDuser($conn,$cond){
    $req=$conn->prepare("SELECT id_user FROM user WHERE telephone=?");
    $req->execute([$cond]);
    return $req->fetch(PDO::FETCH_ASSOC);
  } 
  
?>