<?php
abstract class BaseList{
    protected $list;
    protected $lastId;
    public function __construct(){
        $this->list=[];
        $this->lastId=0;
    }
    public function display(){
        for ($i=0;$i<count($this->list);$i++){
            $this->list[$i]->display();
        }
    }
    public function delete($id){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$id){
                array_splice($this->list,$i,1);
                break;
            }
        }
    }
    public function getById($id){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$id){
                return $this->list[$i]->getAsAssociativeArray();
            }
        }
    }
    public function writeToCSV($filePath){
        $fp = fopen($filePath, 'w');
        if ($fp === false) {
            die('Error opening the file ');
        }
        foreach ($this->list as $elem) {
            fputcsv($fp, $elem->getAsIndexedArray(),",","`","\\");
        }
        fclose($fp);
    }
    public function getAsTableBody(){
        $content='
        ';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsTableRow();
        }
        return $content;
    }
    public abstract function add($params);
    public abstract function update($params);
    public abstract function readFromCSV($filePath);
    public abstract function getAsJSON();
    public abstract function getAsXML();
}