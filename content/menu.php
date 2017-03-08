<div class="row logoRow">
    <div class="col-md-12 col-12-sm col-12-xs text-center">
        <a class="logo-text" href="http://programmingcompetition.org/"><img class="logo-image"
                                                                            src="/images/NFPCLogoSmall.png"/></a>
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
            <a class="navbar-brand" href="/index.php">NFPC</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/index.php">Home</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">About
                        <span class="caret"></span></a>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/about.php">General Information</a></li>
                        <li><a href="/schedule.php">Schedule</a></li>
                        <li><a href="/team.php">The Team</a></li>
                        <li><a href="/promos.php">Promotional Material</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Downloads</li>
                        <li>
                            <a href="https://docs.google.com/document/d/1oaaPaCS3qvEnrTVn1q2OmQOJzSglOmfygI2S_cmIeFc/edit?usp=sharing"
                               target="_blank">Competition Bylaws</a></li>
                        <li><a href="/downloads/WebsiteWalkthrough.pdf" target="_blank">Website Walk-Through</a></li>
                    </ul>
                </li>

                <li><a href="/edu">Education Center</a></li>

                <li><a href="/sponsors.php">Sponsors</a></li>
                <li><a href="/press.php">Press</a></li>
                <li><a href="/contact.php">Contact</a></li>


            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <? if (!isUserLoggedIn()) { ?>
                            <li><a href="/account/register.php">Register</a></li>
                            <li><a href="/account/login.php">Log In</a></li>
                        <? } else { ?>
                            <li><a href="/account/account.php">Account Manager</a></li>
                            <li><a href="/account/logout.php">Log Out</a></li>
                        <? } ?>
                    </ul>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
