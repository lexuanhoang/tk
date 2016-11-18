<?php

//Trang chức năng gửi quà tặng

require_once(dirname(dirname(__FILE__)) . '/config.php');

global $PAGE, $USER, $DB, $SESSION;

$PAGE->set_context(context_system::instance());
$PAGE->set_title("Danh sach bai thi");
$PAGE->set_pagelayout('mainlayout');

$category = optional_param('category', 0, PARAM_INT);
$course   = optional_param('course', 0, PARAM_INT);


$PAGE->set_url($CFG->wwwroot . '/thi/index.php');

//Lấy dữ liệu chuyên đề
echo $OUTPUT->header();

$page = optional_param('page', 0, PARAM_INT);


$thistime = time();


$next_week = strtotime('next week');
$topquiz   =$DB->get_records('quiz',array('course'=>$course));
$cate = $DB->get_field('course', 'category', array('id' => $course ));
                
 $params   = array($cate,$course);
$other_id = $DB->get_field_sql('SELECT id FROM {course} WHERE category=? and id !=? ', $params);
                

?>

    <div class="container" >
    <?php
if (isset($topquiz) && $topquiz != false) {   

         ?>    <div class="row">   
<?php
foreach ($topquiz as $t) {

?>

    
                
                <div class="<?= ($t->timeopen !=0) ? 'col-sm-12' : 'col-sm-4'?> phan1  text-center " onclick="location.href='../thi/thithu_quiz.php?id=<?php  echo $t->id;?>'"">
                    
                    <h3><?php   echo ucfirst($t->name);?></h3>
                    <p>(<?= ($t->timeopen < time()) ? 'Đang diễn ra' : 'Sắp diễn ra' ?>)</p>
                    <p> Grade: <?php   echo round($t->grade);?></p>
                    <p> Số câu hỏi: <?php echo round($t->sumgrades);?></p>
                    <p><?php  echo substr($t->intro, 0, 50);?></p>
                    <p>Bắt đầu: <span><?= ($t->timeopen !=0) ? date('d/m/Y', $t->timeopen) :0 ?></span>
                    -- Kết thúc: <span><?= ($t->timeopen !=0) ?date('d/m/Y', $t->timeclose) :0?></span></p>
                           
                   
                </div>
    
    <?php
}} 
$allquiz = $DB->get_records('quiz', array('course' => $other_id));
if (isset($allquiz) && $allquiz != false) {
?>

    
   
        <h3 style="clear: both ;color:blue;padding-top: 30px">Đề khác :</h3>
        <br>
        <?php   foreach ($allquiz as $quiz) {   ?>

        <div class="phan2 col-sm-4  text-center" onclick="location.href='../thi/thithu_quiz.php?id=<?php  echo $quiz->id;?>'">
                <h3> <?php echo ucfirst($quiz->name);?></h3>
                <p> Grade: <?php echo round($quiz->grade);?></p>
                <p> Số câu hỏi: <?php      echo round($quiz->sumgrades);?></p>
                <p><?php  echo substr($quiz->intro, 0, 50);?></p>
        </div>
 

        <?php   }

?> </div> <?php
        }?>
    
    </div>
<?php

echo $OUTPUT->footer();
?>
