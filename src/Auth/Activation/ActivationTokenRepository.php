<?php

namespace Tecactus\Skeleton\Auth\Activation;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\ConnectionInterface;
use Tecactus\Skeleton\Contracts\CanActivateAccount as CanActivateAccountContract;

class ActivationTokenRepository
{
    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $connection;

    /**
     * The token database table.
     *
     * @var string
     */
    protected $table;

    /**
     * The hashing key.
     *
     * @var string
     */
    protected $hashKey;

    /**
     * The number of seconds a token should last.
     *
     * @var int
     */
    protected $expires;

    /**
     * Create a new token repository instance.
     *
     * @param  \Illuminate\Database\ConnectionInterface  $connection
     * @param  string  $table
     * @param  string  $hashKey
     * @param  int  $expires
     * @return void
     */
    public function __construct(ConnectionInterface $connection, $table, $hashKey, $expires = 7)
    {
        $this->table = $table;
        $this->hashKey = $hashKey;
        $this->expires = $expires;
        $this->connection = $connection;
    }

    /**
     * Create a new token record.
     *
     * @param  \Tecactus\Skeleton\Contracts\CanActivateAccount  $user
     * @return string
     */
    public function create(CanActivateAccountContract $user)
    {
        $email = $user->getEmailForAccountActivation();

        $this->deleteExisting($user);

        // We will create a new, random token for the user so that we can e-mail them
        // a safe link to the account activation method. Then we will insert a record in
        // the database so that we can verify the token within the actual activation.
        $token = $this->createNewToken();

        $this->getTable()->insert($this->getPayload($email, $token));

        return $token;
    }

    /**
     * Delete all existing activation tokens from the database.
     *
     * @param  \Tecactus\Skeleton\Contracts\CanActivateAccount  $user
     * @return int
     */
    protected function deleteExisting(CanActivateAccountContract $user)
    {
        $email = $user->getEmailForAccountActivation();
        
        return $this->getTable()->where('email', $email)->delete();
    }

    /**
     * Build the record payload for the table.
     *
     * @param  string  $email
     * @param  string  $token
     * @return array
     */
    protected function getPayload($email, $token)
    {
        return ['email' => $email, 'token' => $token, 'created_at' => new Carbon];
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  \Tecactus\Skeleton\Contracts\CanActivateAccount  $user
     * @param  string  $token
     * @return bool
     */
    public function exists($token, $email)
    {
        $token = (array) $this->getTable()->where('email', $email)->where('token', $token)->first();

        return $token && ! $this->tokenExpired($token);
    }

    /**
     * Determine if the token has expired.
     *
     * @param  array  $token
     * @return bool
     */
    protected function tokenExpired($token)
    {
        $expiresAt = Carbon::parse($token['created_at'])->addDays($this->expires);

        return $expiresAt->isPast();
    }

    /**
     * Delete a token record by token.
     *
     * @param  string  $token
     * @return void
     */
    public function delete($token)
    {
        $this->getTable()->where('token', $token)->delete();
    }

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired()
    {
        $expiredAt = Carbon::now()->subDays($this->expires);

        $this->getTable()->where('created_at', '<', $expiredAt)->delete();
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken()
    {
        return hash_hmac('sha256', Str::random(40), $this->hashKey);
    }

    /**
     * Begin a new database query against the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getTable()
    {
        return $this->connection->table($this->table);
    }

    /**
     * Get the database connection instance.
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
