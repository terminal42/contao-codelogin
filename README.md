# Code Login extension for Contao Open Source CMS

This extension allows frontend users (members) to log in with a secret code.


## Installation

Install the bundle using composer:

```
$ composer require terminal42/contao-assets
```

Then run the Contao Install Tool and update the database.

**Be aware that this extension currently only supports Contao 4.4 (LTS).**


## How To Use

The bundle does two things:

1. Adds a new code field to members and disables mandatory-ness of
   username/password.
2. Provides a new code login front end module. Place it on any Contao
   page to allow a member to login with a code instead of a username/password.


You can also allow automatic login from a link by setting up a query
parameter in the configuration field of the front end module.


## About Security

**ATTENTION:** This extension is very much not secure! The login code
will be stored in plain text in the database. Do not use it for a
regular website with protected member section. We only use it to allow
clients to one-time update their personal data.

**The stronger your code, the more secure the login process will be.**
**Don't use a incremental number, people might try random codes!**

