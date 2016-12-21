<?php

namespace app\models;
//\yii\base\Object
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use developeruz\db_rbac\interfaces\UserRbacInterface;

class User extends ActiveRecord implements IdentityInterface, UserRbacInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public $captcha;
    public $confirm_pass;
    public $old_pass;

    public $adres;
    public $number;
    public $name;
    public $email;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username','password','old_pass','adres','number','name'], 'string', 'max' => 100],
            [['confirm_pass',], 'required'],
            [['active',], 'integer'],
            ['confirm_pass','compare','compareAttribute'=>'password','message'=>'Поля "пароль" и "повтор пароля" не совпадают!'],
            ['username', 'unique'],
            array('old_pass', 'required', 'on'=>'test'),
            array(array('adres','number','name','email'), 'required', 'on'=>'test1')




        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['test'] = ['password', 'confirm_pass','old_pass'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Email',
            'password' => 'Пароль',
            'old_pass' => 'Старый пароль',
            'confirm_pass' => 'Повтор пароля (для проверки)',
            'name' => 'Имя',
            'adres' => 'Адрес',
            'number' => 'Номер телефона',
        ];
    }
    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    /* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /* removed
        public static function findIdentityByAccessToken($token)
        {
            throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        }
    */
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
    public function getUserName()
    {
        return $this->username;
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /** EXTENSION MOVIE **/
}
