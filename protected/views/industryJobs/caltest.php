<?php
/* @var $this IndustryJobsController */
$this->breadcrumbs=array(
	'Industry Jobs',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);

$capJobs = $this->getCapitalJobs()->read();
$totalTime = strtotime($capJobs['endProductionTime']) - time();
$day = 60 * 60 * 24;
$numDays = floor($totalTime / $day) + 1;
$width = 906;
$interval = $width / $totalTime;

?>

<script type="text/javascript">
$(function(){
    
    /*
    var width = $('#industry-job-calendar-table').width();
    var height = $('#industry-job-calendar-table').height();
    var offset = 20;
    
    var paper = Raphael("industry-job-calendar-canvas", width, height + offset);
    var days = <? echo $numDays; ?>;
    
    var interval = width / days;
    var cursor = interval;
    var i = 0;
    while (cursor < width )
    {
        i++;
        rounded = Math.round(cursor);
        var l = paper.path("M"+cursor+" "+offset+"L"+cursor+" "+(height + offset));
        l.attr({
           stroke: '#DDD',
           'stroke-width': '1'
        });
        
        paper.text((cursor - (interval /2)),10,i);
        
        cursor += interval;
    }
    i++;
    paper.text((cursor - (interval /2)),10,i);
    
    $.ajax({
        url: "<? echo $this->createUrl('/industryJobs/getCalendar'); ?>",
        dataType: 'json',
        success: function(data){
            alert(data[0].installerID);
            return true;
        }
    });
    
    */
    
    $('#industry-job-calendar').phdIndustryCalendar({url: '<? echo $this->createUrl('/industryJobs/getCalendar'); ?>'});
}); 
</script>


<h1>Industry Jobs - <?php echo $group->name; ?></h1>
<hr>

<div id="industry-job-calendar"><div>