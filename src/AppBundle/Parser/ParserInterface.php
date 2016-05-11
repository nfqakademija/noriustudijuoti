<?php
/**
 * Created by PhpStorm.
 * User: gv
 * Date: 4/25/16
 * Time: 4:20 PM
 */
namespace AppBundle\Parser;

use AppBundle\Entity\Program;

interface ParserInterface
{
    /**
     * @param string $htmlBody
     * @return array
     */
    public function getProgramUrls(string $htmlBody) : array;

    /**
     * @param string $htmlBody
     * @return array
     */
    public function getSubjects(string $htmlBody) : array;

    /**
     * @param string $htmlBody
     * @return Program
     */
    public function getProgram(string $htmlBody) : Program;
}