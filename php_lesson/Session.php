<?php
class Session extends Model
{
    protected static $structure = array(
        'session_id' => array(
            'access' => 'public',
            'type' => 'string',
            'length' => 256,
            'description' => 'ID сессии',
        ),
        'last_active' => array(
            'access' => 'public',
            'type' => 'int',
            'length' => 11,
            'description' => 'Timestamp',
            'is_null' => 'NOT NULL'
        ),
        'user_id' => array(
            'access' => 'public',
            'type' => 'int',
            'description' => 'Идентификатор пользователя'
        ),
    );

    public static function GetSession($user_id,$user_session){

        $timeout = time() - 86400 * 7 ;
        $result = DB::Get()->Select('SELECT * FROM Session WHERE user_id=:user_id AND session_id=:user_session AND last_active>:last_active',array('user_id'=>$user_id,'user_session'=>$user_session,'last_active'=>$timeout));
        if(isset($result[0])){
            $expire= time() + 7 * 86400;
            setcookie('user_id',$user_id,$expire);
            setcookie('user_session',$user_session,$expire);
            DB::Get()->Query('UPDATE Session SET last_active=:last_active WHERE session_id=:user_session',
                array('user_session'=>$user_session,'last_active'=>time()));
            return true;
        }else {
            setcookie('user_id', NULL, -1);
            setcookie('user_session', NULL, -1);
        }
        return false;
    }


    public static function CreateSession($user_id){
        $session_id= md5(rand(0,999)*rand(0,999999)+time());
        DB::Get()->Query('INSERT INTO Session(session_id,last_active,user_id) VALUE (:session_id,:last_active,:user_id)',array(
            'session_id'=>$session_id,
            'last_active'=>time(),
            'user_id'=>$user_id));
        $expire= time() + 7 * 86400;
        setcookie('user_id',$user_id,$expire);
        setcookie('user_session',$session_id,$expire);

        return true;
    }


    // Метод удаления данных сессии
    public static function EndSession($user_id){
            DB::Get()->Query('DELETE FROM Session WHERE user_id=:id',array('id'=>$user_id));

            return true;
        }
}




