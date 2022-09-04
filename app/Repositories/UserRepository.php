<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserToken;
use App\Repositories\Abstracts\ModelRepository;
use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Str;

class UserRepository extends ModelRepository
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public static function create(array $data): Model
    {
        return User::create($data);
    }

    /**
     * @return Collection|User[]
     */
    public static function all(): Collection|array
    {
        return User::all();
    }

    public function get(): User
    {
        return $this->user;
    }

    public function update(array $data): User
    {
        $this->user->update($data);
        $this->save();
        return $this->get();
    }

    public function save(): bool
    {
        return $this->user->save();
    }

    public function delete(): bool
    {
        return $this->user->delete();
    }

    public function saved(): bool
    {
        return isset($this->user->id);
    }

    public function refresh(): UserRepository
    {
        $this->user->refresh();
        return $this;
    }

    public static function login(string $email, string $password): ?User
    {
        $user = User::where('email', '=', strtolower($email))->first();
        if (isset($user) && Hash::check($password, $user->password)) {
            return $user;
        }
        return null;
    }

    public static function getUserFromToken(?string $token): ?User
    {
        $userToken = UserToken::find($token);
        if (!isset($userToken) || $userToken->expired()) return null;
        return $userToken->user;
    }

    public function getToken(int $expires = 60*60): UserToken
    {
        $token = $this->user->tokens->first();
        if (!isset($token) || $token->expired()) {
            $token = $this->generateToken($expires);
        }
        return $token;
    }

    private function generateToken(int $expires): UserToken
    {
        do {
            $token = Str::random(64);
            $found = UserToken::find($token);
        } while (isset($found));
        $userToken = UserToken::make([
            'token' => $token,
            'expiry' => now()->addSeconds($expires)->unix(),
        ]);
        $this->user->tokens()->save($userToken);
        return $userToken;
    }
}
