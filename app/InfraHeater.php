<?php
require_once('BaseEntity.php');
require_once('DBConnect.php');
class InfraHeater extends BaseEntity{
    private $model;
    private $vendorid;
    private $vendorname;
    private $price;
	private $workPrincid;
    private $workPrincname;
	private $sphereOfApplid;
    private $sphereOfApplname;
    public function __construct($id,$model,$vendorid,$vendorname,$price,$workPrincid,$workPrincname,$sphereOfApplid,$sphereOfApplname){
        $this->id=$id;
        $this->model=$model;
        $this->vendorid=$vendorid;
        $this->vendorname=$vendorname;
        $this->price=$price;
        $this->workPrincid=$workPrincid;
        $this->workPrincname=$workPrincname;
        $this->sphereOfApplid=$sphereOfApplid;
        $this->sphereOfApplname=$sphereOfApplname;
    }
    public function __destruct(){
        $this->id=null;
        $this->model=null;
        $this->vendorid=null;
        $this->price=null;
        $this->workPrincid=null;
		$this->sphereOfApplid=null;
    }
    public function getAsAssociativeArray(){
        return [
                'id'=>$this->id,
                'model'=>$this->model,
                'vendorid'=>$this->vendorid,
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
        while($row = $result->fetch_assoc()) {
            array_push($array,$row);
        }
        } 
        return $array;
    }
    public function getAsTableRow(){
        $propArray=$this->getInfraHeatersProperties();
        
        $propertiesContent='<ul class="list-unstyled mb-0 small">'; 
        for($i=0;$i<count($propArray);$i++){
            $propertiesContent.='<li><span class="text-muted">'.$propArray[$i]['name'].':</span> <strong>'.$propArray[$i]['value'].' '.$propArray[$i]['units'].'</strong></li>';
        }
        $propertiesContent.='</ul>';

        return '<tr class="align-middle shadow-hover">
                    <td class="fw-bold text-center">'.$this->id.'</td>
                    <td class="fw-semibold text-primary">'.$this->model.'</td>
                    <td>'.$this->vendorname.'</td>
                    <td>'.$this->workPrincname.'</td>
                    <td>'.$this->sphereOfApplname.'</td>
                    <td class="fs-5 text-nowrap">'.$this->price.' <small class="fs-6 text-muted">грн</small></td>
                    <td>'.$propertiesContent.'</td>
                    <td class="text-end text-nowrap">
                        <a class="btn btn-outline-warning btn-sm me-1" href="./InfraHeaters.php?action=update&id='.$this->id.'">Ред.</a>
                        <a class="btn btn-outline-danger btn-sm" href="./InfraHeaters.php?action=delete&id='.$this->id.'">Вид.</a>
                    </td>
                </tr>';
    }
}