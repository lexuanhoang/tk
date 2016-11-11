<?php

//Trang chức năng gửi quà tặng

require_once(dirname(dirname(__FILE__)).'/config.php');

global $PAGE,$USER,$DB,$SESSION;

$PAGE->set_context(context_system::instance());
$PAGE->set_title("Danh sach bai thi");
$PAGE->set_pagelayout('mainlayout');

$category           = optional_param('category', 0, PARAM_INT);
$course             = optional_param('course', 0, PARAM_INT);


$PAGE->set_url($CFG->wwwroot.'/thi/index.php');

//Lấy dữ liệu chuyên đề
echo $OUTPUT->header();


$allquiz = $DB->get_records('quiz', array('course'=>$course));

 $thiscourse = $DB->get_record('course',  array('id'=>$course) ); 
 

if(isset($allquiz)) {

    ?>
    <div width="100%" >
        <?php foreach ($allquiz as $quiz) { ?>


            <a href="../thi/thithu_quiz.php?id=<?php echo $quiz->id ?>">            
            <div class="quiz_item">
                <h4><a href="../thi/thithu_quiz.php?id=<?php echo $quiz->id ?>"><?php echo ucfirst($quiz->name) ?></a></h4>
                
                              <p> Grade: <?php echo round($quiz->grade) ?></p>
                <p> Số câu hỏi: <?php echo round($quiz->sumgrades) ?></p>
                <p><?php echo substr($quiz->intro,0, 50).'...' ?></p>
            </div>
              
            </a>

        <?php }  ?>
    </div>
<?php } ?>
<?php
echo $OUTPUT->footer();
?>
