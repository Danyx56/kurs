<?php
abstract class BaseEntity{
    protected $id;
    public abstract function display();
	public abstract function getAsJSON();
    public abstract function getAsXML();
	public function getId(){
		return $this->id;
	}
}
?>