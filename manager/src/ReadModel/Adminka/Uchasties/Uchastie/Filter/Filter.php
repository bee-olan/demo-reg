<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Uchasties\Uchastie\Filter;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Status;

class Filter
{
//    public $name;
    public $nike;
    public $email;
    public $group;
    public $status = Status::ACTIVE;

}
