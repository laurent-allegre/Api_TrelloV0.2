<?php
    class Checklist {
        private string $id;
        private string $name;
        private string $idCard;
        private float  $pos;
        private string $idBoard;
       

        public function __construct() {
           
         
            

        } 

         /**
         *  Les getters
         */
        public function getId() {
            return $this-> id;
        }
        public function getName() {
          return $this->name;
         }
        public function getIdCard() {
            return $this->idCard;
        }
        public function getPos() {
          return $this->pos;
        }
        public function getIdBoard() {
        return $this->idBoard;
       }
       public function getDatas() {
        return [
        'id' -> $this->id,
        'name' -> $this->name,
        'idCard' -> $this->idCard,
        'pos' -> $this->pos,
        'idBoard' -> $this->idBoard
        ];
      }

        /**
         *  Les setters
         */
        public function setId($id) {
            $this-> id = $id;
        }
        public function setName($name) {
          $this->name = $name;
        } 
        public function setIdCard($idCard) {
        $this->idCard = $idCard;
        }
        public function setPos($pos) {
        $this->pos = $pos;
        }
        public function setIdBoard($idBoard) {
        $this->idBoard = $idBoard;
        }

        public function setDatas(array $datas) {
          $this->id = $datas["id"];
          $this->name = $datas["name"];
          $this->idCard = $datas["idCard"];
          $this->pos = $datas["pos"];
          $this->idBoard = $datas["idBoard"];
        }



        public function existInDb() {
          $sql = "SELECT * FROM Checklist WHERE id =:id;";

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
         /**
          *  Les méthodes d'accès à la base
          */
          public function save() {
              
            if(!$this->existInDb()){

               $sql = "INSERT INTO Checklist (id, name, idCard, pos, idBoard) VALUES (:id, :name,  :idCard, :pos, :idBoard);";

              try {
                $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
                $query = $db->prepare($sql);
                $query->bindParam("id", $this->id, PDO::PARAM_STR);
                $query->bindParam("name", $this->name, PDO::PARAM_STR);
                $query->bindParam("idCard", $this->idCard, PDO::PARAM_STR);
                $query->bindParam("pos", $this->pos, PDO::PARAM_STR);
                $query->bindParam("idBoard", $this->idBoard, PDO::PARAM_STR);
                
                $query->execute();
              } catch (Exception $e) {
              echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
            }

            } else {
                $sql = "UPDATE Checklist SET  name,  idCard, pos, idBoard WHERE id=:id values( :name,  :idCard, :pos, :idBoard ) ;";

                  try {
                    $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
                    $query = $db->prepare($sql);
                    $query->bindParam("id", $this->id, PDO::PARAM_STR);
                      $query->bindParam("name", $this->name, PDO::PARAM_STR);
                      $query->bindParam("idCard", $this->idCard, PDO::PARAM_STR);
                      $query->bindParam("pos", $this->pos, PDO::PARAM_STR);
                      $query->bindParam("idBoard",$this-> idBoard, PDO::PARAM_STR);

                    $query->execute();
                  } catch (Exception $e) {
                      echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
                    } 
            }
            
           
        }

          public function deleteInDb() {
            require_once "db.class.php";
              
          //  $sql = "DELETE Checklist WHERE id = ($id["id"]);";

            try {
              $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
              $query = $db->prepare($sql);
              $query->bindParam("id", $this->id, PDO::PARAM_STR);
              $query->bindParam("name", $this->name, PDO::PARAM_STR);
              $query->bindParam("idCard", $this->idCard, PDO::PARAM_STR);
              $query->bindParam("pos", $this->pos, PDO::PARAM_INT);
              $query->bindParam("idBoard", $this->idBoard, PDO::PARAM_STR);
              

              $query-> execute();
            } catch (Exception $e) {
              echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
            }     
          }

          public static function getById(string $id) {
            $sql = "SELECT * from Checklist WHERE id = :id LIMIT 1;";
            try {
              $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::HOST . "; dbname=" . DB::HOST . "; charset=utf8", "root", "");
              $query = $db->prepare($sql);
              $query->bindParam("id", $this->id, PDO::PARAM_STR);
              $query->bindParam("name", $this->name, PDO::PARAM_STR);
              $query->bindParam("idCard", $this->idCard, PDO::PARAM_STR);
              $query->bindParam("pos", $this->pos, PDO::PARAM_INT);
              $query->bindParam("idBoard", $this->idBoard, PDO::PARAM_STR);

              $Checklist = $query-> execute();

              if (!empty($Checklist)) {
                  return $Checklist[0];
              } else {
                  return new Checklist();
              }
            } catch (Exception $e) {
              echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
            }
          }


          public static function getByCard(string $id) {
            $sql = "SELECT * from checklist WHERE idCard = :idCard LIMIT 1 ;";
            try {
              $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
              $query = $db->prepare($sql);
              $query->bindParam("idCard", $id, PDO::PARAM_STR);
              $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Checklist");

              $query->execute();
              $Checklist = $query->fetchAll();

              if (!empty($Checklist)) {
                  return $Checklist[0];
              } else {
                 // return array();
                  return new Checklist();
              }
            } catch (Exception $e) {
              
              echo "<h3>Une erreur SQL s'est produite</h3>" . $e->getMessage();
             // return array ();
             return new Checklist();
            }
          }


         
    }