<?php

abstract class Pokemon {
    protected $name;  //public, private, protected
    protected $alived = true;
    protected $hp = 40;

    function __construct($name) {
        $this->name = $name;
    }
    
    function move($direction) {
        echo "<p>{$this->name} avanza hacia $direction </p>";
    }
    
    abstract public function attack($opponent);
    
    function getHP() {
        return $this->hp;
    }
    
    function setHP($points) {
       $this->hp = $points;
       echo "<p>Ahora {$this->name} tiene {$this->hp} puntos de vida</p>";
    }
    
    function die() {
        echo "<p>{$this->name} muere</p>";
        exit();
    }
    
    function  takeDamage($damage) {
        $this->setHP($this->hp - $damage);
        
        if ($this->hp <= 0) {
            $this->die();    
        }
    }
    
    
}

class Charmander extends Pokemon{
    protected $damage = 20;
    function attack($opponent) {
        echo "<p>{$this->name} ataca con llamarada a {$opponent->name} </p>";
        $opponent->takeDamage($this->damage);
                
    }
    
    function takeDamage($damage) {
        if (rand(0,1)){
            parent::takeDamage($damage);
        }
    }
    
}

class Evee extends Pokemon{
    protected $damage = 10;
    protected $stone;
    
    function __construct($name, Stone $stone = null) {
        $this->stone = $stone;
        parent::__construct($name);
    }
    
    function attack($opponent) {
        echo "<p>{$this->name} ataca con gruñido a {$opponent->name} </p>";
        $opponent->takeDamage($this->damage);
    }
    
    function takeDamage($damage) {
        
        if ($this->stone) {
           $damage = $this->stone->defend($damage);
        }
        
        parent::takeDamage($damage);
    }
}

interface Stone {
    function defend($damage); 
}

class WaterStone implements Stone{
    function defend($damage) {
        return $damage / 4;
    }
}

class ThunderStone implements Stone {
    function defend($damage) {
        return $damage / 3;
    }
}

$stone = new WaterStone;
$charmander = new Charmander("Charmander");
$evee = new Evee("Evee", $stone);
$charmander->attack($evee);
$charmander->attack($evee);
$evee->attack($charmander);
