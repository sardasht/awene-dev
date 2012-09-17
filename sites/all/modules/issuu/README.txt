
= Issuu integration =

== Summary ==

This module will let you interact with issuu.com
API(http://issuu.com/services/api/) through a drupal interface using CCK.

It is inspired on imagefield and scribdfield interaction with filefield.

This module is in early development.

=== Features ===

* Upload documents to issuu.com using filefield for manage upload and an
own cck widget.
* Two CCK formatters to show an issuu document as: page flip and
thumbnail.

To submit bug reports and feature suggestions, or to track changes:
  http://drupal.org/project/issues/issuu

== Requirements ==

* PHP extensions:
** PHP cURL extension: http://curl.haxx.se/libcurl/php/
* Drupal modules:
** content: http://drupal.org/project/cck
** filefield: http://drupal.org/project/filefield
** swftools: http://drupal.org/project/swftools

== Instalation ==

* Install as usual, see http://drupal.org/node/70151 for further
information.

== Configuration ==

* Configure permissions in Administer >> User management >> Permissions
>> issuu module:
** administer global issuu integration
+
Users in roles with the 'administer global issuu integration' permission
will be able to change the API key and secret to interat with issuu.com
+
* Configure your API key and secret from your issuu.com account on
Administer >> Site configuration >> Issuu Global settings. You can apply
for an API account on
http://issuu.com/user/settings?services=true#services
* Add a new filefield field as usual on Administer >> Content types >>
manage fields choosing the Issuu widget.

== Contact ==

Current maintainers:

* Marco Villegas (marvil07) - http://drupal.org/user/132175
