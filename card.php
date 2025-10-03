<?php
// Card.php
class Card {
    public $id;
    public $image;   // chemin vers l'image
    public $found;

    public function __construct($id, $image) {
        $this->id = $id;
        $this->image = $image;
        $this->found = false;
    }
}