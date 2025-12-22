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
    public function getAsAssociativeArray(){
        return [
                'id'=>$this->id,
                'name'=>$this->name,
                'units'=>$this->units
                ];
    }
    public function getAsTableRow(){
        return '<tr class="align-middle shadow-hover">
                    <td class="fw-bold text-center">'.$this->id.'</td>
                    <td class="fw-semibold text-primary">'.$this->name.'</td>
                    <td>'.$this->units.'</td>
                    <td>
                        <a class="btn btn-outline-warning btn-sm me-1" href="./Properties.php?action=update&id='.$this->id.'">Редагувати</a>
                        <a class="btn btn-outline-danger btn-sm" href="./Properties.php?action=delete&id='.$this->id.'">Видалити</a>
                    </td>
                </tr>';
    }
    public function getAsInput($value){
        if($this->name=='Додаткові функції'){
            return '<p>
                            <input type="text" name="prop-'.$this->id.'" value="'.$value.'" class="form-control" placeholder="'.$this->name.'"/>
                        </p>';
        }else{
            return '<p>
                            <input type="text" name="prop-'.$this->id.'" value="'.$value.'" class="form-control" placeholder="'.$this->name.' '.$this->units.'" required/>
                        </p>';
        }
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
        $this->units=null;
    }
}