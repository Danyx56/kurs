<?php
abstract class BaseList{
    protected $list;
    protected $lastId;
    public function __construct(){
        $this->list=[];
    }
    public function getById($id){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$id){
                return $this->list[$i]->getAsAssociativeArray();
            }
        }
    }
    public function getAsTableBody(){
        $content='
        ';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsTableRow();
        }
        return $content;
    }
    public function getAsAssocArray(){
        $array=[];
        for ($i=0;$i<count($this->list);$i++){
            array_push($array,$this->list[$i]->getAsAssociativeArray());
        }
        return $array;
    }
    public abstract function add($params);
}