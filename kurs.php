<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
abstract class BaseEntity{
    protected $id;
    public abstract function display();
	public abstract function update($params);
	public function getId(){
		return $this->id;
	}
}
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
}
class WorkPrinc extends BaseEntity {
    private $name;      
    public function __construct($params){
        $this->id = $params['id'];
        $this->name = $params['name'];
    }
    public function display(){
        echo $this->id.". ".$this->name."</br>";
    }
    public function update($params){
        $this->id = $params['id'];
        $this->name = $params['name'];
    }
    public function __destruct(){
        $this->id = null;
        $this->name = null;
    }
}
class SphereOfAppl extends BaseEntity{
    private $name;
    public function __construct($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
    }
    public function display(){
        echo $this->id.". ".$this->name."</br>";
    }
    public function update($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
    }
}
class Property extends BaseEntity{
    private $name;
    private $units;
    public function __construct($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
		$this->units=$params['units'];
    }
    public function display(){
        echo $this->id.". ".$this->name." <i>(".$this->units.")</i></br>";
    }
    public function update($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
		$this->units=$params['units'];
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
        $this->units=null;
    }
}
class InfraHeater extends BaseEntity{
    private $model;
    private $vendor;
    private $price;
	private $workPrinc;
	private $sphereOfAppl;
    private $properties;
    public function __construct($params){
        $this->id=$params['id'];
        $this->model=$params['model'];
		$this->vendor=$params['vendor'];
		$this->price=$params['price'];
		$this->workPrinc=$params['workPrinc'];
		$this->sphereOfAppl=$params['sphereOfAppl'];
		$this->properties=$params['properties'];
    }
    public function display(){
        echo $this->id.". ".$this->vendor." ".$this->model."</br>";
        echo "Принцип роботи: <i>".$this->workPrinc."</i></br>";
		echo "Сфера застосування: <i>".$this->sphereOfAppl."</i></br>";
        echo "Ціна: <b>".$this->price."</b> грн</br>";
        echo "<b>Характеристики:</b></br>";
        foreach (json_decode($this->properties) as $propertyName => $propertyValue) {
            echo $propertyName . ": " . $propertyValue . "</br>";
        }
    }
    public function update($params){
        $this->id=$params['id'];
        $this->model=$params['model'];
		$this->vendor=$params['vendor'];
		$this->price=$params['price'];
        $this->workPrinc=$params['workPrinc'];
		$this->sphereOfAppl=$params['sphereOfAppl'];
		$this->properties=$params['properties'];
    }
    public function __destruct(){
        $this->id=null;
        $this->model=null;
        $this->vendor=null;
        $this->price=null;
        $this->workPrinc=null;
		$this->sphereOfAppl=null;
        $this->properties=null;
    }
}
class WorkPrincList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new Category($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
}
class SphereOfApplList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new Category($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
}
class PropertyList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new Property($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
}
class InfraHeaterList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new InfraHeater($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
}

$c=new InfraHeaterList();
$c->add(
	[
		'model'=>'ECO Mini 1500',
		'vendor'=>'Ufo',
		'price'=>'1599',
		'workPrinc'=>'Електричний',
		'sphereOfAppl'=>'Побутовий',
		'properties'=>'{"Потужність": "1500 Вт", "Площа обігріву": "17 м<sup>2</sup>", "Спосіб монтажу": "підлоговий", "Тип обігрівального елемента": "кварцовий"}'
	]
);
$c->add(
	[
		'model'=>'WETAIR WQH-2020',
		'vendor'=>'WetAir',
		'price'=>'699',
		'workPrinc'=>'Електричний',
		'sphereOfAppl'=>'Побутовий',
		'properties'=>'{"Потужність": "1200 Вт", "Площа обігріву": "20 м<sup>2</sup>", "Спосіб монтажу": "підлоговий", "Тип обігрівального елемента": "кварцовий"}'
	]
);
$c->display();
$c->update(
	[
		'id'=>'2',
		'model'=>'WETAIR WQH-2020',
		'vendor'=>'WetAir',
		'price'=>'1000',
		'workPrinc'=>'Електричний',
		'sphereOfAppl'=>'Побутовий',
		'properties'=>'{"Потужність": "1200 Вт", "Площа обігріву": "20 м<sup>2</sup>", "Спосіб монтажу": "підлоговий", "Тип обігрівального елемента": "кварцовий"}'
	]
);
$c->display();
$c->delete(1);
$c->display();
?>