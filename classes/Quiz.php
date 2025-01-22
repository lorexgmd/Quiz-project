<?php
    class Quiz{
        private $name;
        private $creator;
        private $questions;
        private $description;
        

        public function __construct($name, $creator, $questions, $description){
            $this->name = $name;
            $this->creator = $creator;
            $this->questions = $questions;
            $this->description = $description;
        }

        public function getName(){
            return $this->name;
        }

        public function getCreator(){
            return $this->creator;
        }

        public function getQuestions(){
            return $this->questions;
        }
         
        public function getDescription(){
            return $this->description;
        }
    }
?>