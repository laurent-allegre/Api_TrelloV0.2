<?php
    class Liste {
        private  $id;
        private string $name;
        private string $idBoard;
        private string $closed;
       

        public function __construct($id="", $name="", $idBoard="", $closed="") {
            $this->id = $id;
            $this->name = $name;
            $this->idBoard = $idBoard;
            $this->closed = $closed;
         
            

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

              public function getIdBoard() {
                return $this->idboard;
            }
            public function getClosed() {
              return $this->closed;
            }

           
           public function getDatas() {
            return [
            'id' -> $this->id,
            'name' -> $this->name,
            'idBoard' -> $this->idBoard,
            'closed' -> $this->closed,
            ];
          }
        

        /**
         *  Les setters
         */
          public function __set($name, $value){
            $this->$name = $value;
          }

        public function setId($id) {
            $this->id = $id;
        }

        public function setName($name) {
          $this->name = $name;
      }
        public function setIdBoard($idBoard) {
        $this->idBoard = $idBoard;
      }
       public function setClosed($closed) {
       $this->closed = $closed;
      }
       

      public function setDatas(array $datas) {
          $this->id = $datas["id"];
          $this->name = $datas["name"];
          $this->idBoard = $datas["idBoard"];
          $this->closed = $datas["closed"];
          
      }

      public function findById($id) {
          $sql = "SELECT * FROM list WHERE id =:id limit 1;";
          
          try {
            $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
            $query = $db->prepare($sql);
            $query->bindParam("id", $id, PDO::PARAM_STR);
            $query->setFetchMode(PDO::FETCH_INTO, $this);
           

            $query->execute();
            $result= $query->fetch();
           

            } catch (Exception $e) {
            echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
              }
      }


        public function existInDb() {
          $sql = "SELECT * FROM list WHERE id =:id;";

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
            require_once "db.class.php";
            if(!$this->existInDb()){

              $sql = "INSERT INTO list (id, name, idBoard, closed) VALUES (:id, :name, :idBoard, :closed);";

              try {
                $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
                $query = $db->prepare($sql);
                $query->bindParam("id", $this->id, PDO::PARAM_STR);
                $query->bindParam("name", $this->name, PDO::PARAM_STR);
                $query->bindParam("idBoard", $this->idBoard, PDO::PARAM_STR);
                $query->bindParam("closed", $this->closed, PDO::PARAM_BOOL);
  
                $query->execute();
              } catch (Exception $e) {
                echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
                }

            } else {
                   $sql = "UPDATE list SET  name, idBoard, closed WHERE id=:id values( :name, :idBoard, :closed ) ;";

                try {
                  $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
                  $query = $db->prepare($sql);
                  $query->bindParam("id", $this-> id, PDO::PARAM_STR);
                  $query->bindParam("name", $this-> name, PDO::PARAM_STR);
                  $query->bindParam("idBoard", $this-> idBoard, PDO::PARAM_STR);
                  $query->bindParam("closed", $this-> closed, PDO::PARAM_BOOL);

                  $query->execute();
                  } catch (Exception $e) {
                    echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
                    } 
            }
          }
       

          public function deleteInDb() {
            require_once "db.class.php";
              
             //    $sql = "DELETE list WHERE id = ($id["id"]);";

            try {
              $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
              $query = $db->prepare($sql);
              $query->bindParam("id", $this->id, PDO::PARAM_STR);
              $query->bindParam("name", $this->name, PDO::PARAM_STR);
              $query->bindParam("idBoard", $this->idBoard, PDO::PARAM_STR);
              $query->bindParam("closed", $this->closed, PDO::PARAM_BOOL);

              $query->execute();
            } catch (Exception $e) {
                echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
              }     
          }

        
        
    }