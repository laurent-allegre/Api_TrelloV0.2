<?php
    class Card {
        private string $id;
        private string $name;
        private string $descriptif;
        private string $idList;
        private string  $shortLink;
        private string $dateLastActivity;
        private ?string $commentaire;
       

        public function __construct() {
                       

        } 

         /**
         *  Les getters
         */
        public function getId() {
            return $this->id;
        }

        public function getName() {
          return $this->name;
         }

         public function getDescriptif() {
          return $this->descriptif;
         }

        public function getIdList() {
            return $this->idList;
        }

        public function getShortLink() {
          return $this->shortLink;
        }

        public function getDateLastActivity() {
        return $this->dateLastActivity;
        }

        public function getCommentaire() {
        return $this->commentaire;
        }

       public function getDatas() {
        return [
        'id' -> $this->id,
        'name' -> $this->name,
        'descriptif' -> $this->descriptif,
        'idList' -> $this->idList,
        'shortLink' -> $this->shortLink,
        'dateLastActivity' -> $this->dateLastActivity
        ];
      }

        

      
        /**
         *  Les setters
         */
        public function setId($id) {
            $this->id = $id;
        }

        public function setName($name) {
          $this->name = $name;
        }

        public function setDescriptif($descriptif) {
          $this->descriptif = $descriptif;
        } 

        public function setIdList($idlist) {
        $this->idlist = $idlist;
        }

        public function setShortLink($shortLink) {
        $this->shortLink = $shortLink;
        }

        public function setLastDateActivity($dateLastActivity) {
        $this->dateLastActivity = $dateLastActivity;
        }


        public function setDatas(array $datas) {
          $this->id = $datas["id"];
          $this->name = $datas["name"];
          $this->descriptif = $datas["descriptif"];
          $this->idList = $datas["idList"];
          $this->shortLink = $datas["shortLink"];
          $this->dateLastActivity = $datas["dateLastActivity"];
        }

       

        public function existInDb() {
          $sql = "SELECT * FROM cards WHERE id =:id;";

          try {
            $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
            $query = $db->prepare($sql);
            $query->bindParam("id", $this->id, PDO::PARAM_STR);
           

            $query->execute();
            $result= $query->fetchAll();
            if(count($result) > 0){
              return true;

            } else {
              return false;
            }


          } catch (Exception $e) {
          echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
          return false;
        }
        }

         /**
          *  Les méthodes d'accès à la base
          */
              
          public function save() {
              
              if(!$this->existInDb()){

                 $sql = "INSERT INTO cards (id, name, descriptif, idList, shortLink, dateLastActivity) VALUES (:id, :name, :descriptif,  :idList, :shortLink, :dateLastActivity);";

                try {
                  $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
                  $query = $db->prepare($sql);
                  $query->bindParam("id", $this->id, PDO::PARAM_STR);
                  $query->bindParam("name", $this->name, PDO::PARAM_STR);
                  $query->bindParam("descriptif", $this->descriptif, PDO::PARAM_STR);
                  $query->bindParam("idList", $this->idList, PDO::PARAM_STR);
                  $query->bindParam("shortLink", $this->shortLink, PDO::PARAM_STR);
                  $query->bindParam("dateLastActivity", $this->dateLastActivity, PDO::PARAM_STR);
                  
                  $query->execute();
                  
                } catch (Exception $e) {
                echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
              }

              } else {
                  $sql = "UPDATE cards SET  name = :name, descriptif =:descriptif,  idList = :idList, shortLink= :shortLink, dateLastActivity = :dateLastActivity WHERE id=:id  ;";

                    try {
                      $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
                      $query = $db->prepare($sql);
                      $query->bindParam("id", $this->id, PDO::PARAM_STR);
                      $query->bindParam("name", $this->name, PDO::PARAM_STR);
                      $query->bindParam("descriptif", $this->descriptif, PDO::PARAM_STR);
                      $query->bindParam("idList", $this->idList, PDO::PARAM_STR);
                      $query->bindParam("shortLink", $this->shortLink, PDO::PARAM_STR);
                      $query->bindParam("dateLastActivity",$this-> dateLastActivity, PDO::PARAM_STR);

                      if ( $query->execute()) {
                        return true;
                      } else {
                        return false;
                      }
                     
                    } catch (Exception $e) {
                      echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
                      return false;
                    }     
              }
              
             
          }
         

          public function deleteInDb(string $id) {
            require_once "db.class.php";
              
            $sql = "DELETE cars WHERE id = :id;";

            try {
              $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
              $query = $db->repare($sql);
              $query->bindParam("id", $id, PDO::PARAM_STR);
                            
              if ( $query->execute()) {
                return true;
              } else {
                return false;
              }
             
            } catch (Exception $e) {
              echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
              return false;
            }     
          }

          public static function getById(string $id) {
            $sql = "SELECT * from cards WHERE id = :id LIMIT 1;";
            try {
              $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
              $query = $db->prepare($sql);
              $query->bindParam("id", $this->id, PDO::PARAM_STR);
         
              $query->execute();
              $cards = $query->fetchAll();

              if (!empty($cards)) {
                  return $cards[0];
              } else {
                  return array();
              }
            } catch (Exception $e) {
              echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
              return array();
            }
          }

          public static function getAll() {
            $sql = "SELECT * from cards ;";
            try {
              $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
              $query = $db->prepare($sql);
              $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,'Card');
            

              $query->execute();
              $cards = $query->fetchAll();
           
              if (!empty($cards)) {
                  return $cards;
              } else {
                  return array();
              }
            } catch (Exception $e) {
              echo "<h3>Une erreur SQL s'est produite</h3>" . $e->getMessage();
              return array();
            }
          }

     
    }