<?php
class User extends Model
{

    protected static $structure = array(
        'email' => array(
            'access' => 'public',
            'type' => 'string',
            'length' => 256,
            'description' => 'Email пользователя',
        ),
        'password' => array(
            'access' => 'private',
            'type' => 'string',
            'length' => 256,
            'description' => 'Пароль',
            'is_null' => 'NOT NULL'
        ),
        'access' => array(
            'access' => 'public',
            'type' => 'int',
        ),
    );

    // Получаем модель текущег пользователя
    public static function CreateUser($user_id){
        $result = DB::Get()->Select('SELECT email,access FROM User WHERE id=:user_id',array('user_id'=>$user_id));
        $user =[];
        foreach($result as $key=>$value){
            $user[]=User::Create($value);
        }
        return $user;
    }

    public static function Login($username, $password) {
        $password = crypt($password,$username); //Хорошо бы на SHA-2 заменить

        $userData = DB::Get()->Select('SELECT * FROM User WHERE email=:email AND `password`=:password',array('email'=>$username,'password'=>$password));
        // echo $username.$password;
        if(isset($userData[0])) {
            Session::CreateSession($userData[0]['id']);
            return User::Create($userData[0]);
        }
        return false;
    }


    //Добавляем нового пользователя
    public static function AddUser($username, $password) {
        $password = crypt($password,$username); //Хорошо бы на SHA-2 заменить
        return DB::Get()->Query('INSERT INTO User (email,`password`) VALUES (:email,:pass)',array('email'=>$username,'pass'=>$password));
    }
}

