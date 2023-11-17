<?php
class Advertisements
{
   protected $id;
   protected $creationDate;
   protected $title;
   protected $description;
   protected $priceInfo;

   function __construct($id, $creationDate, $title, $description, $priceInfo)
   {
      $this->id = $id;
      $this->creationDate = $creationDate;
      $this->title = $title;
      $this->description = $description;
      $this->priceInfo = $priceInfo;
   }


   // GET METHODS
   public function getId()
   {
      return $this->id;
   }
   public function getCreationDate()
   {
      return $this->creationDate;
   }
   public function getTitle()
   {
      return $this->title;
   }
   public function getDescription()
   {
      return $this->description;
   }
   public function getPriceInfo()
   {
      return $this->priceInfo;
   }
}
