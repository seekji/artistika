<?php

namespace App\Service;

use Symfony\Component\Yaml\Yaml;

class SettingsService
{
    /**
     * Path to settings file
     */
    const SETTINGS_YAML_PATH = '/../config/settings.yaml';

    /**
     * @var string $rootDir
     */
    private $rootDir;

    /**
     * @var array $values
     */
    private $values = [];

    /**
     * SettingsService constructor.
     * @param string $rootDir
     */
    public function __construct(string $rootDir)
    {
        $this->setRootDir($rootDir);
        $this->values = Yaml::parseFile($this->getRootDir() . self::SETTINGS_YAML_PATH);
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function saveValues(array $data): self
    {
        file_put_contents($this->getRootDir() . self::SETTINGS_YAML_PATH, Yaml::dump(array_merge($this->getValues(), $data)));

        return $this;
    }

    /**
     * @param string $roodDir
     * @return $this
     */
    public function setRootDir(string $roodDir): self
    {
        $this->rootDir = $roodDir;

        return $this;
    }

    /**
     * @return string
     */
    public function getRootDir(): string
    {
        return $this->rootDir;
    }
}