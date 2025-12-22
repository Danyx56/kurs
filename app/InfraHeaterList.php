<?php
require_once('BaseList.php');
require_once('InfraHeater.php');
require_once('DBConnect.php');
class InfraHeaterList extends BaseList{
	public function add($params){
        $elem=new InfraHeater($params['id'],$params['model'],$params['vendorid'],$params['vendorname'],$params['price'],$params['workprincid'],$params['workprincname'],$params['sphereofapplid'],$params['sphereofapplname']);
        array_push($this->list, $elem);
    }
    public function getAllFromDatabase(){
        global $conn;
        $sql = "SELECT infraheaters.*, vendors.name vendorname, workprincs.name workprincname, spheresofappl.name sphereofapplname FROM infraheaters
        INNER JOIN vendors ON vendors.id=infraheaters.vendorid 
        INNER JOIN workprincs ON workprincs.id=infraheaters.workprincid 
        INNER JOIN spheresofappl ON spheresofappl.id=infraheaters.sphereofapplid
        ORDER BY id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $this->add($row);
        }
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
        $stmtCheck = $conn->prepare("SELECT id FROM infraheatersproperties WHERE infraheaterid=? AND propertyid=?");
        $stmtCheck->bind_param("ss", $infraheaterid, $propertyid);
        $stmtCheck->execute();
        if($stmtCheck->get_result()->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE `infraheatersproperties` SET `value`=? WHERE `infraheaterid`=? and `propertyid`=?;");
            $stmt->bind_param("sss", $value,$infraheaterid,$propertyid);
            $stmt->execute();
        } else {
            if($value !== '') {
                $this->addInfraHeaterProperty($infraheaterid, $propertyid, $value);
            }
        }
    }
    public function insertIntoDatabase($params){
        global $conn;
        $stmtCheck = $conn->prepare("SELECT id FROM infraheaters WHERE vendorid = ? AND model = ?");
        $stmtCheck->bind_param("ss", $params['vendorid'], $params['model']);
        $stmtCheck->execute();
        if ($stmtCheck->get_result()->num_rows > 0) {
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO infraheaters VALUES (DEFAULT, ?,?,?,?,?)");
        $stmt->bind_param("ssdss", $params['vendorid'],$params['model'],$params['price'],$params['workprincid'],$params['sphereofapplid']);
        $stmt->execute();
        return $conn->insert_id;
    }
    public function updateDatabaseById($params){
        global $conn;
        $stmtCheck = $conn->prepare("SELECT id FROM infraheaters WHERE vendorid = ? AND model = ? AND id != ?");
        $stmtCheck->bind_param("sss", $params['vendorid'], $params['model'], $params['id']);
        $stmtCheck->execute();
        if ($stmtCheck->get_result()->num_rows > 0) return false;

        $stmt = $conn->prepare("UPDATE `infraheaters` SET `vendorid`=?, `model`=?,`price`=?, `workprincid`=?, `sphereofapplid`=? WHERE `id`=?;");
        $stmt->bind_param("ssdsss", $params['vendorid'],$params['model'],$params['price'],$params['workprincid'],$params['sphereofapplid'],$params['id']);
        $stmt->execute();
        return true;
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
    public function getAllFromDatabaseBySearchCriteria($search){
        global $conn;
        $stmt = $conn->prepare("SELECT infraheaters.*, vendors.name vendorname, workprincs.name workprincname, spheresofappl.name sphereofapplname FROM infraheaters
        INNER JOIN vendors ON vendors.id=infraheaters.vendorid 
        INNER JOIN workprincs ON workprincs.id=infraheaters.workprincid
        INNER JOIN spheresofappl ON spheresofappl.id=infraheaters.sphereofapplid WHERE vendors.name LIKE ? OR infraheaters.model LIKE ? OR workprincs.name LIKE ? OR spheresofappl.name LIKE ?
        ORDER BY id");
        $stmt->bind_param("ssss", $search,$search,$search,$search);
        $search="%".$search."%";
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $this->add($row);
        }
        }
    }
}
?>