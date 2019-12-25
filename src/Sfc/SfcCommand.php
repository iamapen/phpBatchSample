<?php
declare(strict_types=1);

namespace Acme\Sfc;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SfcCommand extends Command
{
    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('sfc:sample1')
            ->setDescription('symfony/console のサンプル')
            ->addOption('outDir', null, InputOption::VALUE_REQUIRED, '出力先ディレクトリ')
            ->addOption('baseDate', null, InputOption::VALUE_REQUIRED, '基準日。デフォルトはシステム日時。', date('Y-m-d H:i:s'))
            ->addOption('keepFile', null, InputOption::VALUE_REQUIRED, '(開発用) 一時ファイルを残すか。0=残さない 1=残す。', '0')
            ->addOption('userId', null, InputOption::VALUE_REQUIRED, '(開発用) ユーザIDを指定する');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startedUsec = microtime(true);

        $this->validate($input);
        var_dump($input->getOptions());

        // progress bar
        $rows = 10;
        $progressBar = new ProgressBar($output, $rows);
        for ($i = 0; $i < $rows; $i++) {
            usleep(300000);
            $progressBar->advance();
        }

        $progressBar->finish();
        $output->writeln('');
        $output->writeln($this->getName());

        $dtBatchEnd = \DateTimeImmutable::createFromFormat('U.u', (string)microtime(true),
            new \DateTimeZone(date_default_timezone_get()));
        $output->writeln(
            sprintf(
                "finished. %s sec.\n",
                number_format($dtBatchEnd->format('U.u') - $startedUsec, 2)
            )
        );

        return 0;
    }

    /**
     * @param InputInterface $input
     */
    private function validate(InputInterface $input)
    {
        // cli
        if (null === $input->getOption('outDir') || !is_dir($input->getOption('outDir'))) {
            throw new \InvalidArgumentException(sprintf('invalid outDir "%s".', $input->getOption('outDir')));
        }
        if (false === strtotime($input->getOption('baseDate'))) {
            throw new \InvalidArgumentException(sprintf('invalid baseDate "%s".', $input->getOption('baseDate')));
        }
        if (!in_array($input->getOption('keepFile'), ['0', '1'], true)) {
            throw new \InvalidArgumentException(sprintf('invalid keepFile "%s".', $input->getOption('keepFile')));
        }
    }
}
