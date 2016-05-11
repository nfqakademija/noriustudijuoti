<?php
/**
 * Created by PhpStorm.
 * User: gv
 * Date: 5/11/16
 * Time: 11:01 PM
 */
namespace AppBundle\Tests\Parser;

use AppBundle\Entity\Program;
use AppBundle\Parser\VUParser;
use GuzzleHttp\Client;

class VUParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $VUParser = new VUParser();
        $VUParser->setFunction(function (string $url) {
            $client = new Client();
            try {
                $response = $client->request('get', $url);
                if ($response->getStatusCode() !== '404') {
                    return $response->getBody()->getContents();
                } else {
                    return null;
                }
            } catch (\Exception $e) {
                return null;
            }
        });

        $program = $VUParser->getProgram(file_get_contents(__DIR__ . '/../Fixtures/VUProgram.html'));
        foreach ($program->getSubjects() as $subject) {
            $program->removeSubject($subject);
        }
        $expected = new Program();
        $expected->setName('Biochemija')
            ->setUniversity('Vilniaus Universitetas')
            ->setFaculty('Chemijos fakultetas')
            ->setField('Biomedicinos mokslai')
            ->setBranch('Molekulinė biologija, biofizika ir biochemija')
            ->setDegree('Biochemijos bakalauras')
            ->setLength('4')
            ->setForm('Nuolatinės dieninės studijos')
            ->setPrice('2248')
            ->setDescription('Biochemijos programą galima pavadinti gyvybės chemijos studijomis. '.
             'Biochemikai tiria gyvuosiuose organizmuose vykstančius cheminius procesus, ' .
              'nagrinėja fermentų veikimą, baltymų, angliavandenių, lipidų, nukleorūgščių vaidmenį.');

        $this->assertEquals($expected, $program);
    }
}