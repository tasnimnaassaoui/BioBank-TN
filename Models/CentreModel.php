<?php
  function ajout_centreUser($conn,$nom,$tel,$psw,$code){
  //insertion du centre dans la base user comme nouveau utilistaeur
      $req=$conn->prepare('INSERT INTO user (nom,telephone,mot_de_passe,type_user,code_securite) VALUES (?,?,?,?,?)');
      $req->execute([$nom,$tel,$psw,"Centre",$code]);
  }
  //fonction retourne id_user du centre
  function id_userCentre($conn,$tel){
     $req = $conn->prepare("SELECT id_user FROM user WHERE telephone = ?");
      $req->execute([$tel]);
      $nv_centre=$req->fetch(PDO::FETCH_ASSOC);
      return $nv_centre['id_user'];
  }//insertion du centre dans la table centres
  function ajouter_centre($conn,$id,$add,$tel,$gouv,$ho,$hc,$j){
  $req=$conn->prepare('INSERT INTO centres (id_user,adresse,telephone,gov,horaire_open,horaire_close,jours_ouverture) VALUES (?,?,?,?,?,?,?)');
    $req->execute([$id,$add,$tel,$gouv,$ho,$hc,$j]);
  }
  //recuperer id_centre du centre apres insertion dans centres
  function recupere_idCentre($conn,$id){
  $req = $conn->prepare("SELECT id_centre FROM centres WHERE id_user = ?");
  $req->execute([$id]);
  $centre=$req->fetch(PDO::FETCH_ASSOC);
  return $centre['id_centre'];
  }
  //insertion des stocks dans la table stock_sanguine
  function remplir_stock_centre($conn,$id,$A,$a,$B,$b,$O,$o,$AB,$ab){
  $req=$conn->prepare('INSERT INTO stocks_sanguins (id_centre,A_plus,A_moins,B_plus,B_moins,O_plus,O_moins,AB_plus,AB_moins) 
                       VALUES (?,?,?,?,?,?,?,?,?)');
    $req->execute([$id,$A,$a,$B,$b,$O,$o,$AB,$ab]);
  }
  function recupere_stock($conn,$id){
    $req=$conn->prepare("SELECT * FROM stocks_sanguins WHERE id_centre=".$id);
                    $req->execute([]);
                    $stock=$req->fetch(PDO::FETCH_ASSOC);
                    return $stock;
  }
  //retourne l'ensemble des historiques du centre
  function historique($conn, $id){

    $req = $conn->query("SELECT h.id_hist, u.nom ,u.prenom,d.groupe_sanguin_rhesus, h.date_don FROM historiques h ,user u ,donneur d
                                                                                      WHERE h.id_donneur=d.id_donneur
                                                                                            AND u.id_user=d.id_user
                                                                                            AND h.id_centre=".$id);
    return $req->fetchAll(PDO::FETCH_ASSOC);
}
  function info_donneur($conn,$idDonneur){
    //lire id_user du donneur
    $req=$conn->query("SELECT id_user FROM donneur WHERE id_donneur=".$idDonneur);
    $user=$req->fetch(PDO::FETCH_ASSOC);
    //recupere du table user et donneur ds infos 
    $req=$conn->query("SELECT nom,prenom,telephone FROM user WHERE id_user=".$user['id_user']);
    return $req->fetch(PDO::FETCH_ASSOC);
  }
?> 