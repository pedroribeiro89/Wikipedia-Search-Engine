<?php
namespace App;

use Symfony\Component\HttpClient\HttpClient;

use App\Engine\Wikipedia\WikipediaEngine;
use App\Engine\Wikipedia\WikipediaParser;
use App\Result;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SearchCommand extends Command {
    protected function configure() {
        $this->setName('search')->addArgument('term');
    }

    private function showSearchResult(Result $result, InputInterface $input, OutputInterface $output) {
        $iterator = $result->getIterator();
        $header = ['Nome', 'Resumo'];
        $rows = [];

        foreach ($iterator as $item) {
            array_push($rows, [$item->getTitle(), $item->getPreview()]);
        }

        $io = new SymfonyStyle($input, $output);
        $io->table($header, $rows);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $term = $input->getArgument('term');
        $output->writeln(['<info>Termo pesquisado:</>', $term ]);
        $wikipediaEngine = new WikipediaEngine(new WikipediaParser(), HttpClient::create());
        $result = $wikipediaEngine->search($term);
        // $output->writeln(['<info>Resultado:</>', $result ]);
        // var_dump($result);

        $this->showSearchResult($result, $input, $output);
        return 0;
    }
}