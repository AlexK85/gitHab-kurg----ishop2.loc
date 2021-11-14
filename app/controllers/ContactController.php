<?php

// namespace app\Cotrollers;

// use \app\Models\Contact;

// class ContactController {

//     public function __construct()
//     {
        
//     }

//     public function create()
//     {
//         $name = $_POST['name'];
//         $phone = $_POST['phone'];

//         $contact = new Contact($name, $phone);
//         $contact->save();
//     }

//     public function delete($id)
//     {
//         $contact = Contact::find($id);
//         $contact->delete();
//     }

//     public function update()
//     {
//         $id = $_POST['id'];
//         $newName = $_POST['name'];
//         $newPhone = $_POST['phone'];
        
//         $contact = Contact::find($id);
//         $contact->name = $newName;
//         $contact->phone = $newPhone;
//         $contact->save();
//     }

//     public function show($type)
//     {
//         $contacts = Contact::all();

//         switch ($type) {
//             case 'html':
//                 $view = new HtmlTable();
//             case 'file':
//                 $view = new File();
//             default:
//                 echo '123'; die;
//         }
        
//         $html = $view->render($contacts);

//         echo $html;
//     }
// }