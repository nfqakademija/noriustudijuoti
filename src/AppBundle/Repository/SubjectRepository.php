<?php
/**
 * Created by PhpStorm.
 * User: gv
 * Date: 5/11/16
 * Time: 6:59 PM
 */
namespace AppBundle\Repository;

class SubjectRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSubjectsBySemester($id)
    {
        $qb = $this->getEntityManager();
        $querySemester = $qb->createQuery(
            'SELECT DISTINCT s.semester
            FROM AppBundle:Subject s
            WHERE s.program = :id
            ORDER by s.semester ASC'
        )->setParameter('id', $id);
        $semesters = $querySemester->getArrayResult();
        $subjectArray = [];
        foreach ($semesters as $semester) {
            $querySubjects = $qb->createQuery(
                'SELECT s
            FROM AppBundle:Subject s
            WHERE s.program = :id
            AND s.semester = :semester'
            )->setParameter('id', $id)
             ->setParameter('semester', $semester);
            $subjectArray[] = $querySubjects->getArrayResult();
        }
        return $subjectArray;
    }
}