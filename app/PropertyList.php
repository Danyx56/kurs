<?php
require_once('BaseList.php');
require_once('Property.php');
require_once('DBConnect.php');
class PropertyList extends BaseList{
    public function add($params){
        $elem=new Property($params['id'],$params['name'],$params['units']);
        array_push($this->list, $elem);
    }
    public function update($params){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$params['id']){
                $this->list[$i]->update($params['name'],$params['units']);
                break;
            }
        }
    }
    public function getAsJSON(){
        $content='{
    "properties": [';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsJSON().",";
        }
        $content = substr($content, 0, -1);
        $content.='    ]
        }';
        return $content;
    }
    public function getAsXML(){
        $content='<properties>
        ';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsXML();
        }
        $content.='</properties>';
        return $content;
    }
    public function readFromCSV($filePath){
        $fp = fopen($filePath, 'r');
        if ($fp === false) {
            die('Error: Cannot open the CSV file.');
        }
        while (($row = fgetcsv($fp,10000,",","`","\\")) !== false) {
            $this->add(['name'=>$row[0],'units'=>$row[1]]);
        }
        fclose($fp);
    }
    public function getAllFromDatabase(){
        global $conn;
        $sql = "SELECT * FROM properties";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $this->add($row);
        }
        }
    }
    public function getAllFromDatabaseById($id){
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM properties WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            return $row;
        }
        } else{
            return null;
        }
    }
    public function getAsInputGroup($itemProps){
        $inputContent='';
        for ($i=0;$i<count($this->list);$i++){
            $isValueSet=false;
            for ($j=0;$j<count($itemProps);$j++){
                if($itemProps[$j]['propertyid']==$this->list[$i]->getId()){
                    $inputContent.=$this->list[$i]->getAsInput($itemProps[$j]['value']);
                    $isValueSet=true;
                }
            }
            if(!$isValueSet){
                $inputContent.=$this->list[$i]->getAsInput('');
            }
        }
        return $inputContent;
    }
    public function insertIntoDatabase($params){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO properties VALUES (DEFAULT, ?,?)");
        $stmt->bind_param("ss", $params['name'],$params['units']);
        $stmt->execute();
        $this->add(['id'=>$conn->insert_id,'name'=>$params['name'],'units'=>$params['units']]);
        return $conn->insert_id;
    }
    public function updateDatabaseById($params){
        global $conn;
        $stmt = $conn->prepare("UPDATE `properties` SET `name`=?, `units`=? WHERE `id`=?;");
        $stmt->bind_param("sss", $params['name'],$params['units'],$params['id']);
        $stmt->execute();
    }
    public function deleteFromDatabaseById($id){
        global $conn;
        $stmt = $conn->prepare("DELETE FROM properties WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
    }
}