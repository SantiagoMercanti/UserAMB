<?php

namespace App\Command;

use App\Service\DniValidator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'test:dni',
    description: 'Probar el servicio DniValidator'
)]
class TestDniCommand extends Command
{
    public function __construct(
        private DniValidator $dniValidator
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tests = ['1234567', 'abc123', '123456789', '12'];
        foreach ($tests as $dni) {
            $valid = $this->dniValidator->isValid($dni) ? 'válido' : 'inválido';
            $output->writeln("$dni => $valid");
        }

        return Command::SUCCESS;
    }
}
