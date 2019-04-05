# data-object-lair
A simple PHP-based data object layer that you can easily use to set up RESTFul services in PHP
### tl;dr
Read the quick [Get started](https://github.com/peterbarraud/data-object-lair/blob/master/get-started.md)
## create a data object
For every table that you create in your db, you'll need to create two data object files
### inherit from object base
One file must inherit from the objectbase.php (see `appuser.php` for example)
### inhert from object base collection
The other file must inherit from the objectcollectionbase.php (see `appusercollection.php` for example)

## object base
The object base class has methods to
* `get` (actually via the construtor)
* `save` (edit or new)
* `delete` (this is still work in progress. especially for stuff like cascade delete et al)

## create your own class
The system is based directly on your db structure.

This means that for every table in your db, you'll need:
1. a class with the same name as the table in db that inherits from `objectbase`
2. a class with the same name as the table in db appended with collection that inherits from `objectcollectionbase`
Take a look at the `appuser` and `appusercollection` same files. Now remember to make these work, you're going to have to create a table in your db that's called appuser (exactly that name).
### Table structure
**id field**: Every table MUST have an `id` field as the primary key. This is mandatory. No other field can be included in the primary key.

**Other fields**: You can have any other field (or datatype) in the table.

But check the `timestamp` and `boolean` field conditions below.

**Timestamp fields**: You can have as many timestamp fields in a table.

Condition is that each field name MUST be appended with _ts. I think it's possible to db figure out if a field is timestamp but I think that's wasted effort.

**Boolean fields**: For boolean fields we're going to use `char(1) DEFAULT NULL`.
* true = ''
* false = NULL

Each boolean field name MUST be appended with _bool.
## decorating your own class
We're using a decorator pattern type approach here.

So if you want to add functionality to your object, you should be adding that to your own class not meddling around with the base class

## Using the data object
For each data object that you create, you can do the following

## Using the data object collection

## Use RESTFul frameworks
By definitiion, the framework is not about how you expose this to clients. It's simply an easy-to-use object structure that allows you to set up your database and then put together (with pretty much no effort) a object layter that gives your PHP access to your database.

However, I mostly prefer to use the very neat SLIM micro framework.

The rest.app.php file is pretty much self describing.




