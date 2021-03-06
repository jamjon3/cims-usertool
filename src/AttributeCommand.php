<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace USF\Idm\usertool;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

/**
 * Description of AttributeCommand
 *
 * @author jam
 */
class AttributeCommand extends Command {

    protected function configure() {
        $this
                // the name of the command (the part after "bin/console")
                ->setName('ad:setattribute')

                // the short description shown while running "php bin/console list"
                ->setDescription('Posts an attribute change to AD')

                // the full command description shown when running the command with
                // the "--help" option
                ->setHelp("This command allows you to post attribute changes to the AD change queue")
                // configure an argument
                ->addArgument('username', InputArgument::REQUIRED, 'The username for modification')
                ->addOption(
                        'key', null, InputOption::VALUE_REQUIRED, 'The Attribute Key', 1
                )
                ->addOption(
                        'value', null, InputOption::VALUE_REQUIRED, 'value', 1
                )->setGuzzle(new \GuzzleHttp\Client());


        try {
            $value = Yaml::parse(file_get_contents('/usr/local/etc/cimsusertool/settings.yml'));
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
    }

    private function setGuzzle($guzzleclient) {
        $this->guzzleclient = $guzzleclient;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {



        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        // outputs a message followed by a "\n"
        $output->writeln('Whoa!');

        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a user.');

        $output->writeln('Key: ' . $input->getArgument('key'));
    }

    public function addAttribute() {
        $headers = ['X-Foo' => 'Bar'];
        $body = 'hello!';
        $request = $this->guzzleclient->post('http://httpbin.org/get', $headers, $body);
    }

}
