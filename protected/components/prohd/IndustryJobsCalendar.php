<?php
/*
 * Class file for IndustryJobsCalendar
 */

/**
 * Description of IndustryJobsCalendar
 *
 * @author MNischan
 */
class IndustryJobsCalendar extends CComponent
{
    static public function test()
    {
        return IndustryJobs::model()->findAll();
    }
}

?>
