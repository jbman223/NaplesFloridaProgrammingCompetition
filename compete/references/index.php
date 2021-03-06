<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../account/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Submit A Solution</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <script src="http://159.203.168.143:8080/socket.io/socket.io.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <!-- PAGE CONTENT HERE -->
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">References</h1>

                        <ul class="lead">
                            <li>Java Docs - <a href="https://docs.oracle.com/javase/7/docs/api/" target="_blank">Java 7 Reference</a></li>
                            <li>JavaScript Docs - <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference" target="_blank">Mozilla JavaScript Reference</a></li>
                            <li>C Guide - <a href="https://www-s.acm.illinois.edu/webmonkeys/book/c_guide/" target="_blank">C Reference</a></li>
                            <li>C++ Guide - <a href="http://en.cppreference.com/w/" target="_blank">C++ Reference</a></li>
                        </ul>

                        <h2> Taking Java Inputs (<i>Correctly</i>): </h2>
                        <pre>
import java.util.*;

public class Example
{
	public static void main (String[] args)
	{
		Scanner in = new Scanner (System.in);

		while (in.hasNext())
		{
			String name = in.nextLine();
			System.out.println ("hello" + name);
		}
	}
}
                        </pre>
                        <h2> Taking JavaScript inputs: </h2>
                        <pre>
process.stdin.resume();
process.stdin.setEncoding("utf-8");
var stdin_input = "";

process.stdin.on("data", function (input) {
	stdin_input += input;
});

process.stdin.on("end", function () {
	main(stdin_input);
});

// =========================
// They would only need this
// =========================

function main(input) {
	console.log(input);
}
                        </pre>
                    </div>
                </div>

            </div>
        </div>


    </div>

    <div class="modal fade code-display" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body code-area">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <? require_once "../content/footer.php"; ?>
    <script src="../js/liveEvents.js"></script>
</body>
</html>
