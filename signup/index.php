<?php

require_once "formvalidator.php"

?>
<!DOCTYPE HTML>
<html>
<head>
  <script>
    var frmvalidator = new Validator("register");
    frmvalidator.EnableOnPageErrorsDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("name", "req", "Please provide your name");
    frmvalidator.addValidation("email", "req", "Please provide your email address");
    frmvalidator.addValidation("email", "email", "Please provide a valid email address");
    frmvalidator.addValidation("username", "req", "Please provide a username");
    frmvalidator.addValidation("password", "req", "Please provide a password");
    
    function RegisterUser()
    {
      if(!isset($_POST['submitted']))
      {
        return false;
      }
      $formvars = array();
      if(!$this->ValidateRegistrationSubmission())
      {
        return false;
      }
      $this->CollectRegistrationSubmission($formvars);
      if(!this->SaveToDatabase($formvars))
      {
        return false;
      }
      if(!$this->SendUserConfirmationEmail($formvars))
      {
        return false;
      }
      $this->SendAdminIntimationEmail($formvars);
      return false;
    }
    
    function SaveToDatabase($formvars)
    {
      if(!$this->DBLogin()0
      {
         $this->HandleError("Database Login Failed!");
         return false;
      }
      if(!this->Ensuretable())
      {
        return false;
      }
      if(!$this->IsFieldUnique($formvars,'email'))
      {
        $this->HandleError("This email is already registered");
        return false;
      }
      if(!$this->IsFieldUnique($formvars, 'username'))
      {
        $this->HandleError("This user name is already used");
        return false;
      }
      if(!$this->InsertIntoDB($formvars))
      {
        $this->HandleError("Inserting to Database failed!");
        return false;
      }
    return true;
    }
    
    function InsertIntoDB(&$formvars)
    {
      $confirmcode = $this->MakeConfirmationMd5($formvars['email']);
      $insert_query = 'insert into '.$this->tablename.'(name,email,username,password,confirmcode)
      values("' . $this->SanitizeForSQL($formvars['name']) . '","' . $this->SanitizeForSQL($formvars['email']) . '","' . $this->SanitizeForSQL($formvars['username']) . '","' . md5($formvars['password']) . '","' . $confirmcode . '")';      
      if(!mysql_query( $insert_query ,$this->connection))
      {
        $this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
        return false;
      }        
        return true;
      } 
    function SendUserConfirmationEmail(&$formvars)
    {
      $mailer = new PHPMailer();
      $mailer->CharSet = 'utf-8';
      $mailer->AddAddress($formvars['email'],$formvars['name']);
      $mailer->Subject = "Your registration with ".$this->sitename;
      $mailer->From = $this->GetFromAddress();        
      $confirmcode = urlencode($this->MakeConfirmationMd5($formvars['email']));
      $confirm_url = $this->GetAbsoluteURLFolder().'/confirmreg.php?code='.$confirmcode;
      $mailer->Body ="Hello ".$formvars['name']."\r\n\r\n".
      "Thanks for your registration with jHeight EDU""\r\n".
      "Please click the link below to confirm your registration.\r\n".
      "$confirm_url\r\n".
      "\r\n".
      "Regards,\r\n".
      "N.E.R.O Bot\r\n".
      $this->sitename;
      if(!$mailer->Send())
      {
        $this->HandleError("Failed sending registration confirmation email.");
        return false;
       }
    return true;
    }
          
    
    
  </script>
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
</fieldset>
</form>
</body>
</html>
