# Get started with using the Object Lair
1. Clone this repo

What's with the `rest.api.php` file:

This file exposes the object layer via RESTFul functions
**Important**: The rest.api.php is dependent on the [SLIM Micro framework](https://www.slimframework.com/).

This is required only to run the REST calls. It is not a requirement of the object layer. But if you want to test the layer via REST, you'll either need to download SLIM as a sibling folder of objectlayer. Or if you've got another framework you prefer, then, of course, you'll need to make the appropriate changes to the rest.api.php

\2. [SLIM STUFF NEEDS TO GO HERE]
2. This is a PHP-based framework, so you'll need PHP running on your computer.
3. Either place these files into a folder that's accessible by your PHP installation or point to this folder.
4. Point your PHP server to the main cloned folder. The one that has the phpinfo.php file in it.
5. If you want to check that you've got the setup right, open the browser and do:

http://localhost:[port number]/[some folders]/phpinfo.php

6. Open the datainfo.json file and put your mySQL connection data in there
7. Create a table in your database called `appuser`.
8. Make sure the `appuser` table primary key is `id` (*mandatory*)
9. But also make sure there are other fields in the `appuser` table (*more so that you can see some data when you run things*)
10. To see that anything is happening, put at least one row into the `appuser` table
11. Now open some tool like [Postman](https://www.getpostman.com/)
12. And run the REST command:

http://localhost:[port number]/[some folders]/rest.api.php/getobjectbyid/<id for an appuser record that you created>/

13. If everything works fine, you're on your way.
14. Now, for every object table that you create, you need to create two files in `objectlayer`:

- `[*table name*].php` - That inherits from `objectbase.php`
- `[*table name*]collection.php` - That inhertis from `objectcollectionbase.php`

For example, if you create an employee table, you need:
- `employee.php` - That inherits from `objectbase.php`
- `employeecollection.php` - That inhertis from `objectcollectionbase.php`
