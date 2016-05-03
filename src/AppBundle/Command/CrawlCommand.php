<?php
/**
 * Created by PhpStorm.
 * User: gv
 * Date: 5/3/16
 * Time: 8:15 PM
 */
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('crawl')
            ->setDescription('Initiates the specified crawler service')
            ->addArgument(
                'crawlerName',
                InputArgument::REQUIRED,
                'The crawlers name'
            )
            ->addArgument(
                'url',
                InputArgument::REQUIRED,
                'Url for crawler to work with'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('crawlerName');
        $url = $input->getArgument('url');
        $container = $this->getContainer();
        if ($name && $url) {
            $crawler = $container->get('app.crawler.' . $name);
            $crawler->crawlPrograms($url);
        }
        $output->writeln('Starting crawler');
    }
}