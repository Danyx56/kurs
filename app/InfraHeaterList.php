<?php
require_once('BaseList.php');
require_once('InfraHeater.php');
class InfraHeaterList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new InfraHeater($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
    public function getAsJSON(){
        $content='{
    "infraHeaters": [';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsJSON().",";
        }
        $content = substr($content, 0, -1);
        $content.='    ]
        }';
        return $content;
    }
    public function getAsXML(){
        $content='<infraheaters>
        ';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsXML();
        }
        $content.='</infraheaters>';
        return $content;
    }
	public function readFromCSV($filePath){
        $fp = fopen($filePath, 'r');
        if ($fp === false) {
            die('Error: Cannot open the CSV file.');
        }
        while (($row = fgetcsv($fp,10000,",","`","\\")) !== false) {
            $this->add(['model'=>$row[0], 'vendor'=>$row[1],'price'=>$row[2],'workPrinc'=>$row[3],'sphereOfAppl'=>$row[4],'properties'=>$row[5]]);
        }
        fclose($fp);
    }
}
?>