<?php
require_once('BaseList.php');
require_once('WorkPrinc.php');
class WorkPrincList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new WorkPrinc($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
    public function getAsJSON(){
        $content='{
    "workPrincs": [';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsJSON().",";
        }
        $content = substr($content, 0, -1);
        $content.='    ]
        }';
        return $content;
    }
    public function getAsXML(){
        $content='<workprincs>
        ';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsXML();
        }
        $content.='</workprincs>';
        return $content;
    }
	public function readFromCSV($filePath){
        $fp = fopen($filePath, 'r');
        if ($fp === false) {
            die('Error: Cannot open the CSV file.');
        }
        while (($row = fgetcsv($fp,10000,",","`","\\")) !== false) {
            $this->add(['name'=>$row[0]]);
        }
        fclose($fp);
    }
}
?>