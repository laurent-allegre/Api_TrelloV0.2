<?php



class Apitrello {
    public function __construct() {
        
          

    }    
    protected $key= 'ecad7786e227153f65c24f308dc6d9c2';
    protected $token= '1d2d5a7dd93b817dfc4c546fccaa7d2d53211d459ca5f77f03456821a3798a87';
    protected $url= 'https://api.trello.com';
    protected $cert=  'C:\workspace\Api_TrelloV0.2\cert.cer';

    /**
     * Retourne un tableau de la  liste de tous les Boards
     */
    public function getBoards() {
        $curl = curl_init($this->url . '/1/members/me/boards?key='.$this->key.'&token=' .$this->token );

            curl_setopt_array($curl, [
                CURLOPT_CAINFO => $this->cert,
                CURLOPT_RETURNTRANSFER => true ,
                //CULOPT_TIMEOUT => 1
            ]);

            $data = curl_exec($curl);

            if ($data === false) {
                var_dump(curl_error($curl));
            } else {
                if(curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200) {
                    
                return  $data = json_decode($data, true);
                } else {
                    return [];
                }
            }
            curl_close($curl); 

    }

    public function getLists($idBoard) {
        $listCard= curl_init ('https://api.trello.com/1/board/'. $idBoard . '?lists=open&badges=open&checklists=all&key='.$this->key.'&token=' .$this->token);
 
            curl_setopt_array($listCard, [
                CURLOPT_CAINFO => $this->cert,
                CURLOPT_RETURNTRANSFER => true ,
                //CULOPT_TIMEOUT => 1

            ]);

            $data1 = curl_exec($listCard);
            
            if ($data1 === false) {
                var_dump(curl_error($listCard));
            } else {
                if(curl_getinfo($listCard, CURLINFO_HTTP_CODE) === 200) {
                   return $data1 = json_decode($data1, true);
                   
                    
                }else {
                    return [];
                }
            }
            curl_close($listCard);
           
    }
/**
 *  on recupere les cartes du tableau selectionné
 */
    public function getCards($idBoard, $idList) {
       
        $listCard = curl_init ("https://api.trello.com/1/board/$idBoard?list=$idList&cards=open&badges=open&checklists=all&key=$this->key&token=$this->token");

        curl_setopt_array($listCard, [
            CURLOPT_CAINFO => $this->cert,
            CURLOPT_RETURNTRANSFER => true ,
            //CULOPT_TIMEOUT => 1

        ]);

        $data1 = curl_exec($listCard);
        
        if ($data1 === false) {
            var_dump(curl_error($listCard));
        } else {
            if(curl_getinfo($listCard, CURLINFO_HTTP_CODE) === 200) {
                $data1 = json_decode($data1, true);

        /**
        * on trie les cartes
        */
                foreach($data1['cards'] as $item) {

                    if ($item["idList" ]== $idList) {
                        $monTableauTri[] = $item;
                       
                    }
                } 
                return $monTableauTri ;

            }else {
                return [];
            }
        }
        curl_close($listCard); 
    } 

    /**
 *  on recupere les checklist
 */
    public function getCheckList($idBoard, $idList) {
        
        $listCard = curl_init ("https://api.trello.com/1/board/$idBoard?list=$idList&cards=open&checklists=all&checkItem=all&key=$this->key&token=$this->token");

        curl_setopt_array($listCard, [
            CURLOPT_CAINFO => $this->cert,
            CURLOPT_RETURNTRANSFER => true ,
           

        ]);

        $data1 = curl_exec($listCard);
            
            if ($data1 === false) {
                var_dump(curl_error($listCard));
            } else {
                if(curl_getinfo($listCard, CURLINFO_HTTP_CODE) === 200) {
                    $data1 = json_decode($data1, true);
                    
            /**
            * on trie les checklist
            */
                    foreach($data1['checklists'] as $item) {
                            $meschecklists[] = $item;
                    } 
                        return $meschecklists ;

                    }else {
                        return [];
                }
            }
            curl_close($listCard); 
            } 
        
    
}


                