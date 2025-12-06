<?php
require_once('BaseEntity.php');
class InfraHeater extends BaseEntity{
    private $model;
    private $vendor;
    private $price;
	private $workPrinc;
	private $sphereOfAppl;
    private $properties;
    public function __construct($id,$model,$vendor,$price,$workPrinc,$sphereOfAppl,$properties){
        $this->id=$id;
        $this->model=$model;
        $this->vendor=$vendor;
        $this->price=$price;
        $this->workPrinc=$workPrinc;
        $this->sphereOfAppl=$sphereOfAppl;
        $this->properties=$properties;
    }
    public function display(){
        echo $this->id.". ".$this->vendor." ".$this->model."</br>";
        echo "Принцип роботи: <i>".$this->workPrinc."</i></br>";
		echo "Сфера застосування: <i>".$this->sphereOfAppl."</i></br>";
        echo "Ціна: <b>".$this->price."</b> грн</br>";
        echo "<b>Характеристики:</b></br>";
        foreach (json_decode($this->properties) as $propertyName => $propertyValue) {
            echo $propertyName . ": " . $propertyValue . "</br>";
        }
    }
    public function update($model,$vendor,$price,$workPrinc,$sphereOfAppl,$properties){
        $this->model=$model;
        $this->vendor=$vendor;
        $this->price=$price;
        $this->workPrinc=$workPrinc;
        $this->sphereOfAppl=$sphereOfAppl;
        $this->properties=$properties;
    }
    public function __destruct(){
        $this->id=null;
        $this->model=null;
        $this->vendor=null;
        $this->price=null;
        $this->workPrinc=null;
		$this->sphereOfAppl=null;
        $this->properties=null;
    }
    public function getAsJSON(){
        return '{
            "id": "'.$this->id.'",
            "model": "'.$this->model.'",
            "vendor": "'.$this->vendor.'",
            "price": "'.$this->price.'",
            "workPrinc": "'.$this->workPrinc.'",
            "sphereOfAppl": "'.$this->sphereOfAppl.'",
            "properties": '.$this->properties.'
        }';
    }
    public function getAsXML(){
        $properties='';
        foreach (json_decode($this->properties) as $propertyName => $propertyValue) {
            $properties.='<property>
                            <name>'.$propertyName.'</name>
                            <value>'.$propertyValue.'</value>
            </property>';
        }
        return '<sunscreen>
                    <id>'.$this->id.'</id>
                    <model>'.$this->model.'</model>
                    <vendor>'.$this->vendor.'</vendor>
                    <price>'.$this->price.'</price>
                    <workprinc>'.$this->workPrinc.'</workprinc>
                    <sphereofappl>'.$this->sphereOfAppl.'</sphereofappl>
                    <properties>'.$properties.'</properties>
                </sunscreen>';
    }
    public function getAsAssociativeArray(){
        return [
                'id'=>$this->id,
                'model'=>$this->model,
                'vendor'=>$this->vendor,
                'price'=>$this->price,
                'workPrinc'=>$this->workPrinc,
                'sphereOfAppl'=>$this->sphereOfAppl,
                'properties'=>$this->properties
                ];
    }
    public function getAsTableRow(){
        $properties="";
        foreach (json_decode($this->properties) as $propertyName => $propertyValue) {
            $properties.= $propertyName . ": " . $propertyValue . "</br>";
        }
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->model.'</td>
                    <td>'.$this->vendor.'</td>
                    <td>'.$this->workPrinc.'</td>
                    <td>'.$this->sphereOfAppl.'</td>
                    <td>'.$this->price.'</td>
                    <td>'.$properties.'</td>
                    <td>
                        <a class="btn btn-warning" href="./InfraHeaters.php?action=update&id='.$this->id.'">Редагувати</a>
                        <a class="btn btn-danger" href="./InfraHeaters.php?action=delete&id='.$this->id.'">Видалити</a>
                    </td>
                </tr>';
    }
    public function getAsIndexedArray(){
        return [$this->model,$this->vendor,$this->price,$this->workPrinc,$this->sphereOfAppl,$this->properties];
    }
}