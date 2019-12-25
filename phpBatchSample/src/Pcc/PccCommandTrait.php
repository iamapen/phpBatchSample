<?php
declare(strict_types=1);

namespace Acme\Pcc;

trait PccCommandTrait
{

    /**
     * cliArgs > cliOpts > (configFile) > defaultConfig(instance field)
     * @param \Console_CommandLine_Result $cliResult
     * @return array config
     */
    protected function mergeConfig(\Console_CommandLine_Result $cliResult)
    {
        $options = $cliResult->options;
        unset($options['help'], $options['version']);
        $config = array_merge($this->defaultConfig, $options, $cliResult->args);
        return $config;
    }

    /**
     * @return \Console_CommandLine_Result
     */
    private function parseArgs()
    {
        $argv = $_SERVER['argv'] ?? [];
        $cliParser = $this->getCliParser();
        try {
            return $cliResult = $cliParser->parse(count($argv), $argv);
        } catch (\Console_CommandLine_Exception $e) {
            $cliParser->displayUsage(1);
        }
    }
}
