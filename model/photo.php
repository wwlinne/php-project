<?php
	class Photo{		

		private $id;
		private $name;
		private $description;
		private $price;
		private $date;
		private $img;
				
		function __construct($id, $name, $description, $price, $date, $img){
			$this->setId($id);
			$this->setName($name);
			$this->setDescription($description);
			$this->setPrice($price);
			$this->setDate($date);
			$this->setDate($date);
			$this->setImg($img);


			}		
		
		public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}
		
		public function getDescription(){
			return $this->description;
		}
		
		public function setDescription($description){
			$this->description = $description;
		}

		public function getPrice(){
			return $this->price;
		}

		public function setPrice($price){
			$this->price = $price;
		}
		
		public function getDate(){
			return $this->date;
		}

		public function setDate($date){
			$this->date = $date;
		}

		public function getImg(){
			return $this->img;
		}
		public function setImg($img){
			$this->img = $img;
		}
	
		
		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

	}
?>
