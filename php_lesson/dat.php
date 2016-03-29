<?php

include 'views/libs/db.php';
$db=DB::Get()->Connect('localhost','lesson4','root','');

$xml =new SimpleXMLElement('price.yml',false,true);
 DB::Get()->Query('TRUNCATE TABLE categories');

foreach($xml->shop->categories->category as $category){

    $data=[];
    $data['name']=(string)$category;
    $data['id']=(int)$category->Attributes()->id;
    $data['parent_id']=(int)$category->Attributes()->parentId;
    $db=DB::Get()->Query('INSERT INTO categories (id,name,parent_id) VALUE (:id,:name,:parent_id)',$data);

    echo "Категория \"".$data['name']."\" добавлена в БД\n";
}
DB::Get()->Query('truncate table goods');
foreach($xml->shop->offers->offer as $offer){
    $data=[];
    $data['name']=(string)$offer->name;
    $data['id']=(int)$offer->attributes()->id;
    $data['price']=(float)$offer->price;
    $data['category']=(int)$offer->categoryId;
    $db=DB::Get()->Query('INSERT INTO goods (id,price,name,category) VALUES (:id,:price,:name,:category)',$data);
    echo "Товары \"".$data['name']."\" добавлена в БД\n";

}

class Category{
     public $id,$name,$parent_id;
    public $good = array();
    public $category =array();

    public function __construct($category_id){
        $data = DB::Get()->Select('select * from categories where id=:id',array('id'=>$category_id));
        if(isset($data[0])){
            $this->$data[0]['id'];
            $this->$data[0]['name'];
            $children = DB::Get()->Select('select * from categories where parent_id=:id',array('id'=>$this->id));
            foreach($children as $cat){
                $this->category[]=new Category($cat['id']);
            }
        }



    }

}

class Good{

}


$top_categories = DB::Get()->Select('select * from categories where parent_id=0');
foreach($top_categories as $cat){
    $tree = [];
    $category=new Category($cat['id']);
}