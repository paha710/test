<?php
class Comment extends Model{

    protected static $structure =array(
        'author_id'=>array(
            'access'=>'public',
            'type'=>'int',
            'length'=>'10',
            'description'=>'ID автора'
        ),
        'text'=>array(
            'access'=>'public',
            'type'=>'text',
            'description'=>'текст комментария'
        ),
        'views'=>array(
            'access'=>'public',
            'type'=>'int'

        )
    );

    public static function CreateComment($data){

        var_dump($_POST);
    }

}