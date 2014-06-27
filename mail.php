<html>
<head>
<title>PHPMailer - SMTP (Gmail) basic test</title>
</head>
<body>

<?php

//error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Toronto');

require_once('class.phpmailer.php');
require_once('language/phpmailer.lang-en.php');
require_once("./include/captcha-creator.php");
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
$con=new contactForm();
//$con->contactForm();
//get post form data
 $captcha= new FGCaptchaCreator('scaptcha');
 //echo $captcha;
 $con->EnableCaptcha($captcha);
 //echo	 "session".strtoupper ($_SESSION['c']);
// echo  "field".strtoupper ($_REQUEST['scaptcha']);
class FG_CaptchaHandler
{
    function Validate() { return false;}
    function GetError(){ return '';}
}
class contactForm{
   var $form_random_key;
	var $mail;
 var $body;
	var $address;
	var $contact_name;
	var $name;
	var $email;
	var $message;
	var $captcha_handler;
	var $errors;
var $count=1;
	
	function contactForm(){
	//echo	"scaptcha".$_REQUEST['scaptcha'];
//	echo	"scaptchaCreater".$this->captcha_handler;
	    $this->form_random_key = 'HTgsjhartag';
	      $this->errors = array();
 $this->mail             = new PHPMailer();

 $this->body             = file_get_contents('contents.html');
//$body             = preg_replace('/[\]/','',$body);

$this->mail->IsSMTP(); // telling the class to use SMTP
$this->mail->Host       = "mail.yourdomain.com"; // SMTP server
$this->mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$this->mail->SMTPAuth   = true;                  // enable SMTP authentication
$this->mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$this->mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$this->mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$this->mail->Username   = "olivuawang@gmail.com";  // GMAIL username
$this->mail->Password   = "olivia23";            // GMAIL password

$this->mail->SetFrom('olivuawang@gmail.com', 'First Last');

$this->mail->AddReplyTo("olivuawang@gmail.com","First Last");

$this->mail->Subject    = "PHPMailer Test Subject via smtp (Gmail), basic";

$this->mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$this->mail->WordWrap   = 50; // set word wrap


$this->address = "olivuawang@gmail.com";
$this->mail->AddAddress($this->address, "Yueyue Wang");

//$this->mail->AddAttachment("images/phpmailer.gif");      // attachment
//$this->mail->AddAttachment("images/phpmailer_mini.gif"); // attachment


if(isset($_REQUEST['name'])){
	$this->contact_name=$this->Sanitize($_REQUEST['name']);
	
	
	
	
}else{
	
	$this->contact_name="";
}
//echo $_REQUEST['sea_email'];
//echo $this->contact_name;
//echo "<script>alert(".$_REQUEST['sea_email'].")</script>";
if(isset($_REQUEST['sea_email'])){
	
	$this->email=$this->Sanitize($_REQUEST['sea_email']);
	//echo "<script>alert($this->email)</script>";
	$this->message="<p>You have visited my online porfolio,ui23.com, I will contact you later.</p>";
	$this->name="you";
 if(empty($_REQUEST['sea_email']))
        {
            $this->add_error("Please provide your email address");
           
        }
        else
        if(strlen($_REQUEST['sea_email'])>50)
        {
            $this->add_error("Email address is too big!");
         
        }
        else
        if(!$this->validate_email($_REQUEST['sea_email']))
        {
            $this->add_error("Please provide a valid email address");
           
        }
        if($this->errors){
        	
        	
        	  $this->errors = implode('<br/>',$this->errors);
         echo  $this->errors;
            return;
        }
	$this->mail->Subject= "thank to $this->name visit my website!";
	$this->mail->AddReplyTo($this->email, $this->name);
     $this->mail->AddAddress($this->email, $this->name);
      $this->mail->SetFrom($this->email, $this->name);
       $this->body="$this->message";
       $this->mail->MsgHTML($this->body);
if(!$this->mail->Send()) {
  echo "Mailer Error: " . $this->mail->ErrorInfo;
  return;
} else {
  
   echo "I have received your message, will contact you later!";
   return;
   //$m="I have received your message, will contact you later!";
   //$this->RedirectToURL("http://localhost:8081/c/#contact?success=".$m);
}
       

}else{
	
	$this->email="";
}
if(isset($_REQUEST['email'])){
	$this->email=$this->Sanitize($_REQUEST['email']);
	
	
	
}else{
	$this->email="";
}
//echo $email;
if(isset($_REQUEST['phone'])){
	$this->phone=$this->Sanitize($_REQUEST['phone']);
	
	
}else{
	
	$this->phone="";
}
//echo $phone;
if(isset($_REQUEST['message'])){
	
	
	$this->message=$this->Sanitize($_REQUEST['message']);
}else{
	
	
	$this->message="";
}
//echo $message;


	 $this->body="<p>$this->phone</p><p>$this->message</p>";
    if($this->email!=null){
   $this->mail->SetFrom($this->email, $this->contact_name);}
     if($this->email!=null){
$this->mail->AddReplyTo($this->email, $this->contact_name);
     $this->mail->AddAddress($this->email, $this->contact_name);
     
     }
if($this->contact_name!=null){
	
$this->mail->Subject= "$this->contact_name thank to visit my website!";
	
}

$this->mail->MsgHTML($this->body);

// echo "<script>alert($this->count)</script>";
if($this->Validate()){
	$this->count++;

if(!$this->mail->Send()) {
  echo "Mailer Error: " . $this->mail->ErrorInfo;
} else {
  
   echo "I have received your message, will contact you later!";
   $m="I have received your message, will contact you later!";
   $this->RedirectToURL("http://www.ui23.com/#contact?success=".$m);
}}else{
	
	  $this->errors = implode('<br/>',$this->errors);
	echo "<div style='color:red;width:98%;padding:10px;-moz-box-shadow: 2px 0px 3px #000;
	-webkit-box-shadow: 2px 0px 3px #000;
	box-shadow: 2px 0px 3px #000;	-webkit-border-radius:10px;-moz-border-radius:10px;-khtml-border-radius: 10px;
border-radius: 10px; 	background-color: #fff;
		background-image: linear-gradient(bottom, rgb(245,247,249) 0%, rgb(255,255,255) 100%);
		background-image: -o-linear-gradient(bottom, rgb(245,247,249) 0%, rgb(255,255,255) 100%);
		background-image: -moz-linear-gradient(bottom, rgb(245,247,249) 0%, rgb(255,255,255) 100%);
		background-image: -webkit-linear-gradient(bottom, rgb(245,247,249) 0%, rgb(255,255,255) 100%);
		background-image: -ms-linear-gradient(bottom, rgb(245,247,249) 0%, rgb(255,255,255) 100%);'>$this->errors</div>";
	
}
}
    function EnableCaptcha($captcha_handler)
    {
        $this->captcha_handler = $captcha_handler;
        session_start();
    }
function Validate()
    {
        $ret = true;
        //security validations
      /*  if(empty($_POST['formID']))
          //$_POST['formID'] != $this->GetFormIDInputValue() )
        {
            //The proper error is not given intentionally
            $this->add_error("Automated submission prevention: case 1 failed");
            $ret = false;
        }

        //This is a hidden input field. Humans won't fill this field.
        if(!empty($_POST['spam']) )
        {
            //The proper error is not given intentionally
            $this->add_error("Automated submission prevention: case 2 failed");
            $ret = false;
        }*/

        //name validations
        if(empty($_REQUEST['name']))
        {
            $this->add_error("Please provide your name");
            $ret = false;
        }
        else
        if(strlen($_REQUEST['name'])>50)
        {
            $this->add_error("Name is too big!");
            $ret = false;
        }

        //email validations
        if(empty($_REQUEST['email']))
        {
            $this->add_error("Please provide your email address");
            $ret = false;
        }
        else
        if(strlen($_REQUEST['email'])>50)
        {
            $this->add_error("Email address is too big!");
            $ret = false;
        }
        else
        if(!$this->validate_email($_REQUEST['email']))
        {
            $this->add_error("Please provide a valid email address");
            $ret = false;
        }

        //message validaions
        if(strlen($_REQUEST['message'])>2048)
        {
            $this->add_error("Message is too big!");
            $ret = false;
        }
//echo "handler".$this->captcha_handler;
        //captcha validaions
    
       
          
        
         
            if(empty($_REQUEST['scaptcha'])){
            	
            	$this->add_error("Please enter the code in the image");
                $ret = false;
          
            }else{
                if(!strcmp (strtoupper ($_SESSION['c']),strtoupper ($_REQUEST['scaptcha'])))
            {
                $this->add_error("The code does not match.");
                $ret = false;
            }
            }
        
        //file upload validations
   /*     if(!empty($this->fileupload_fields))
        {
         if(!$this->ValidateFileUploads())
         {
            $ret = false;
         }
        }*/
        return $ret;
    }
    
   
/*}else{
	
	   $this->error_message = implode('<br/>',$this->errors);	
	   echo $this->error;
}*/

  function validate_email($email)
    {
        return eregi("^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$", $email);
    }
     function Sanitize($str,$remove_nl=true)
    {
        $str = $this->StripSlashes($str);

        if($remove_nl)
        {
            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
                );
            $str = preg_replace($injections,'',$str);
        }

        return $str;
    }
    
 function StripSlashes($str)
    {
        if(get_magic_quotes_gpc())
        {
            $str = stripslashes($str);
        }
        return $str;
    }
  function add_error($error)
    {
        array_push($this->errors,$error);
    
    }
  function GetKey()
    {
        return $this->form_random_key.$_SERVER['SERVER_NAME'].$_SERVER['REMOTE_ADDR'];
    }
  function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
   function GetFormIDInputName()
    {
        $rand = md5('TygshRt'.$this->GetKey());

        $rand = substr($rand,0,20);
        return 'id'.$rand;
    }
 function GetSpamTrapInputName()
    {
        return 'sp'.md5('KHGdnbvsgst'.$this->GetKey());
    }
}
?>

</body>
</html>
