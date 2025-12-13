<?php
require_once('BaseEntity.php');
require_once('DBConnect.php');
class InfraHeater extends BaseEntity{
    private $model;
    private $vendor;
    private $price;
	private $workPrincid;
    private $workPrincname;
	private $sphereOfApplid;
    private $sphereOfApplname;
    public function __construct($id,$model,$vendor,$price,$workPrincid,$workPrincname,$sphereOfApplid,$sphereOfApplname){
        $this->id=$id;
        $this->model=$model;
        $this->vendor=$vendor;
        $this->price=$price;
        $this->workPrincid=$workPrincid;
        $this->workPrincname=$workPrincname;
        $this->sphereOfApplid=$sphereOfApplid;
        $this->sphereOfApplname=$sphereOfApplname;
    }
    public function display(){
        echo $this->id.". ".$this->vendor." ".$this->model."</br>";
        echo "Принцип роботи: <i>".$this->workPrincid."</i></br>";
		echo "Сфера застосування: <i>".$this->sphereOfApplid."</i></br>";
        echo "Ціна: <b>".$this->price."</b> грн</br>";
    }
    public function update($model,$vendor,$price,$workPrincid,$sphereOfApplid){
        $this->model=$model;
        $this->vendor=$vendor;
        $this->price=$price;
        $this->workPrincid=$workPrincid;
        $this->sphereOfApplid=$sphereOfApplid;
    }
    public function __destruct(){
        $this->id=null;
        $this->model=null;
        $this->vendor=null;
        $this->price=null;
        $this->workPrincid=null;
		$this->sphereOfApplid=null;
    }
    public function getAsJSON(){
        return '{
            "id": "'.$this->id.'",
            "model": "'.$this->model.'",
            "vendor": "'.$this->vendor.'",
            "price": "'.$this->price.'",
            "workPrincid": "'.$this->workPrincid.'",
            "workPrincname": "'.$this->workPrincname.'",
            "sphereOfApplid": "'.$this->sphereOfApplid.'",
            "sphereOfApplname": "'.$this->sphereOfApplname.'",
            "properties":'.json_encode($this->getInfraHeatersProperties()).'
        }';
    }
    public function getAsXML(){
        return '<infraheater>
                    <id>'.$this->id.'</id>
                    <model>'.$this->model.'</model>
                    <vendor>'.$this->vendor.'</vendor>
                    <price>'.$this->price.'</price>
                    <workPrinc>'.$this->workPrincid.'</workPrinc>
                    <sphereOfAppl>'.$this->sphereOfApplid.'</sphereOfAppl>
                </infraheater>';
    }
    public function getAsAssociativeArray(){
        return [
                'id'=>$this->id,
                'model'=>$this->model,
                'vendor'=>$this->vendor,
                'price'=>$this->price,
                'workPrincid'=>$this->workPrincid,
                'sphereOfApplid'=>$this->sphereOfApplid
                ];
    }
    public function getInfraHeatersProperties(){
        global $conn;
        $stmt = $conn->prepare("SELECT infraheatersproperties.*, properties.name, properties.units FROM infraheatersproperties
        INNER JOIN properties ON properties.id=infraheatersproperties.propertyid WHERE infraheaterid=?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $array=[];
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($array,$row);
        }
        } 
        return $array;
    }
    public function getAsTableRow(){
        $propArray=$this->getInfraHeatersProperties();
        $propertiesContent='';
        for($i=0;$i<count($propArray);$i++){
            $propertiesContent.=$propArray[$i]['name'].': '.$propArray[$i]['value'].' '.$propArray[$i]['units'].'</br>';
        }
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->model.'</td>
                    <td>'.$this->vendor.'</td>
                    <td>'.$this->workPrincname.'</td>
                    <td>'.$this->sphereOfApplname.'</td>
                    <td>'.$this->price.'</td>
                    <td>'.$propertiesContent.'</td>
                    <td>
                        <a class="btn btn-warning" href="./InfraHeaters.php?action=update&id='.$this->id.'">Редагувати</a>
                        <a class="btn btn-danger" href="./InfraHeaters.php?action=delete&id='.$this->id.'">Видалити</a>
                    </td>
                </tr>';
    }
    public function getAsIndexedArray(){
        return [$this->model,$this->vendor,$this->price,$this->workPrincid,$this->sphereOfApplid];
    }
}