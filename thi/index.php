<?php

//Trang chức năng gửi quà tặng

require_once(dirname(dirname(__FILE__)).'/config.php');

global $PAGE,$USER,$DB,$SESSION;

$PAGE->set_context(context_system::instance());
$PAGE->set_title("Danh sach bai thi");

$category           = optional_param('category', 0, PARAM_INT);
$course             = optional_param('course', 0, PARAM_INT);
$PAGE->set_pagelayout('mainlayout');

$PAGE->set_url($CFG->wwwroot.'/thi/index.php');

//Lấy dữ liệu chuyên đề
echo $OUTPUT->header();


$allcourses = $DB->get_records('course', array('category'=>$category));

if(isset($allcourses)) {

?>
    <table width="100%">
        <?php foreach ($allcourses as $course) { ?>
            <tr>
                <td><?php echo $course->id ?></td>
                <td><?php echo $course->fullname ?></td>
                <td><?php echo $course->shortname ?></td>
                <td><?php echo $course->startdate ?></td>
            </tr>
        <?php }  ?>
    </table>
<?php } ?>
<?php
echo $OUTPUT->footer();
?>
