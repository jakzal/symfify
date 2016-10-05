<?php

namespace Zalas\Symfify\Composer\SymfifyStep;

use Symfony\Component\Filesystem\Filesystem;

trait WorkDir
{
    /**
     * @var string
     */
    protected $workDir;

    /**
     * @before
     */
    protected function prepareWorkDir()
    {
        $this->workDir = realpath(sys_get_temp_dir()).'/symfify';
        $fs = new Filesystem();
        $fs->remove($this->workDir);
        $fs->mkdir($this->workDir);

        chdir($this->workDir);
    }

    /**
     * @after
     */
    protected function cleanupWorkDir()
    {
        (new Filesystem())->remove($this->workDir);
    }
}
