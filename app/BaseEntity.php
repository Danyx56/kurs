<?php
abstract class BaseEntity{
    protected $id;
	public function getId(){
		return $this->id;
	}
}
?>