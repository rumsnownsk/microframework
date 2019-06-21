<?php

namespace App\System\Config;

use Symfony\Component\Config\FileLocator;

class Config implements IConfig
{
    private $config = [];
    private $loader;
    private $locator;

    public function __construct($dir)
    {
        $directories = [
            BASEPATH.'/'.$dir          # полный путь где храниться конфигурационный файл
        ];

        $this->setLocator($directories);
        $this->setLoader();
    }

    public function addConfig($file)
    {
        $configValues = $this->loader->load($this->locator->locate($file));
        if ($configValues){
            foreach ($configValues as $key => $arr) {
                $this->config[$key] = $arr;
            }
        }
    }

    public function get($keyValue)
    {
        list($key, $value) = explode('.', $keyValue);
        if ($key && isset($this->config[$key])){
            if ($value && $this->config[$key][$value]){
                return $this->config[$key][$value];
            }
            else {
                return $this->config[$key];
            }
        }
        return null;
    }

    public function getConfig(){
        return $this->config;
    }

    public function setLoader(){
        $this->loader = new YamlConfigLoader($this->locator);
    }

    public function setLocator($dir){
        $this->locator = new FileLocator($dir);
    }
}