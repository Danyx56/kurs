<?php
require_once('BaseEntity.php');
class SphereOfAppl extends BaseEntity{
    private $name;
    public function __construct($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
    }
    public function display(){
        echo $this->id.". ".$this->name."</br>";
    }
    public function update($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
    }
    public function getAsJSON(){
        return '{
            "id": "'.$this->id.'",
            "name": "'.$this->name.'"
        }';
    }
    public function getAsXML(){
        return '<sphereofappl>
                    <id>'.$this->id.'</id>
                    <name>'.$this->name.'</name>
                </sphereofappl>';
    }
    public function getAsIndexedArray(){
        return [$this->name];
    }
}
?>