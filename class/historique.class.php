<?php

class Historique {
    private int $id;
    private string $idCheckBox;
    private string $descriptif;
    private ?string  $state;
    private string $dateModifs;
    private string $name;
    
    public function __construct() {
        
    }

    /**
     *  Les getters
     */
    public function getIdCheckBox() {
        return $this->idCheckBox;
    }
    public function getDescriptif() {
      return $this->descriptif;
    }

    public function getState() {
      return $this->state;
    }

    public function getDateModifs() {
      return $this->dateModifs;
    }

    public function getName() {
      return $this->name;
    }
   
    public function getDatas() {
      return [
      'idCheckBox' -> $this->idCheckBox,
      'descriptif' -> $this->descriptif,
      'name' -> $this->name,
       
     ];
    }

     /**
         *  Les setters
         */
        public function setIdCheckBox($idCheckBox) {
            $this->idCheckBox = $idCheckBox;
        }

        public function setDescriptif($descriptif) {
          $this->descriptif = $descriptif;
        }
        
        public function setState($state) {
            $this->state = $state;
        }
        
        public function setDateModifs($dateModifs) {
          $this->dateModifs = $dateModifs;
        }

        public function setName($name) {
          $this->name = $name;
        }
        

        public function setDatas(array $datas) {
          $this->idCheckBox = $datas["idCheckBox"];
          $this->descriptif = $datas["descriptif"];
          $this->name = $datas["name"];
          
          
        }

        public static function getByIdCheckBox ($idCheckBox) {
          $sql = "SELECT * FROM historique WHERE idCheckBox = :idCheckBox ;";
          try {
            $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
            $query = $db->prepare($sql);
            $query->bindParam("idCheckBox", $idCheckBox, PDO::PARAM_STR);
            $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "historique");
              
            $query->execute();
            $result= $query->fetchAll();

            return $result;


          } catch (Exception $e) {
          echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
          }
        }

        public function getHistorique() {
          $sql = "SELECT * FROM historique ;";
          try {
              $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
              $query = $db->prepare($sql);
              $query->bindParam("idCheckBox", $this->idCheckBox, PDO::PARAM_STR);
              $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "historique");
                
              $query->execute();
              $result= $query->fetchAll();

              return $result;


            } catch (Exception $e) {
            echo "<h3>Une erreur SQL s'est produite</h3>" . $e.getMessage();
            }

        }

        public function saveInDb() {
          $sql = "INSERT INTO  historique (idCheckBox, descriptif, name) VALUES (:idCheckBox, :descriptif, :name);"; 

          try {
                
            $db = new PDO("mysql: host=" . DB::HOST . "; port=" . DB::PORT . "; dbname=" . DB::DBNAME . "; charset=utf8", DB::DBUSER, DB::DBPASS);
            $query = $db->prepare($sql);
            $query->bindParam("idCheckBox", $this->idCheckBox, PDO::PARAM_STR);
            $query->bindParam("descriptif", $this->descriptif, PDO::PARAM_STR);
            $query->bindParam("name", $this->name, PDO::PARAM_STR);
           
            
          echo  $query->execute();
            
        } catch (Exception $e) {
        echo "<h3>Une erreur SQL s'est produite</h3>" . $e->getMessage();
            }
        }
       

     
}