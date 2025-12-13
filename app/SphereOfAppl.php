<?php
require_once('BaseEntity.php');
class SphereOfAppl extends BaseEntity{
    private $name;
    public function __construct($id, $name){
        $this->id=$id;
        $this->name=$name;
    }
    public function display(){
        echo $this->id.". ".$this->name."</br>";
    }
    public function update($name){
        $this->name=$name;
    }
    public function getAsIndexedArray(){
        return [$this->name];
    }
    public function getAsAssociativeArray(){
        return [
                'id'=>$this->id,
                'name'=>$this->name
                ];
    }
    public function getAsJSON(){
        return '{
            "id": "'.$this->id.'",
            "name": "'.$this->name.'"
        }';
    }
    public function getAsXML(){
        return '<sphereofAppl>
                    <id>'.$this->id.'</id>
                    <name>'.$this->name.'</name>
                </sphereofappl>';
    }
    public function getAsTableRow(){
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->name.'</td>
                    <td>
                        <a class="btn btn-warning" href="./SpheresOfAppl.php?action=update&id='.$this->id.'">Редагувати</a>
                        <a class="btn btn-danger" href="./SpheresOfAppl.php?action=delete&id='.$this->id.'">Видалити</a>
                    </td>
                </tr>';
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
    }
    public function getAsOption($isSelected){
        if($isSelected){
            return "<option value='$this->id' selected>$this->name</option>";
        } else{
            return "<option value='$this->id'>$this->name</option>";
        }
    }
}