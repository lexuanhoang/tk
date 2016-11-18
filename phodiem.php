<?php

//Trang chức năng gửi quà tặng

require_once(dirname(dirname(__FILE__)).'/config.php');

global $PAGE,$USER,$DB,$SESSION;

$PAGE->set_context(context_system::instance());
$PAGE->set_title("Phổ điểm kỳ thi");
$PAGE->set_pagelayout('mainlayout');

$id           = optional_param('id', 0, PARAM_INT);

$PAGE->set_url($CFG->wwwroot.'/thi/phodiem.php');

//Lấy dữ liệu chuyên đề
echo $OUTPUT->header();

if ($DB->record_exists('quiz_grades', array('quiz'=> $id))) {
    $quiz_grades = $DB->get_records_sql('SELECT ROUND(`grade`,1) AS `mark`, COUNT(ROUND(`grade`,1)) AS `number` FROM `mdl_quiz_grades` WHERE `quiz` = ' . $id . ' GROUP BY ROUND(`grade`,1)');

    $quizg = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

    foreach($quiz_grades as $row) {
        $quizg[intval($row->mark)] = intval($row->number);
    }
?>
    <style type="text/css">
        .demo-container {
            box-sizing: border-box;
            width: 850px;
            height: 450px;
            padding: 20px 15px 15px 15px;
            margin: 15px auto 30px auto;
            border: 1px solid #ddd;
            background: #fff;
            background: linear-gradient(#f6f6f6 0, #fff 50px);
            background: -o-linear-gradient(#f6f6f6 0, #fff 50px);
            background: -ms-linear-gradient(#f6f6f6 0, #fff 50px);
            background: -moz-linear-gradient(#f6f6f6 0, #fff 50px);
            background: -webkit-linear-gradient(#f6f6f6 0, #fff 50px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
            -o-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            -ms-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            -moz-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            -webkit-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .demo-placeholder {
            width: 100%;
            height: 100%;
            font-size: 14px;
            line-height: 1.2em;
        }

        .legend table {
            border-spacing: 5px;
        }
    </style>
    <script language="javascript" type="text/javascript" src="/theme/tk/flot/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="/theme/tk/flot/jquery.flot.js"></script>
    <script type="text/javascript">

        $(function() {

            var phodiem = [];
<?php foreach($quizg as $key=>$value) { ?>
            phodiem.push([<?php echo $key ?>, <?php echo $value ?>]);
<?php }?>
            var plot = $.plot("#placeholder", [
                { data: phodiem, label: "Phổ điểm"},
            ], {
                series: {
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
                grid: {
                    hoverable: true,
                    clickable: true
                }
            });

            $("<div id='tooltip'></div>").css({
                position: "absolute",
                display: "none",
                border: "1px solid #fdd",
                padding: "2px",
                "background-color": "#fee",
                opacity: 0.80
            }).appendTo("body");

            $("#placeholder").bind("plothover", function (event, pos, item) {

                if ($("#enablePosition:checked").length > 0) {
                    var str = "(" + pos.x.toFixed(2) + ", " + pos.y.toFixed(2) + ")";
                    $("#hoverdata").text(str);
                }

                if (item) {
                    var x = item.datapoint[0].toFixed(0),
                        y = item.datapoint[1].toFixed(0);

                    $("#tooltip").html(" điểm " + x + " có " + y + " người")
                        .css({top: item.pageY+5, left: item.pageX+5})
                        .fadeIn(200);
                } else {
                    $("#tooltip").hide();
                }
            });

        });

    </script>
    <div class="demo-container">
        <div id="placeholder" class="demo-placeholder"></div>
    </div>
<?php } ?>
<?php
echo $OUTPUT->footer();
?>
