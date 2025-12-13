<?php
require_once('BaseList.php');
require_once('InfraHeater.php');
require_once('DBConnect.php');
class InfraHeaterList extends BaseList{
	public function add($params){
        $elem=new InfraHeater($params['id'],$params['model'],$params['vendor'],$params['price'],$params['workprincid'],$params['workprincname'],$params['sphereofapplid'],$params['sphereofapplname']);
        array_push($this->list, $elem);
    }
    public function update($params){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$params['id']){
                $this->list[$i]->update($params['model'],$params['vendor'],$params['price'],$params['workPrincid'],$params['sphereOfApplid']);
                break;
            }
        }
    }
    public function getAsJSON(){
        $content='{
    "infraHeaters": [';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsJSON().",";
        }
        $content = substr($content, 0, -1);
        $content.='    ]
        }';
        return $content;
    }
    public function getAsXML(){
        $content='<infraheaters>
        ';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsXML();
        }
        $content.='</infraheaters>';
        return $content;
    }
	public function readFromCSV($filePath){
        $fp = fopen($filePath, 'r');
        if ($fp === false) {
            die('Error: Cannot open the CSV file.');
        }
        while (($row = fgetcsv($fp,10000,",","`","\\")) !== false) {
            $this->add(['model'=>$row[0], 'vendor'=>$row[1],'price'=>$row[2],'workPrincid'=>$row[3],'sphereOfApplid'=>$row[4]]);
        }
        fclose($fp);
    }
    public function getAllFromDatabase(){
        global $conn;
        $sql = "SELECT infraheaters.*, workprincs.name workprincname, spheresofappl.name sphereofapplname FROM infraheaters
        INNER JOIN workprincs ON workprincs.id=infraheaters.workprincid 
        INNER JOIN spheresofappl ON spheresofappl.id=infraheaters.sphereofapplid";
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
        $stmt = $conn->prepare("SELECT infraheaters.*, workprincs.name workprincname, spheresofappl.name sphereofapplname FROM infraheaters
        INNER JOIN workprincs ON workprincs.id=infraheaters.workprincid 
        INNER JOIN spheresofappl ON spheresofappl.id=infraheaters.sphereofapplid WHERE id=?");
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
    public function addInfraHeaterProperty($infraheaterid,$propertyid,$value){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO infraheatersproperties VALUES (DEFAULT, ?,?,?)");
        $stmt->bind_param("sss", $infraheaterid,$propertyid, $value);
        $stmt->execute();
        return $conn->insert_id;
    }
    public function updateInfraHeaterProperty($infraheaterid,$propertyid,$value){
        global $conn;
        $stmt = $conn->prepare("UPDATE `infraheatersproperties` SET `value`=? WHERE `infraheaterid`=? and `propertyid`=?;");
        $stmt->bind_param("sss", $value,$infraheaterid,$propertyid);
        $stmt->execute();
    }
    public function insertIntoDatabase($params){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO infraheaters VALUES (DEFAULT, ?,?,?,?,?)");
        $stmt->bind_param("ssdss", $params['vendor'],$params['model'],$params['price'],$params['workprincid'],$params['sphereofapplid']);
        $stmt->execute();
        return $conn->insert_id;
    }
    public function updateDatabaseById($params){
        global $conn;
        $stmt = $conn->prepare("UPDATE `infraheaters` SET `vendor`=?, `model`=?,`price`=?, `workprincid`=?, `sphereofapplid`=? WHERE `id`=?;");
        $stmt->bind_param("ssdsss", $params['vendor'],$params['model'],$params['price'],$params['workprincid'],$params['sphereofapplid'],$params['id']);
        $stmt->execute();
    }
    public function deleteFromDatabaseById($id){
        global $conn;
        $stmt = $conn->prepare("DELETE FROM infraheaters WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
    }
    public function getInfraHeaterPropertiesById($id){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$id){
                return $this->list[$i]->getInfraHeatersProperties();
            }
        }
    }
}
?>