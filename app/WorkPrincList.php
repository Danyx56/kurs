<?php
require_once('BaseList.php');
require_once('WorkPrinc.php');
require_once('DBConnect.php');
class WorkPrincList extends BaseList{
	public function add($params){
        $elem=new WorkPrinc($params['id'],$params['name']);
        array_push($this->list, $elem);
    }
    public function update($params){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$params['id']){
                $this->list[$i]->update($params['name']);
                break;
            }
        }
    }
    public function getAsJSON(){
        $content='{
    "workPrincs": [';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsJSON().",";
        }
        $content = substr($content, 0, -1);
        $content.='    ]
        }';
        return $content;
    }
    public function getAsXML(){
        $content='<workprincs>
        ';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsXML();
        }
        $content.='</workprincs>';
        return $content;
    }
	public function readFromCSV($filePath){
        $fp = fopen($filePath, 'r');
        if ($fp === false) {
            die('Error: Cannot open the CSV file.');
        }
        while (($row = fgetcsv($fp,10000,",","`","\\")) !== false) {
            $this->add(['name'=>$row[0]]);
        }
        fclose($fp);
    }
    public function getAllFromDatabase(){
        global $conn;
        $sql = "SELECT * FROM workprincs";
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
        $stmt = $conn->prepare("SELECT * FROM workprincs WHERE id=?");
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
    
    public function insertIntoDatabase($params){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO workprincs VALUES (DEFAULT, ?)");
        $stmt->bind_param("s", $params['name']);
        $stmt->execute();
        $this->add(['id'=>$conn->insert_id,'name'=>$params['name']]);
        return $conn->insert_id;
    }
    public function updateDatabaseById($params){
        global $conn;
        $stmt = $conn->prepare("UPDATE `workprincs` SET `name`=? WHERE `id`=?;");
        $stmt->bind_param("ss", $params['name'],$params['id']);
        $stmt->execute();
    }
    public function deleteFromDatabaseById($id){
        global $conn;
        $stmt = $conn->prepare("DELETE FROM workprincs WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
    }
    public function getAsSelectOptions($selectedId){
        $content='';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsOption($selectedId==$this->list[$i]->getId());
        }
        return $content;
    }
}
?>