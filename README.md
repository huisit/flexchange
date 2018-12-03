# flexchange
Term Project for Web Systems Fall 2018

To configure your email, ensure that you have your smtp settings configured properly.
The settings we used for our project are as follows:

xampp\php\php.ini:
SMTP=smtp.gmail.com
smtp_port=587
sendmail_from = flexchange.noreply@gmail.com
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"

xampp\sendmail\sendmail.ini:
[sendmail]
smtp_server=smtp.gmail.com
smtp_port=587
error_logfile=error.log
debug_logfile=debug.log
auth_username=flexchange.noreply@gmail.com
auth_password=OURSECRETPASSWORD
force_sender=flexchange.noreply@gmail.com
