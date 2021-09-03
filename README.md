# security_airline_website
Sample airline webpage implementing authentication, asymmetric encrypted communication, database query

Security Measures to Secure Company Network:\
• Login/Authentication feature.\
o Hashing passwords with PHP’s build-in hashing algorithm.\
o Default algorithm used is bcrypt algorithm. This algorithm makes use of
randomly generated salt string which enhances strength of hashed passwords.

• Using PDO extension (PHP Data Object) and Creating Separate Config File.\
o PDO’s prepare statement for querying has basic SQL injection protection,
providing values only once the statement has been “prepared”.\
o Making use of PDO’s DSN charset parameter (utf8) to further enhance
protection.\
o Separate config file that stores database name and passwords makes it more
secure to share code files without concerns about leaking password.

Mail Communication between users & branches:\
• The mail communication is implemented with asymmetric encryption.\
o When new user is created, a pair of public and private keys are generated for
that user.\
o Public keys are stored in database paired with UID.\
o Private keys are not stored in database, but, in this case, stored physically on
hard drive.\
o Sender retrieves public key of receiver, stores encrypted message on database.\
o Similar to Role Based Access Control, only the messages with correct permission
tag will be shown to the user, and the message is decrypted with receiver’s
private key.\

Role Based Access Control:\
• Database has permission tag that identifies proper location for each data.
o Each user is given permission tag as well (in this case, branch ID).
o If permission tags of data and user matches, data will show up for the user in
their web page.

How to Make It Work:
1. Download submitted abc_airline file and save under XAMPP/htdocs.
2. Turn on XAMPP and start Apache / MySQL.
3. On a browser, type URL of localhost and click phpMyAdmin.
4. Create a new database named abc_airline and click the newly created database.
5. Click import function on the top right corner.
6. Import create_tables.sql from abc_airline/database/abc_airline_sql to abc_airline db.
7. Import insert_tables.sql from abc_airline/database/abc_airline_sql.
8. From a browser, access index page by localhost/security_airline_website/templates.
9. Log in with admin account. ID: admin/ Pass: adminpass.
10. Admin account are allowed to create new account. Create new account and log in to the new account to see different features for normal employees
