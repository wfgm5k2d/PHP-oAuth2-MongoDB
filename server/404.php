<?php
http_response_code(404);
header('Content-type: text/html');

echo <<<HTML
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
<head>
<title>404 Not Found</title>
<meta charset="UTF-8">
</head>
<body>
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>
</body></html>  
HTML;

exit;