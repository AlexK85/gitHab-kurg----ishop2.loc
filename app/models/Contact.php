<?php

// namespace app\Models;

// class Contact
// {

//     public $id;
//     public $name;
//     public $phone;

//     protected $table = 'contacts';
//     protected $dbConcection;

//     public function __construct($name, $phone)
//     {
//         $this->name = $name;
//         $this->phone = $phone;
//     }

//     public function save()
//     {
//         $this->dbConcection->query("INSERT INTO $this->table (name, phone) VALUES ($this->name, $this->phone)");
//     }

//     public function delete()
//     {
//         $this->dbConcection->query("DELETE FROM $this->table WHERE id = $this->id");
//     }

//     public static function find($id)
//     {
//         $data = $this->dbConcection->query("SELECT name, phone WHERE id = $id");
//         return new self($data['name'], $data['phone']);
//     }

//     public static function all()
//     {
//         $result = $this->dbConcection->query("SELECT name, phone WHERE id = $id");

//         $contacts = [];
//         foreach ($result as $item) {
//             $contacts[] = new self($item['name'], $item['phone']);
//         }
//         return $contacts;
//     }
// }
