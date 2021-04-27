<?php


namespace App\Dashboard\Auth;


use Illuminate\Contracts\Auth\Authenticatable;

class DashboardUserProvider implements \Illuminate\Contracts\Auth\UserProvider
{
    /**
     * @inheritDoc
     */
    public function retrieveById($identifier)
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function retrieveByCredentials(array $credentials)
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return false;
    }
}
