<?php

namespace InetStudio\MenusPackage\Console\Commands;

use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

/**
 * Class SetupCommand.
 */
class SetupCommand extends BaseSetupCommand
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:menus-package:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup links package';

    /**
     * Инициализация команд.
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Menus setup',
                'command' => 'inetstudio:menus-package:menus:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Items setup',
                'command' => 'inetstudio:menus-package:items:setup',
            ],
        ];
    }
}
