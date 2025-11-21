<?php
require_once('BaseEntity.php');
class Property extends BaseEntity{
    private $name;
    private $units;
    public function __construct($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
		$this->units=$params['units'];
    }
    public function display(){
        echo $this->id.". ".$this->name." <i>(".$this->units.")</i></br>";
    }
    public function update($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
		$this->units=$params['units'];
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
        $this->units=null;
    }
    public function getAsJSON(){
        return '{
            "id": "'.$this->id.'",
            "name": "'.$this->name.'",
            "units": "'.$this->units.'"
        }';
    }
    public function getAsXML(){
        return '<property>
                    <id>'.$this->id.'</id>
                    <name>'.$this->name.'</name>
                    <units>'.$this->units.'</units>
                </property>';
    }
    public function getAsIndexedArray(){
        return [$this->name,$this->units];
    }
}
?>