<?php

namespace Lyre\Settings\Repositories;

use Lyre\Repository;
use Lyre\Settings\Models\Setting;
use Lyre\Settings\Contracts\SettingRepositoryInterface;

class SettingRepository extends Repository implements SettingRepositoryInterface
{
    protected $model;

    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }
}
