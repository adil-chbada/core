<?php

namespace Apiato\Core\Loaders;


use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

trait ConfigsLoaderTrait
{
    public function loadConfigsFromShip(): void
    {
        $portConfigsDirectory = base_path('app/Ship/Configs');
        $this->loadConfigs($portConfigsDirectory);
    }

    private function loadConfigs($configFolder): void
    {
        if (File::isDirectory($configFolder)) {
            $files = File::files($configFolder);

            foreach ($files as $file) {
                try {
                    $config = File::getRequire($file);
                    $name = File::name($file);
                    $path = $configFolder . '/' . $name . '.php';

                    $this->mergeConfigFrom($path, $name);
                } catch (FileNotFoundException $e) {
                }
            }
        }
    }

    public function loadConfigsFromContainers($containerPath): void
    {
        $containerConfigsDirectory = $containerPath . '/Configs';
        $this->loadConfigs($containerConfigsDirectory);
    }
}
