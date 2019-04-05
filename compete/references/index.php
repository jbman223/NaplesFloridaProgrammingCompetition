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

    <script src="http://programmingcompetition.org/compete/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <script src="http://ws.programmingcompetition.org:8080/socket.io/socket.io.js"></script>

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
                            <li>C Guide - <a href="https://www-s.acm.illinois.edu/webmonkeys/book/c_guide/" target="_blank">C Reference</a></li>
                            <li>C++ Guide - <a href="http://en.cppreference.com/w/" target="_blank">C++ Reference</a></li>
                        </ul>

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