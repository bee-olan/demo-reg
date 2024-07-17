<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\Kategoria\Edit;

use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Permission;
use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Kategoria;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var string[]
     */
    public $permissions;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromKategoria(Kategoria $kategoria): self
    {
        $command = new self($kategoria->getId()->getValue());
        $command->name = $kategoria->getName();
        $command->permissions = array_map(static function (Permission $permission): string {
            return $permission->getName();
        }, $kategoria->getPermissions());
        return $command;
    }
}
