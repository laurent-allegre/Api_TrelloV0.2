<?php
    class Checkbox {
        private string $id;
        private string $name;
        private float  $pos;
        private string $idChecklist;
        private string $state;
        private string $dateCreation;

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
    
        public function getPos() {
          return $this->pos;
        }
    
        public function getIdChecklist() {
          return $this->idChecklist;
        }
        public function getState() {
          return $this->state;
        }

        public function getDateCreation() {
          return $this->dateCreation;
        }

        public function getDatas() {
          return [
          'id' -> $this->id,
          
          'nameData' -> $this->nameData,
          'pos' -> $this->pos,
          
          'idChecklist' -> $this->idChecklist,
          'state' -> $this->state,
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
        
        public function setPos($pos) {
          $this->pos = $pos;
        }
        
        public function setIdChecklist($idChecklist) {
          $this->idChecklist = $idChecklistd;
        }

        public function setState($state) {
          $this->state = $state;
        }

        public function setDateCreation($dateCreation) {
          $this->dateCreation = $dateCreation;
        }

        public function setDatas(array $datas) {
          $this->id = $datas["id"];
          $this->name = $datas["name"];
          $this->pos = $datas["pos"];
          $this->idChecklist = $datas["idChecklist"];
          $this->state = $datas["state"];
         
        }
        
        public static function getById($id) {
          $sql = "SELECT * FROM checkbox WHERE id =:id LIMIT 1; ";

            try {
              $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
              $query = $db->prepare($sql);
              $query->bindParam("id", $id, PDO::PARAM_STR);
              $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Checkbox");
             
               
              $query->execute();
              $result= $query->fetch();

              return $result;


            } catch (Exception $e) {
            echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
            }
        }

        public function existInDb() {
         
            $sql = "SELECT * FROM checkbox WHERE id =:id ";

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
            }
        }

        public function isDifferent() {
         
          $sql = "SELECT * FROM checkbox WHERE id =:id AND state<>:state";

          try {
            $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
            $query = $db->prepare($sql);
            $query->bindParam("id", $this->id, PDO::PARAM_STR);
            $query->bindParam("state", $this->state, PDO::PARAM_STR);
             
            $query->execute();
            $result= $query->fetchAll();

            if(count($result) > 0){
            
           
              return true;
              
            } else {
              return false;
              
            }


          } catch (Exception $e) {
          echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
          }
      }

        

         /**
          *  Les méthodes d'accès à la base
          */
          public function save() {

            if(!$this->existInDb()) {
              
              $sql = "INSERT IGNORE INTO  checkbox (id, name, pos, idChecklist, state) VALUES (:id, :name, :pos, :idChecklist, :state);";

              try {
               
                $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
                $query = $db->prepare($sql);
                $query->bindParam("id", $this->id, PDO::PARAM_STR);
                $query->bindParam("name", $this->name, PDO::PARAM_STR);
                $query->bindParam("pos", $this->pos, PDO::PARAM_STR);
                $query->bindParam("idChecklist", $this->idChecklist, PDO::PARAM_STR);
                $query->bindParam("state", $this->state, PDO::PARAM_STR);
                
                $query->execute();
                
              } catch (Exception $e) {
              echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
                }

                $historique = new Historique();
                $historique->setDatas(array(
                  'idCheckBox' => $this->id,
                   'descriptif' => "Création d'une nouvelle checkbox : " . $this->state
                ));

                $historique->saveInDb();

            } else {
              if($this->isDifferent()) {
                
                $sql = "UPDATE checkbox SET name = :name, pos = :pos, idChecklist = :idChecklist, state = :state WHERE id = :id  ;";

                  try {
                    $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
                    
                    $query = $db->prepare($sql);
                    $query->bindParam("id", $this->id, PDO::PARAM_STR);
                      $query->bindParam("name", $this->name, PDO::PARAM_STR);
                      $query->bindParam("pos", $this->pos, PDO::PARAM_STR);
                      $query->bindParam("idChecklist", $this->idChecklist, PDO::PARAM_STR);
                      $query->bindParam("state", $this->state, PDO::PARAM_STR);

                    $query->execute();
                  } catch (Exception $e) {
                      echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
                    } 

                    $historique = new Historique();
                    $historique->setDatas(array(
                      'idCheckBox' => $this->id,
                      'descriptif' => "Modification d'une checkbox : " . $this->state,
                      'name' => $this->name
                    ));

                $historique->saveInDb();
              }
            }
              
           
        }

          public function deleteInDb() {
            require_once "db.class.php";
              
          //  $sql = "DELETE checkboxes WHERE id = ($id["id"]);";

            try {
              $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
              $query = $db->prepare($sql);
              $query->bindParam("id", $this->id, PDO::PARAM_STR);
              $query->bindParam("name", $this->name, PDO::PARAM_STR);
              $query->bindParam("pos", $this->pos, PDO::PARAM_INT);
              $query->bindParam("idChecklist", $this->idChecklist, PDO::PARAM_STR);
              $query->bindParam("state", $this->state, PDO::PARAM_STR);

              $query-> execute();
            } catch (Exception $e) {
              echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
            }     
          }



          public static function getByCheckList(string $id) {
            $sql = "SELECT * from checkbox WHERE idCheckList= :idCheckList";
            try {
              $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
              $query = $db->prepare($sql);
              $query->bindParam("idCheckList", $id, PDO::PARAM_STR);
              $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Checkbox");
              
              $query->execute();
              $checkbox = $query->fetchAll();
              
              if (!empty($checkbox)) {
                  return $checkbox;
              } else {
                  return array();
              }
            } catch (Exception $e) {
              echo "<h3>Une erreur SQL s'est produite</h3>" . $e->getMessage();
              return array ();
            }
          }
//================================================================================
          


  }// fin Class Checkbox