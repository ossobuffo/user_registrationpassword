
CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Installation
 * Configuration
 * Email templates
 * Token
 * Multilangual sites
 * Known issues
 * De-installation
 * Upgrade notes


INTRODUCTION
------------

This module is a Drupal 9 compatible fork of drupal/user_registrationpassword.

User Registration Password lets users register with a password
on the registration form when 'Require email verification when
a visitor creates an account' is enabled on the configuration page.

By default, users can create accounts directly on the registration form, set
their password and be immediately logged in, or they can create their account,
wait for a verification email, and then create their password.

With this module, users are able to create their account along with their
password and simply activate their account when receiving the verification
email by clicking on the activation link provided via this email.

User Registration Password transforms the checkbox on the
admin/config/people/accounts page into a radio list with 3 options.

The first 2 are default Drupal behaviour:
 * Do not require a verification email, and let users set their password on the
   registration form.
 * Require a verification email, but wait for the approval email to let users set
   their password.

The newly added option is:
 * Require a verification email, but let users set their password directly on the
   registration form.

The first 2 disable User Registration Password, only the 3rd option activates
the behaviour implemented by this module.


REQUIREMENTS
------------

This module requires no modules outside of Drupal core.


INSTALLATION
------------

Install as you would normally install a contributed Drupal module:
```
composer require ossobuffo/user_registrationpassword
```

CONFIGURATION
-------------

The module sets the correct configuration settings on install, including the
correct account activation email template. But if you want to change something,
these steps describe how to configure the module in more detail.

On the admin/config/people/accounts page make sure you have selected the second
option, 'Visitors':

Who can register accounts?
 * Administrators only
 * **Visitors**
 * Visitors, but administrator approval is required

Then select 'Require a verification email, but let users set their password
directly on the registration form.' at:

Require email verification when a visitor creates an account
 * Do not require a verification email, and let users set their password on the
   registration form.
 * Require a verification email, but wait for the approval email to let users set
   their password.
 * **Require a verification email, but let users set their password directly on the
   registration form.**

The module is now configured and ready for use. This is also the only way to
configure it correctly. This module will also not work if you do not have
'Visitors' selected at 'Who can register accounts?' on the same page.


EMAIL TEMPLATES
----------------

Regarding email templates:

You do not have to alter any email templates, User Registration Password
overrides the default 'Account activation' email template during installation.
So there is no need to change anything anymore on a fresh installation.

If you have previously modified the account activation email template before you
installed this module and discovered that it overrides the default Account
activation email template, no worries! The installer saves your changes to the
template to a temporally variable and revives them when you uninstall User
Registration Password. Your modifications are revived and you can now copy/paste
them to a text file and re-install User Registration Password again and make the
changes to the 'account activation' email template based on your previous
version.


TOKEN
-----

The token provided by this module:

[user:registrationpassword-url]

Place this token in your registration email template (the installer tries to do
this during install, if that fails you have to manually add it).

Also see the token widget on the admin account form for all available tokens.


MULTILINGUAL SITES
------------------

All variables (including email) are all translatable via the core user
configuration translation page at admin/config/people/accounts/translate or via
the general translate configuration page.

Ones configured correctly, users will receive an email in their default
language, setting available on user's edit page. It does not matter what the
site language is, this setting will be leading and supersede the site's default
language. So it is logical and current that if you have a German based site
with, let's say German and English languages enabled, and German is also the
site's default language, still when users have English as their default browser
language, they will receive an English email.
