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
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('crawlerName');
        $container = $this->getContainer();
        $output->writeln('Starting crawler');
        if ($name) {
            $crawler = $container->get('app.crawler.' . $name);
            $crawler->crawlPrograms($this->getContainer()->getParameter($name . '_url'));
        }
        $output->writeln('Crawler done');

    }
}