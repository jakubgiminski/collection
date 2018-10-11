<?php declare(strict_types=1);

namespace Collection\Examples\Users;

use Collection\Collection;
use Collection\Type;
use Collection\UniqueIndex;

class UsersCollection extends Collection
{
    public function __construct(array $users = [])
    {
        parent::__construct(
            $users,
            Type::object(User::class),
            new UniqueIndex(function (User $user) {
                return $user->getId();
            })
        );
    }
}
