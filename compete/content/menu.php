<div class="row logoRow">
    <div class="col-md-12 col-12-sm col-12-xs text-center">
        <a class="logo-text" href="http://programmingcompetition.org/compete"><img class="logo-image"
                                                                                              src="/images/WhiteShadowLogo.png"/></a>
    </div>
</div>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/compete/index.php">Home</a></li>
                <li><a href="/compete/solve">Solve Problems</a></li>
                <li><a href="/compete/problems">Problem List</a></li>
                <li><a href="/compete/quiz">Quizzes</a></li>
                <li><a href="/compete/forum">Clarifications</a></li>
                <li><a href="/compete/leaderboard">Leader Board</a></li>
                <li><a href="/compete/references">References</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <? if (!isUserLoggedIn()) { ?>
                            <li><a href="/compete/account/login.php">Log In</a></li>
                        <? } else { ?>
                            <? if ($user['admin'] != 0) {
                                ?>
                                <li><a href="/compete/admin">Administration</a></li>
                                <?
                            } ?>
                            <li><a href="/compete/account/logout.php">Log Out</a></li>
                        <? } ?>
                    </ul>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
