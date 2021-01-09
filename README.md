# camagru


A basic web app that allows users to take pictures using a webcam and superimpose predefined images onto them.

## Getting Started

### Installation

* Install xampp https://www.apachefriends.org/index.html

* How to set up and configure XAMPP:
 
1. Place the downloaded Camagru folder into the installed path "C:\xampp\htdocs"
`Ensure less secure apps enabled on gmail (as I used gmail for sending email)`
2. Next navigate to "C:\xampp\php\php.ini"
3. Look for the heading "[mail function]"
4. Set SMTP=smtp.gmail.com
5. smtp_port=587
6. sendmail_from = ENTER YOUR EMAIL HERE
7. sendmail_path = ""C:\xampp\sendmail\sendmail.exe" -t"
8. Save and close php.ini
9. Next navigate to "C:\xampp\sendmail\sendmail.ini"
10. Look for the heading "[sendmail]"
11. Set smtp_server=smtp.gmail.com
12. Set smtp_port=587
13. Set auth_username = ENTER YOUR EMAIL HERE
14. Set auth_password = ENTER YOUR GMAIL PASSWORD
15. Save and close sendmail.ini
