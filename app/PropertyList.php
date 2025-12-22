<?php
require_once('BaseList.php');
require_once('Property.php');
require_once('DBConnect.php');
class PropertyList extends BaseList{
    public function add($params){
        $elem=new Property($params['id'],$params['name'],$params['units']);
        array_push($this->list, $elem);
    }
    public function getAllFromDatabase(){
        global $conn;
        $sql = "SELECT * FROM properties ORDER BY id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $this->add($row);
        }
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
        $stmtCheck = $conn->prepare("SELECT id FROM properties WHERE name = ?");
        $stmtCheck->bind_param("s", $params['name']);
        $stmtCheck->execute();
        if ($stmtCheck->get_result()->num_rows > 0) {
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO properties VALUES (DEFAULT, ?,?)");
        $stmt->bind_param("ss", $params['name'],$params['units']);
        $stmt->execute();
        $this->add(['id'=>$conn->insert_id,'name'=>$params['name'],'units'=>$params['units']]);
        return $conn->insert_id;
    }
    public function updateDatabaseById($params){
        global $conn;
        $stmtCheck = $conn->prepare("SELECT id FROM properties WHERE name = ? AND id != ?");
        $stmtCheck->bind_param("ss", $params['name'], $params['id']);
        $stmtCheck->execute();
        if ($stmtCheck->get_result()->num_rows > 0) return false;

        $stmt = $conn->prepare("UPDATE `properties` SET `name`=?, `units`=? WHERE `id`=?;");
        $stmt->bind_param("sss", $params['name'],$params['units'],$params['id']);
        $stmt->execute();
        return true;
    }
    public function deleteFromDatabaseById($id){
        global $conn;
        $stmt = $conn->prepare("DELETE FROM properties WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
    }
}