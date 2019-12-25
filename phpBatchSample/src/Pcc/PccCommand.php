<?php
declare(strict_types=1);

namespace Acme\Pcc;

require __DIR__ . '/../../vendor/autoload.php';

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * pear/console_commandline の例
 */
class PccCommand
{
    use PccCommandTrait;

    /** @var array */
    private $defaultConfig = [];

    /** @var LoggerInterface */
    private $logger;

    public function __construct()
    {
        $this->logger = new NullLogger();
        //$this->logger = (new \Monolog\Logger('app'))
        //    ->pushHandler(
        //        (new StreamHandler('php://stdout', Logger::DEBUG))
        //            ->setFormatter(new LineFormatter(null, 'Y-m-d H:i:s.u', true))
        //    );
    }

    public function execute()
    {
        $startedUsec = microtime(true);
        try {
            $config = $this->parseConfig($this->parseArgs());
            var_dump($config);
        } catch (\Throwable $e) {
            $this->logger->error(
                sprintf("%s(%s): %s\n%s", get_class($e), $e->getCode(), $e->getMessage(),
                    $e->getTraceAsString())
            );
            throw $e;
        } finally {
            $dtBatchEnd = \DateTimeImmutable::createFromFormat('U.u', (string)microtime(true),
                new \DateTimeZone(date_default_timezone_get()));
            echo sprintf(
                "finished. %s sec.\n",
                number_format($dtBatchEnd->format('U.u') - $startedUsec, 2)
            );
        }
    }

    /**
     * @param \Console_CommandLine_Result $cliResult
     * @return array config
     */
    private function parseConfig(\Console_CommandLine_Result $cliResult)
    {
        $config = $this->mergeConfig($cliResult);
        $this->validate($config);
        // ここで設定を構造化したり、型変換をしたりしようか
        return $config;
    }

    /**
     * @param array $config
     */
    private function validate($config)
    {
        // cli
        if (!is_dir($config['outDir'])) {
            throw new \InvalidArgumentException(sprintf('invalid outDir "%s".', $config['outDir']));
        }
        if (false === strtotime($config['baseDate'])) {
            throw new \InvalidArgumentException(sprintf('invalid baseDate "%s".', $config['baseDate']));
        }
        if (!in_array($config['keepFile'], ['0', '1'], true)) {
            throw new \InvalidArgumentException(sprintf('invalid keepFile "%s".', $config['keepFile']));
        }
    }

    /**
     * @return \Console_CommandLine
     */
    private function getCliParser()
    {
        $cli = new \Console_CommandLine();
        $cli->description = 'pear/console_commandline 利用例';
        $cli->version = '1.0.0';
        $cli->addArgument('outDir', [
            'help_name' => '<outDir>',
            'action' => 'StoreString',
            'description' => '出力先ディレクトリ',
        ]);
        $cli->addOption('baseDate', [
            'long_name' => '--baseDate',
            'help_name' => '[Y-m-d H:i:s]',
            'default' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            'action' => 'StoreString',
            'description' => '基準日時。デフォルトはシステム日時。',
        ]);
        $cli->addOption('keepFile', [
            'long_name' => '--keepFile',
            'help_name' => '[0|1]',
            'default' => '0',
            'action' => 'StoreString',
            'description' => '(開発用) 一時ファイルを残すか。デフォルト0。',
        ]);
        $cli->addOption('userId', [
            'long_name' => '--userId',
            'help_name' => '[userId]',
            'default' => null,
            'action' => 'StoreString',
            'description' => '(開発用) ユーザIDを指定する',
        ]);
        return $cli;
    }
}

$command = new PccCommand();
$command->execute();
