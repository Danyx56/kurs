<?php
require_once('BaseList.php');
require_once('Vendor.php');
require_once('DBConnect.php');
class VendorList extends BaseList{
	public function add($params){
        $elem=new Vendor($params['id'],$params['name']);
        array_push($this->list, $elem);
    }
    public function getAllFromDatabase(){
        global $conn;
        $sql = "SELECT * FROM vendors ORDER BY id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $this->add($row);
        }
        }
    }
    public function insertIntoDatabase($params){
        global $conn;
        $stmtCheck = $conn->prepare("SELECT id FROM vendors WHERE name = ?");
        $stmtCheck->bind_param("s", $params['name']);
        $stmtCheck->execute();
        if ($stmtCheck->get_result()->num_rows > 0) {
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO vendors VALUES (DEFAULT, ?)");
        $stmt->bind_param("s", $params['name']);
        $stmt->execute();
        $this->add(['id'=>$conn->insert_id,'name'=>$params['name']]);
        return $conn->insert_id;
    }
    public function updateDatabaseById($params){
        global $conn;
        $stmtCheck = $conn->prepare("SELECT id FROM vendors WHERE name = ? AND id != ?");
        $stmtCheck->bind_param("ss", $params['name'], $params['id']);
        $stmtCheck->execute();
        if ($stmtCheck->get_result()->num_rows > 0) {
            return false;
        }
        $stmt = $conn->prepare("UPDATE `vendors` SET `name`=? WHERE `id`=?;");
        $stmt->bind_param("ss", $params['name'],$params['id']);
        $stmt->execute();
        return true;
    }
    public function deleteFromDatabaseById($id){
        global $conn;
        $stmtCheck = $conn->prepare("SELECT id FROM infraheaters WHERE vendorid = ?");
        $stmtCheck->bind_param("s", $id);
        $stmtCheck->execute();
        if ($stmtCheck->get_result()->num_rows > 0) {
            return false;
        }
        $stmt = $conn->prepare("DELETE FROM vendors WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        return true;
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