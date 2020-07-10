<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\UserCollection;

use Comquer\Collection\Collection;
use Comquer\Collection\Type;
use Comquer\Collection\UniqueIndex;

class UserCollection extends Collection
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
