<h1 class="welcome">Welcome on homepage!</h1>

<?php
if (isset($flags)) {
    echo '<ul>';
    foreach ($flags as $flag) {
        if ($flag instanceof \Model\Flagi) {
            if ($flag->id() == 1) {
                echo "<li class='error'>Provided token is invalid!</li>";
            }
            if ($flag->id() == 3) {
                echo "<li class='info'>Email successfully confirmed!</li>";
            }
            if ($flag->id() == 2) {
                echo "<li class='error'>Email $flag->email does not exist!</li>";
            }

        }
    }
    echo '<ul>';
    
    foreach($flags as $flag) {
        if ($flag->id() == 4) {
            echo "Welcome back " . $flag->name . "!";
            echo "<h3 class='user'>$flag->name $flag->surname</h3>";
            echo "<a href='/auth/logout'>Logout</a>";
        } else {
            echo "<a href='/auth/login>Login</a>";
            echo "<a href='/auth/register'>Register</a>";
        }
    }


}
