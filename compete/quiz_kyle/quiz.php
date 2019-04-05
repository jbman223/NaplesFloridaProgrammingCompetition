<?php
/**
 * Created by PhpStorm.
 * User: Foiani
 * Date: 4/3/2017
 * Time: 11:05 AM
 */
class Question{
    var $index;
    var $author;
    var $picture;

    public function __construct($iIndex, $iAuthor, $iPicture)
    {
        $this->index= $iIndex;
        $this->author= $iAuthor;
        $this->picture= $iPicture;
    }

    public function getIndex(){
        return $this->index;
    }

    public function getAuthor(){
        return $this->author;
    }

    public function getPicture(){
        return $this->picture;
    }
}

/* todo: find way to import questions from file*/
$questions = array(
    new Question(1,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q1.PNG"),//C
    new Question(2,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q2.PNG"),//C
    new Question(3,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q3.PNG"),//C
    new Question(4,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q4.PNG"),//A
    new Question(5,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q5.PNG"),//C
    new Question(6,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q6.PNG"),//A
    new Question(7,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q7.PNG"),//C
    new Question(8,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q8.PNG"),//D
    new Question(9,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q9.PNG"),//C
    new Question(10,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q10.PNG"),//B
    new Question(11,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q11.PNG"),//A
    new Question(12,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q12.PNG"),//A
    new Question(13,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q13.PNG"),//C
    new Question(14,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q14.PNG"),//A
    new Question(15,"the AP CSP Course Description", "http://www.programmingcompetition.org/mcqQuestions/q15.PNG"),//D
    new Question(16,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q16.PNG"),//A
    new Question(17,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q17.PNG"),//A
    new Question(18,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q18.PNG"),//B
    new Question(19,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q19.PNG"),//C
    new Question(20,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q20.PNG"),//C
    new Question(21,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q21.PNG"),//B
    new Question(22,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q22.PNG"),//E
    new Question(23,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q23.PNG"),//B
    new Question(24,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q24.PNG"),//A
    new Question(25,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q25.PNG"),//D
    new Question(26,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q26.PNG"),//E
    new Question(27,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q27.PNG"),//D
    new Question(28,"the AP CSA 2015 Released Exam", "http://www.programmingcompetition.org/mcqQuestions/q28.PNG"),//C
    new Question(29,"the AP CSA 2014 Practice Exam", "http://www.programmingcompetition.org/mcqQuestions/q29.PNG"),//C
    new Question(30,"the AP CSA 2014 Practice Exam", "http://www.programmingcompetition.org/mcqQuestions/q30.PNG"),//C
    new Question(31,"the AP CSA 2014 Practice Exam", "http://www.programmingcompetition.org/mcqQuestions/q31.PNG"),//B
    new Question(32,"the AP CSA 2014 Practice Exam", "http://www.programmingcompetition.org/mcqQuestions/q32.PNG"),//D
    new Question(33,"the AP CSA 2014 Practice Exam", "http://www.programmingcompetition.org/mcqQuestions/q33.PNG"),//C
    new Question(34,"the AP CSA 2014 Practice Exam", "http://www.programmingcompetition.org/mcqQuestions/q34.PNG"),//E
    new Question(35,"the AP CSA 2014 Practice Exam", "http://www.programmingcompetition.org/mcqQuestions/q35.PNG"),//C
    new Question(36,"the AP CSAB Practice Exam", "http://www.programmingcompetition.org/mcqQuestions/q36.PNG"),//C
    new Question(37,"the AP CSAB Practice Exam (sorry about this one)", "http://www.programmingcompetition.org/mcqQuestions/q37.PNG"),//D
    new Question(38,"the AP CSAB Practice Exam", "http://www.programmingcompetition.org/mcqQuestions/q38.PNG"),//C
    new Question(39,"the AP CSAB Practice Exam", "http://www.programmingcompetition.org/mcqQuestions/q39.PNG"),//C
    new Question(40,"the AP CSAB Practice Exam (hold this L)", "http://www.programmingcompetition.org/mcqQuestions/q40.PNG"),//C
    new Question(41,"the AP CSAB Practice Exam (think broadly)", "http://www.programmingcompetition.org/mcqQuestions/q41.PNG"),//D
    new Question(42,"the AP CSP Course Description (easy one at the end)", "http://www.programmingcompetition.org/mcqQuestions/q42.PNG"));//C
?>



<!DOCTYPE html>
<html lang = "en">
<head>

    <title>NFPC- Multiple Choice Exam</title>

    <meta charset="utf-8">

    <link rel="stylesheet" type="text/css" href="quizStyle.css">
    <meta name="viewport" content="width-device-width, initial-scale-1.0">
</head>

<body class="body">
    <div class="mainContent">
        <article class="bottomContent">
            <h1 align="center" class="bottomContent"><font size="6">2017 - NFPC Multiple Choice Test</font></h1>
            <?php
                echo"<aside class = 'nameEnter'><center><p>
                     <input type='text' placeholder='Enter School Name' id='t1'>
                     <input type='text' placeholder='Enter Team Name' id='t2'></center></p></aside>";

                for ($i=0;$i<count($questions);$i++) {

                    echo "<header class='mainHeader'>Question " . $questions[$i]->getIndex() . "</header><br>";

                    echo "<footer class='post-info'>This question came from " . $questions[$i]->getAuthor();
                    echo "</footer><br>";


                   //echo "<center>";
                        $temp = $questions[$i]->getPicture();
                        echo "<center><content class='center'><img src=$temp></content><br></center>";

                        //echo "<input type='text' maxlength='1' placeholder='Answer' id='r$i'>";
                        echo"
                        <form id='r$i'>
                            <ul class='list'>
                                <li><input type='radio' name='r$i' value='A'><label> A</label></li>
                                <li><input type='radio' name='r$i' value='B'><label> B</label></li>
                                <li><input type='radio' name='r$i' value='C'><label> C</label></li>
                                <li><input type='radio' name='r$i' value='D'><label> D</label></li>
                                <li><input type='radio' name='r$i' value='E'><label> E</label></li>
                            </ul>
                        </form>";
                    //echo "</center>";
                }

            ?>
        </article>
    </div>

    <center class="mainFooter">
        <button class="submitButton" onclick="myFunction();">Submit Answers and Finish Test</button>
    </center>


    <script>
        var numQuestions = 42;
        function myFunction() {

            var answers = [];
            for(var i = 0; i < numQuestions; i++) {
                var temp = document.getElementById("r"+i).elements;
                answers.push(temp["r"+i].value);
            }
            //alert("" + answers);
            /* todo: calculate score */
            //var score = -1;

            var json = JSON.stringify(answers);

            var school = document.getElementById("t1");
            var name = document.getElementById("t2");

            //window.location.href = "./upload.php?ans=" + json + "&id=" + name.value;

            var tempPost = {ans: json, id: name.value + ", " + school.value};
            post("upload.php", tempPost);

        }

        function post(path, params, method) {
            method = method || "post";
            var form = document.createElement("form");
            form.setAttribute("method", method);
            form.setAttribute("action", path);

            for(var key in params) {
                if(params.hasOwnProperty(key)) {
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", key);
                    hiddenField.setAttribute("value", params[key]);

                    form.appendChild(hiddenField);
                }
            }

            document.body.appendChild(form);
            form.submit();
        }

    </script>
</body>
</html>
