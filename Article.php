<?php

//Модель данных "Статья"

class Article extends Model {

    protected static $structure =array(
        'title'=>array(
            'access'=>'public',
            'type'=>'string',
            'length'=>'256',
            'description'=>'Заголовок статьи'
        ),
        'author_id'=>array(
            'access'=>'public',
            'type'=>'int',
            'length'=>'10',
            'description'=>'ID автора'
        ),
        'text'=>array(
            'access'=>'public',
            'type'=>'text',
            'description'=>'текст статьи'
        ),
        'views'=>array(
            'access'=>'public',
            'type'=>'int'

        )

    );


    // Получаем все статьи из БД

    public static function Get_All()
    {
        $result = DB::Get()->Select('SELECT * FROM Article');
        if (!empty($result)) {
            $return = [];
            foreach ($result as $index => $value) {
                $return[] = Article::Create($value);
            }
            return $return;
        }else{
            echo 'Не удалось получить статьи из БД';
        }
    }


    // Получаем статьи по id
    public static function GetArticle($key,$value)
    {
        $result = DB::Get()->Select('SELECT * FROM Article WHERE ' . $key . '=:value', array('value' => $value));
        if (!empty($result)) {
            // Создаем модель статей
            $article = [];
            foreach ($result as $index => $value) {
                $article = Article::Create($value);

                //Создаем свойство Автор с объектом автора
                $article->author = Author::GetAuthor('id', $value['author_id']);
            }

            //добавляем просмотры
            DB::Get()->Query('update Article set views = views+1 where id=:id' ,array('id' =>$value['id']));

            return $article;
        }
        else{
            echo 'Не удалось получить статью из БД';
        }
    }

}
?>