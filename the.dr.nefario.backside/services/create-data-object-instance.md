# Creating and using a data object
You can take a look at the code in the `objectbase.php` - as pretty much simple as we could make it
## Setting up stuff
- Create an object table in the database
- Create two files in the objectlayer folder
1. `[*table name*].php` - Inherits from objectbase.php (*see `appuser.php` for example*)
2. `[*table name*]collection.php` - Inherits from objectcollectionbase.php (* see `appusercollection.php` for example*)
3. If you're fine with the out-of-the-box functionality that we're discussion below, you're good to go. If you want more functionality, you should be decorating your data classes with. We'll take one example.

## Instancing
To create an instance, simply pass an `id` to the constructor. Or `null` to create a new object.
## Object properties
The properties of a data object are the fields in your data table. That's it. But with these two conditions:
### Timestamp
It you want to create timestamp fields, you'll need to put a _ts suffix to the field name. You can have as many timestamp fields as you want.
### Boolean
We've used this concept of boolean values:
For boolean values, you need to create a `char(1)` field. Where `''` is true and `NULL` is false

## Save (*Edit* or *New*)
After you get the object instance, go ahead change / set property values. Call `[*data object*]->Save()` and you're done.
- If the instance has an `id`, we will update the existing record
- If the `id` is `NULL`, we'll create a new record.
### ~~Override duplicate~~
~~A VERY BAD IDEA~~
~~This is a special case and it requires that you have a `name` field in your table~~

~~So let's say you create a new record and that record has a `name` identical to a name for a record that already exists.~~

~~If you want duplicate records with the same `name` value, then you're fine just going through the motions.~~

~~However, if you want to update a record if the `name` is the same. Even if the `id` is NULL, then you'll need to pass in (*the optional*) override_duplicate boolean parameter as `TRUE`.~~

## Delete
This one's pretty straightforward. Just create an instance and Call `[*data object*]->Delete()`.

We haven't handle db delete error such as deleting a record that is referenced. You should be doing that yourself.