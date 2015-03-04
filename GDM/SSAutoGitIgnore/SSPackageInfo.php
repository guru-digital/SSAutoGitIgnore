<?php

namespace GDM\SSAutoGitIgnore;

class SSPackageInfo {

    /**
     * Path to current projects root directory
     * @var string
     */
    protected $baseDir = "";

    /**
     *
     * @var \Composer\Composer
     */
    protected $composer = "";

    /**
     *
     * @var Composer\Repository\RepositoryManager
     */
    protected $repoManager = "";

    /**
     *
     * @var Composer\Installer\InstallationManager
     */
    protected $installManager = "";

    /**
     * A package must be one of these types to be included
     *
     * @var array
     */
    protected $requiredTpes = array("silverstripe-theme", "silverstripe-module");

    public function __construct(\Composer\Composer $composer) {
        $this->composer       = $composer;
        $this->repoManager    = $this->composer->getRepositoryManager();
        $this->installManager = $composer->getInstallationManager();
        $this->baseDir        = $this->NormalizePath(getcwd());
    }

    public function GetSSModules() {
        $packages = array();

        foreach ($this->repoManager->getLocalRepository()->getPackages() as $package) {
            /* @var $package \Composer\Package\Package */
            if (!isset($packages[$package->getName()]) || !is_object($packages[$package->getName()]) || version_compare($packages[$package->getName()]->getVersion(), $package->getVersion(), '<')
            ) {
                if (in_array($package->getType(), $this->requiredTpes)) {
                    $packgePath                            = $this->NormalizePath($this->installManager->getInstallPath($package));
                    $packages[$package->getName()]["info"] = $package;
                    $packages[$package->getName()]["path"] = $packgePath;
                }
            }
        }
        return $packages;
    }

    protected function NormalizePath($path) {
        $search  = array('\\', '\\\\', '//', $this->baseDir);
        $replace = array('/', '/', '/', '');
        return trim(str_replace($search, $replace, $path), '/');
    }
}
