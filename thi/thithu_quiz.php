<?php

//Trang chức năng gửi quà tặng

require_once(dirname(dirname(__FILE__)).'/config.php');
require_once($CFG->dirroot.'/mod/quiz/lib.php');
require_once($CFG->dirroot.'/lib/customlib.php');	

global $PAGE,$USER,$DB,$SESSION;

$PAGE->set_context(context_system::instance());
$PAGE->set_title("Danh sach bai thi");
$PAGE->set_pagelayout('mainlayout');

$id           = optional_param('id', 0, PARAM_INT);

$PAGE->set_url($CFG->wwwroot.'/thi/index.php');

//Lấy dữ liệu chuyên đề
echo $OUTPUT->header();

$quiz = $DB->get_record('quiz', array('id'=>$id));
$quizc = $DB->get_record_sql("SELECT count(id) as c from mdl_quiz_attempts WHERE quiz = " . $id);
$cm = get_cm($id, 'quiz');


//Tìm tên môn học tương ứng:
$cou= $DB->get_field('quiz','course',array('id'=>$id));
$cou2= $DB->get_field('course','category',array('id'=>$cou));
$cou3= $DB->get_field('course_categories','name',array('id'=>$cou2));

$thoigian=$quiz->timelimit;
$gio=floor($thoigian/3600);
$phut=floor(($thoigian%3600)/60);
$giay=($thoigian%3600)%60;


if(isset($quiz)) {
?>

    <div width="100%">
            <div style="width: 800px; height: 100%; border:1px solid #ccc; margin: 10px auto; padding 10px; text-align: center;" class="panel panel-primary panel-quiz-info">
                <h4 class="panel-heading text-center"><span style="color:#ffffff; font-weight:bold;" ><?php echo $quiz->name ?></span></h4>
                <h3 style="color:#337ab7; font-size:17px; text-align:center">Môn: <?php echo $cou3."<br>"?> </h3>
                <p><?php echo $quiz->intro ?></p>
                <!--<p style="color:black; font-size:18px; font-style:italic;">Số câu hỏi</p>-->
                
                <p style="font-size:17px; color:#060606; font-style:italic; font-weight:bold;"><em>Thời gian làm bài <?php echo $gio." giờ  ".$phut." phút ".$giay." giây " ; ?></em></p>
                <!--them-->
                <!---->
                <form action="<?=$CFG->wwwroot?>/mod/quiz/startattempt.php">
                <div>
                	 <input type="submit" style="padding-left:70px; color:#ffffff; font-size:20px; font-weight:bold;" class="start-test" value="BẮT ĐẦU LÀM BÀI"/>
                	 <input type="hidden" name="cmid" value="<?php echo $cm->id?>">
                	 <input type="hidden" name="sesskey" value="<?=$USER->sesskey ?>">
                </div>
                </form>          
            </div>
            <div style="width: 800px; height: 30px; border:1px solid #ccc; margin: 10px auto; padding 10px; text-align: center;" class="panel panel-primary panel-quiz-info">
            		 <div style="float:left; color:blue; font-size:15px; font-weight:bold; margin-top: 5px; text-align: center;">Số người làm bài : <?php echo $quizc->c;
            		  ?></div>    
            </div>
            <style type="text/css">
            	#quiz-content .box-wrapper {
    				padding: 30px 10px;
			}
            	.panel-primary>.panel-heading {
    				color: #fff;
    				background-color: #337ab7;
    				border-color: #337ab7;
				}
				.panel-heading {
				    padding: 10px 15px;
				    border-bottom: 1px solid transparent;
				    border-top-left-radius: 0px;
				    border-top-right-radius: 0px;
				    font-weight: bold;	
				}
				.text-center {
				    text-align: center;
				}
				#quiz-content .panel-quiz-info.panel-primary {
    				border: none;
				}
				.panel.panel-primary {
				    border: none;
				}
				.panel-primary {
				    border-color: #337ab7;
				}
				.panel {
				    margin-bottom: 20px;
				    background-color: #fff;
				    border: 1px solid transparent;
				    border-radius: 4px;
				    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
				    box-shadow: 0 1px 1px rgba(0,0,0,.05);
				}
				.start-test {
				    height: 70px;
				    width: 270px;
				    background: #337ab7 url("https://hocmai.vn/theme/new2/images/quiz/clock.png") no-repeat scroll 10px center !important;
				    padding-left: 70px;
				    box-shadow: 2px 3px 3px 0 rgba(99,99,99,0.75);
				    font-size: 20px;
				    font-weight: bold;
				    border-radius: 6px;

				    color: #fff !inportant;
				}
/*dong ho */
				#timer #clock span {
    display: block;
    font-size: 14px;
    color: #ff0101;
    font-weight: bold;
    margin-bottom: 5px;
}
	.timer-body{

	    top: 0;
	    right: 0;
	    padding: 5px;
	    border: 1px solid #cdcccc;
	    border-top: none;
	    border-right: none;
	}
	#timer #clock .time-clock {
    border: none;
    font-size: 18px;
    color: #000000;
    font-weight: 900;
    text-align: center;
}

#timer #clock {
    text-align: center;
}
form {
    margin-bottom: 0px;
}
            </style>
    </div>
<?php } ?>
<?php
echo $OUTPUT->footer();
?>
<!--
1. mdl_quiz_attemp
 cos truong quiz id . dung cound quiz id de lay ra so nguoi

-->