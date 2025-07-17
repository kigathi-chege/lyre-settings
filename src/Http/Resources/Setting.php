<?php

namespace Lyre\Settings\Http\Resources;

use Lyre\Settings\Models\Setting as SettingModel;
use Lyre\Resource;

class Setting extends Resource
{
    public function __construct(SettingModel $model)
    {
        parent::__construct($model);
    }
}
