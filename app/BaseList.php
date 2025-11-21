<?php
abstract class BaseList{
	protected $lastId;
	protected $list;
	public function __construct(){
		$this->lastId=1;
		$this->list=array();
	}
	public abstract function add($params);
	public function display(){
		for($i=0;$i<count($this->list);$i++){
			$this->list[$i]->display();
		}
	}
	public function update($params){
		for($i=0;$i<count($this->list);$i++){
			if($this->list[$i]->getId()==$params['id']){
				$this->list[$i]->update($params);
				break;
			}
		}
	}
	public function delete($id){
		for($i=0;$i<count($this->list);$i++){
			if($this->list[$i]->getId()==$id){
				array_splice($this->list,$i,1);
				break;
			}
		}
	}
	public function writeToCSV($filePath){
        $fp = fopen($filePath, 'w');
        if ($fp === false) {
            die('Error opening the file ');
        }
        foreach ($this->list as $elem) {
			$arr = $elem->getAsIndexedArray();
        	array_shift($arr);
            fputcsv($fp, $arr,",","`","\\");
        }
        fclose($fp);
    }
}
?>