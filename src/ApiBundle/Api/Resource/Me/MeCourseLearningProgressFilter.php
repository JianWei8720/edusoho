<?php

namespace ApiBundle\Api\Resource\Me;

use ApiBundle\Api\Resource\Course\CourseMemberFilter;
use ApiBundle\Api\Resource\Course\CourseTaskFilter;
use ApiBundle\Api\Resource\Filter;
use ApiBundle\Api\Resource\User\UserFilter;

class MeCourseLearningProgressFilter extends Filter
{
    protected $publicFields = array(
        'taskCount', 'toLearnTasks', 'progress', 'taskResultCount', 'taskPerDay', 'planStudyTaskCount', 'planProgressProgress', 'member'
    );

    protected function publicFields(&$data)
    {
        if ($data['toLearnTasks']) {
            $data['nextTask'] = array_shift($data['toLearnTasks']);
            $courseTaskFilter = new CourseTaskFilter();
            $courseTaskFilter->setMode(Filter::SIMPLE_MODE);
            $courseTaskFilter->filter($data['nextTask']);
        } else {
            $data['nextTask'] = new \stdClass();
        }

        unset($data['toLearnTasks']);

        $courseMemberFilter = new CourseMemberFilter();
        $courseMemberFilter->setMode(Filter::SIMPLE_MODE);
        $courseMemberFilter->filter($data['member']);
    }
}