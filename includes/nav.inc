<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">My Friend System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item <?php if ($page == "home") { echo "active"; } ?>">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item <?php if ($page == "about") { echo "active"; }?>">
        <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item <?php if ($page == "friendlist") { echo "active"; }?>">
        <a class="nav-link" href="friendlist.php">Friend List</a>
        </li>
        <li class="nav-item <?php if ($page == "friendadd") { echo "active"; }?>">
        <a class="nav-link" href="friendadd.php?p=1">Add Friends</a>
        </li>
        <li id="loginMenu" class="nav-item <?php if ($page == "sign") { echo "active"; } elseif ($page == "friendlist") { echo "hideme"; } elseif ($page == "friendadd") { echo "hideme"; } ?>">
        <a class="nav-link" href="sign-up.php">Sign Up</a>
        </li>
        <li id="loginMenu" class="nav-item <?php if ($page == "login") { echo "active"; } elseif ($page == "friendlist") { echo "hideme"; } elseif ($page == "friendadd") { echo "hideme"; } ?>">
        <a class="nav-link" href="login.php">Login</a>
        </li>
        <?php if ($page == "friendlist") {
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\">Logout</a></li>";
        } ?>
        <?php if ($page == "friendadd") {
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\">Logout</a></li>";
        } ?>
    </ul>
    </div>
</nav>