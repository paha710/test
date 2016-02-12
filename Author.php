<?php
class Author extends Model {

    protected static $structure =array(
        'name'=>array(
            'access'=>'public',
            'type'=>'string',
            'length'=>'256',
            'description'=>'Имя автора'
        )

    );


    //Получаем всех авторов из БД
    public static function Get_All()
    {
        $result = DB::Get()->Select('SELECT * FROM Author');
        if (!empty($result)) {
            $authors = [];
            foreach ($result as $key => $value) {
                $authors[] = Author::Create($value);
            }
            return $authors;
        }else{
            echo 'Не удалось получить авторов из БД';
        }
    }


    // Получаем автора по id
    public static function GetAuthor($key,$value)
    {
        $get_author = DB::Get()->Select('SELECT * FROM Author WHERE ' . $key . '=:value', array('value' => $value));
        // Создаем модель Автора
        if (!empty($get_author)) {
            $author = [];
            foreach ($get_author as $key => $value) {
                $author = Author::Create($value);
                $author->articles = Author::GetArticlesAuthor('author_id', $value['id']);
            }
            return $author;
        }
        else{
            echo 'Не удалось получить автора из БД';
        }
    }


    //Получаем статьи автора
    public static function GetArticlesAuthor($key,$value)
    {
        $result = DB::Get()->Select('SELECT * FROM Article WHERE ' . $key . '=:value', array('value' => $value));

        if (!empty($result)) {
            $articles_author = [];
            foreach ($result as $key => $value) {

                $articles_author[] = Article::Create($value);
            }

            return $articles_author;
        }else{
            echo 'Не удалось получить статьи автора  из БД';
        }
    }






}
?>