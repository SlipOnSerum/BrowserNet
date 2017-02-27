<?php

require_once "formvalidator.php"

?>
<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<h3> Ready to Register? </h3>
<h4> Simply fill out the form below: </h4>
<form id="register" action="register.php" method="post" accept-charset="UTF-8">
<fieldset >
<legend> Register </legend>
<input type="hidden" name="submitted" id="submitted" value="1" />
<label for="name" > Your Full Name*: </label>
<input type="text" name="name" id="name" maxlength="50" />
<label for="email" > Email Address*: </label>
<input type="text" name="email" id="email" maxlength="50" />
<label for="username" > User Name*: </label>
<input type="text" name="username" id="username" maxlength="50" />
<input type="password" name="password" id="password" maxlength="50" />
<input type="submit" name="Submit" value="Submit" />
</fiedlset>
</form>
</body>
</html>
