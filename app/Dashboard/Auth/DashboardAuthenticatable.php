<?php


namespace App\Dashboard\Auth;


class DashboardAuthenticatable implements \Illuminate\Contracts\Auth\Authenticatable
{
    public $name;
    public $key;

    public function __construct($name, $key) {
        $this->name = $name;
        $this->key = $key;
    }
    /**
     * @inheritDoc
     */
    public function getAuthIdentifierName()
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getAuthIdentifier()
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function getAuthPassword()
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getRememberToken()
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function setRememberToken($value)
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getRememberTokenName()
    {
        return '';
    }
}
