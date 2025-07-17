<?php

namespace Lyre\Settings\Http\Controllers;

use Lyre\Settings\Models\Setting;
use Lyre\Settings\Contracts\SettingRepositoryInterface;
use Lyre\Controller;

class SettingController extends Controller
{
    public function __construct(
        SettingRepositoryInterface $modelRepository
    ) {
        $model = new Setting();
        $modelConfig = $model->generateConfig();
        parent::__construct($modelConfig, $modelRepository);
    }
}
