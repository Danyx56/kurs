<?php
require_once('BaseEntity.php');
class Property extends BaseEntity{
    private $name;
    private $units;
    public function __construct($id, $name, $units){
        $this->id=$id;
        $this->name=$name;
        $this->units=$units;
    }
    public function display(){
        echo $this->id.". ".$this->name." <i>(".$this->units.")</i></br>";
    }
    public function update($name, $units){
        $this->name=$name;
        $this->units=$units;
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
    public function getAsAssociativeArray(){
        return [
                'id'=>$this->id,
                'name'=>$this->name,
                'units'=>$this->units
                ];
    }
    public function getAsTableRow(){
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->name.'</td>
                    <td>'.$this->units.'</td>
                    <td>
                        <a class="btn btn-warning" href="./Properties.php?action=update&id='.$this->id.'">Редагувати</a>
                        <a class="btn btn-danger" href="./Properties.php?action=delete&id='.$this->id.'">Видалити</a>
                    </td>
                </tr>';
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
        $this->units=null;
    }
    public function getAsIndexedArray(){
        return [$this->name,$this->units];
    }
}