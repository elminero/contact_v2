<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $id;

    public function authenticate()
    {
        $record=User::model()->findByAttributes(array('username'=>$this->username));
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        elseif($record->password !== hash('ripemd160', $this->password) )
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->id=$record->id;
            $this->setState('userId', $record->id);
            $this->setState('roles', $record->roles);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->id;
    }
}






/**
 * Authenticates a user.
 * The example implementation makes sure if the username and password
 * are both 'demo'.
 * In practical applications, this should be changed to authenticate
 * against some persistent user identity storage (e.g. database).
 * @return boolean whether authentication succeeds.


$user = User::model()->findByAttributes(array('username'=>$this->username));
if ($user === null)
{
    // No user found!
    $this->errorCode=self::ERROR_USERNAME_INVALID;
}
elseif($user->pass !== hash('ripemd160', $this->password) )
{
    // Invalid password!
    $this->errorCode=self::ERROR_PASSWORD_INVALID;
}
else
{
    // Okay!
    $this->errorCode=self::ERROR_NONE;
    $this->id=$user->id;
    $this->setState('type', $user->type);
}

return !$this->errorCode;
}

public function getId()
{
    return $this->id;
}










//        $this->pass = new CDbExpression('SHA2(:pass, 512)', array(':pass' => $this->pass));


$users=array(
    // username => password
    'demo'=>'demo',
    'admin'=>'admin',
    'rob'=>'super8',
    'elminero@cox.net'=>'super9'
);

        // check to see if the username is a key in an associative array
        if(!isset($users[$this->username]))
        {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }

        // check to see if the key to the associative array equals the password
		elseif($users[$this->username]!==$this->password)
        {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        }

		else
        {
           // "self::ERROR_NONE" equals 0
            $this->errorCode=self::ERROR_NONE;
        }

		// If no error occurred the statement returns true
        return !$this->errorCode;


# protected/components/UserIdentity.php::authenticate()
// Understand that email === username
//    $user = User::model()->findByAttributes(array('username'=>$this->username), 'live=1');

*/