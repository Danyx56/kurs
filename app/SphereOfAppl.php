<?php
require_once('BaseEntity.php');
class SphereOfAppl extends BaseEntity{
    private $name;
    public function __construct($id, $name){
        $this->id=$id;
        $this->name=$name;
    }
    public function getAsAssociativeArray(){
        return [
                'id'=>$this->id,
                'name'=>$this->name
                ];
    }
    public function getAsTableRow(){
        return '<tr class="align-middle shadow-hover">
                    <td class="fw-bold text-center">'.$this->id.'</td>
                    <td class="fw-semibold text-primary">'.$this->name.'</td>
                    <td>
                        <a class="btn btn-outline-warning btn-sm me-1" href="./SpheresOfAppl.php?action=update&id='.$this->id.'">Редагувати</a>
                        <a class="btn btn-outline-danger btn-sm" href="./SpheresOfAppl.php?action=delete&id='.$this->id.'">Видалити</a>
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