This is a project for the second task of the PHP Training.
To use this project, Wampserver or Xampp server ought ot be installed on the system.

If it is a wampserver, copy/clone the project into the wamp64/www directory.

If it is a XamppServer, copy/clone the project into the xampp/htdocs directory.

The SuperAdmin user's credentials are
email: principal@hng.com;
password: test123

Other users currently on the system are:
joshua@olawale.com and
onifade@ayomide.com

Both users have the same password as the SUperAdmin (test123)

On the start of the project, a new user can register by clicking the register link in the index.php page.
Once he is registered successfully, he is directed to the login.php page where he can now login with his chosen credentials. He is directed to the a dashboard based on his designation which can either be Student, Teacher or Non-teaching Staff. ONLY THE SUPERADMIN CAN ADD ADMIN USERS.

On Login, the date and time of login are captured and saved with the user data in the db/users file.

The dashboard displays to the user:

1. The Department
2. The User ID
3. Date of Registration
4. Date the user was last Logged in

The Dashboards are in the dashboard directory of the project.

The Users are saved in the db/users directory of the project
