<?php
session_start();
session_unset();
session_destroy();

// Prevent back button from accessing the previous session
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// JavaScript to prevent going back
echo '<script>
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
      </script>';

// Redirect to login page
header("Location: login.php");
exit();
?>
