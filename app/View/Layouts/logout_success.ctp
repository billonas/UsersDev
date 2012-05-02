<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->Html->charset(); ?>
<title>Επιτυχής αποσύνδεση</title>

<?php if (Configure::read('debug') == 0) { ?>
<meta http-equiv="Refresh" content="<?php echo $pause; ?>;url=<?php echo $url; ?>"/>
<?php } ?>
<style><!--
P { text-align:center; font:bold 1.1em sans-serif ;}
A { color:#444; text-decoration:underline}
A:HOVER { text-decoration: underline; color:#44E }
--></style>
</head>
<body><div id="center" style="position: fixed;
  top: 25%;
  left: 50%;
  margin-top:  0px;
  margin-left: -250px;">
<p>Αποσυνδεθήκατε επιτυχώς!</br>
<a href="<?php echo $url; ?>" style="color:#44E"><?php echo $message; ?></a></p></div>
</body>
</html>

