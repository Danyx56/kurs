<?php
require_once('BaseEntity.php');
class InfraHeater extends BaseEntity{
    private $model;
    private $vendor;
    private $price;
	private $workPrinc;
	private $sphereOfAppl;
    private $properties;
    public function __construct($params){
        $this->id=$params['id'];
        $this->model=$params['model'];
		$this->vendor=$params['vendor'];
		$this->price=$params['price'];
		$this->workPrinc=$params['workPrinc'];
		$this->sphereOfAppl=$params['sphereOfAppl'];
		$this->properties=$params['properties'];
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
    public function update($params){
        $this->id=$params['id'];
        $this->model=$params['model'];
		$this->vendor=$params['vendor'];
		$this->price=$params['price'];
        $this->workPrinc=$params['workPrinc'];
		$this->sphereOfAppl=$params['sphereOfAppl'];
		$this->properties=$params['properties'];
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
        return '<infraheater>
                    <id>'.$this->id.'</id>
                    <model>'.$this->model.'</model>
                    <vendor>'.$this->vendor.'</vendor>
                    <price>'.$this->price.'</price>
                    <workprinc>'.$this->workPrinc.'</workprinc>
                    <sphereofappl>'.$this->sphereOfAppl.'</sphereofappl>
                    <properties>'.$properties.'</properties>
                </infraheater>';
    }
    public function getAsIndexedArray(){
        return [$this->id,$this->model,$this->vendor,$this->price,$this->workPrinc,$this->sphereOfAppl,$this->properties];
    }
}
?>