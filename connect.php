<?php
    require "include.all.php";
    echo "<pre>";

    
    $api = new Apitrello();

   /**
    * on recupere la liste des tableaux et on selectionne le tableau voulu 
    */
   $results = $api->getBoards();
        
    foreach($results as $board){
        if ($board["name"] == 'Stage Laurent') {
            $monTableauId = $board['id'];
        }else {
            echo "pas trouvé";
            die();
        }
    }
    
   /**
    * on recupere l'ensemble des listes du dit tableau
    */          
    $lists = $api->getLists($monTableauId);
        foreach($lists['lists'] as $list) {
          
          if ($list["name"] == 'INTERVENTIONS CLOTUREES') {
            $maListeId = $list["id"];
            $malist= $list["name"];
            $newList = new Liste();
            $newList->setDatas([
            'id'=> $list['id'],
            'name' => $list['name'],
            'idBoard'=> $list['idBoard'],
            'closed' => $list['closed']
            
         ]) ;
        $newList->save(); 
          }
        }
        
    /**
    * on recupere toutes les cartes de cette liste 
    */

    $cards = $api->getCards($monTableauId, $maListeId); 
    
    foreach($cards as $card){
        $maCarteId = $card['id'];
      
        $newCard = new Card();
        $newCard->setDatas([
            'id'=> $card['id'],
            'name' => $card['name'],
            'descriptif' => $card['desc'],
            'idList'=> $card['idList'],
            'shortLink' => $card['shortLink'],
            'dateLastActivity' => $card['dateLastActivity'],
         ]) ;
        $newCard->save(); 
       
    }
     /**
    * on recupere les checklists 
    */


    $checkLists = $api->getCheckList($monTableauId, $maListeId); 

    foreach($checkLists as $itemChecklist) {
         $checks = $itemChecklist['checkItems'];
        foreach($cards as $card){
            $maCarteId = $card['id'];
            
            if($maCarteId == $itemChecklist['idCard'] ) {
           
               $newcheckLists = new Checklist();
                $newcheckLists->setDatas([
                    'id'=> $itemChecklist['id'],
                    'name' => $itemChecklist['name'],
                    'idCard'=> $itemChecklist['idCard'],
                    'pos' => $itemChecklist['pos'],
                    'idBoard' => $itemChecklist['idBoard']  
                ]); 
                $newcheckLists->save();

                foreach($checks as $check) {
                        $newCheckBox = new Checkbox();
                        $newCheckBox->setDatas([
                            'id'=> $check['id'],
                            'name' => $check['name'],
                            'pos' => $check['pos'],
                            'idChecklist' => $check['idChecklist'], 
                            'state' => $check['state'] 
                        ]);
                        $newCheckBox->save(); 
                       // var_dump($check['name']);
                        
                }    
                
               
            }
           
        }        

        

    }
  
 
    
echo"</pre>";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no"> 
<meta http-equiv="X-UA-Compatible" content="ie=edge"> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
<link rel="stylesheet" href="css/style.css">
<title>Title</title>
</head>
<body>

<section class=" container-fluid ">        
        <h1 class="text-center" >Historique Trello</h1>
        <div class="row mt-4">
        <?php
            $cards = Card::getAll();
         
            foreach ($cards as $card) {
                $liste = new Liste();
                $liste->findById($card->getIdList());
                $checklist = Checklist::getByCard($card->getId());
                $checkboxes = Checkbox::getByCheckList($checklist->getId());
                $lastActivity = $card->getDateLastActivity() ;

            ?>
                <div class="">
                 <table>
                    <tr>
                        <td class="border border-secondary"><?= $liste->getName(); ?></td>
                        <td class="border border-secondary"><?= $card->getName() ;?> </td>

                        

                <?php   foreach ($checkboxes as $checkbox) { ?>
                                <td class="border border-secondary"><?php
                                $etat = " <span class='text-success'>oui</span> ";
                            if ($checkbox->getState() == 'incomplete') {
                                    $etat = " <span class='text-danger'>non</span> ";
                            }
                                echo  $checkbox->getName() . '<br>' . $etat ;
                                $dateCrea = $checkbox->getDateCreation();
                             
                      
                            ?> 
                <?php   } ?>
                            </td>
                    <td class="border border-secondary">Date de création : <?=strftime('%d-%m-%Y',strtotime($dateCrea)); ?></td>         
                    <td class="border border-secondary">Date de dernière modif : <?=strftime('%d-%m-%Y',strtotime($lastActivity)); ?> </td>
                    <td></td>
                    </tr>
                </table>
               </div>
     <?php  } ?>
           
          
      
        </div>
    </section>  

      
        <h1 class="text-center" >Historique Trello</h1>
    <div class="scrol row ml-1 ">   
       
        <?php
            $cards = Card::getAll();
             
            foreach ($cards as $card) {
                $liste = new Liste();
                $liste->findById($card->getIdList());
                $checklist = Checklist::getByCard($card->getId());
                $checkboxes = Checkbox::getByCheckList($checklist->getId());
                $lastActivity = $card->getDateLastActivity() ;

            ?>
         
            <span class="border border-secondary "><?= $liste->getName() . " : " . $card->getName() . " : " . strftime('%d-%m-%Y',strtotime($dateCrea)) . " : " .strftime('%d-%m-%Y',strtotime($lastActivity)) ; ?></span>
                <?php   foreach ($checkboxes as $checkbox) { ?>
                            <?php
                                $etat = " <span class='text-success tex'>oui</span> ";
                            if ($checkbox->getState() == 'incomplete') {
                                    $etat = " <span class='text-danger tex'>non</span> ";
                            } ?>
                          <span class="border border-secondary aLaLigne"><?= $checkbox->getName() . '<br>' . $etat ;?></span>    
                            <?php   $dateCrea = $checkbox->getDateCreation(); ?>
   
                  <?php } ?>
                  <span class="border border-secondary aLaLigne ">Commentaires :<?= $card->getCommentaire()  ;?></span>     
     <?php  } ?>
               
     </div>   
      
        
   

    
   

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>

