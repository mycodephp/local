<?php


	function local_user_extend_navigation(navigation_node $nav) {
   $report=$nav->add('Custom Reports');

    global $CFG, $PAGE;
  
       if ($PAGE->theme->resolve_image_location('icon', 'local_customreport', null)) {
        $icon = new pix_icon('online-course', '', 'local_customreport', array('class' => 'icon pluginicon'));
        $icon1 = new pix_icon('online-course1', '', 'local_customreport', array('class' => 'icon pluginicon'));
        $icon2 = new pix_icon('online-course2', '', 'local_customreport', array('class' => 'icon pluginicon'));
    } 
    else {
        $icon = new pix_icon('online-course', '', 'moodle', array(
            'class' => 'online',
            'width' => 5,
            'height' => 5
        ));
    }
   


     $nav->add(
        'Courses',
        new moodle_url($CFG->wwwroot . '/local/admincourse/index.php'),
        navigation_node::NODETYPE_BRANCH,
        null,
        'local_report-list',
        $icon
    )->showinflatnavigation = true;



  	 $nav->add(
        'Report',
        new moodle_url($CFG->wwwroot . '/local/userreports/index.php'),
        navigation_node::NODETYPE_BRANCH,
        null,
        'local_report-list',
        $icon1
    )->showinflatnavigation = true;
     

     $nav->add(
        'Users',
        new moodle_url($CFG->wwwroot . '/admin/user.php'),
        navigation_node::NODETYPE_BRANCH,
        null,
        'local_report-list',
        $icon2
    )->showinflatnavigation = true;








	
	}
	
?>
