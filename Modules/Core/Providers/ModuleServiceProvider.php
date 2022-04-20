<?php

namespace Modules\Core\Providers;

use Nwidart\Modules\Module;
use Illuminate\Support\ServiceProvider;


class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->app['modules']->allEnabled() as $module) {
            $this->loadConfigs($module);
            $this->loadMigrations($module);
            $this->registerHelpers($module);
        }
    }

    /**
     * Load migrations for the given module.
     *
     * @param \Nwidart\Modules\Module $module
     * @return void
     */
    private function loadConfigs(Module $module)
    {
        collect([
            'config' => "{$module->getPath()}/Config/config.php",
        ])->filter(function ($path) {
            return file_exists($path);
        })->each(function ($path, $filename) use ($module) {
            $this->mergeConfigFrom($path, "app.modules.{$module->getAlias()}.{$filename}");
        });
    }

    /**
     * Load migrations for the given module.
     *
     * @param \Nwidart\Modules\Module $module
     * @return void
     */
    private function loadMigrations(Module $module)
    {
        $this->loadMigrationsFrom("{$module->getPath()}/Database/Migrations");
    }


    /**
     * register all php files in Support folder in all module
     * @param $module
     * @return void
     */
    public function registerHelpers($module)
    {
        foreach (glob("{$module->getPath()}/Support/*.php") as $filename) {
            require_once($filename);
        }
    }
}
