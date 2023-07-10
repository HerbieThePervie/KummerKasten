<?php
/* This is a PHP code that is destroying the current session and redirecting the user to the login page
(index.php). The `session_start()` function starts a new or resumes an existing session, while
`session_destroy()` function destroys all data registered to a session. The `header()` function is
used to send a raw HTTP header to redirect the user to the login page. */
session_start();
session_destroy();
// Redirect to the login page:
header('Location: index.php');
?>