<?php
require_once('BaseList.php');
require_once('Property.php');
class PropertyList extends BaseList{
    public function add($params){
        $this->lastId++;
        $elem=new Property($this->lastId,$params['name'],$params['units']);
        array_push($this->list, $elem);
    }
    public function update($params){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$params['id']){
                $this->list[$i]->update($params['name'],$params['units']);
                break;
            }
        }
    }
    public function getAsJSON(){
        $content='{
    "properties": [';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsJSON().",";
        }
        $content = substr($content, 0, -1);
        $content.='    ]
        }';
        return $content;
    }
    public function getAsXML(){
        $content='<properties>
        ';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsXML();
        }
        $content.='</properties>';
        return $content;
    }
    public function readFromCSV($filePath){
        $fp = fopen($filePath, 'r');
        if ($fp === false) {
            die('Error: Cannot open the CSV file.');
        }
        while (($row = fgetcsv($fp,10000,",","`","\\")) !== false) {
            $this->add(['name'=>$row[0],'units'=>$row[1]]);
        }
        fclose($fp);
    }
}