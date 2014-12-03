Introduction
------------

This package contains a Whois (RFC954) library for PHP. It allows
a PHP program to create a Whois object, and obtain the output of
a whois query with the Lookup function.

The response is an array containing, at least, an element 'rawdata',
containing the raw output from the whois request.

In addition, if the domain belongs to a registrar for which a special
handler exists, the special handler will parse the output and make
additional elements available in the response. The keys of these
additional elements are described in the file HANDLERS.

It fully supports IDNA (internationalized) domains names as
defined in RFC3490, RFC3491, RFC3492 and RFC3454.

It also supports ip/AS whois queries which are very useful to trace
SPAM. You just only need to pass the doted quad ip address or the
AS (Autonomus System) handle instead of the domain name. Limited,
non-recursive support for Referral Whois (RFC 1714/2167) is also
provided.

Requirements
------------

phpWhois requires PHP 5.4.x or better with OpenSSL support to
work properly. Without SSL support you will not be able to
query domains which do not have a whois server but that have
a https based whois. Also, you can run it in lower PHP versions
but without timeout control. phpWhois will not work with PHP
versions below 5.4.0!

Installation
------------

Since this is an unofficial fork of the phpwhois library, installation of this library must be done manually by clicking "Download Zip" to the top-right of the page that you are probably looking at.

Despite having to manually install this library, it has been made portable, so just drop src/ into whatever project you are working with and include phpwhois/whois.main.php.


Example usage
-------------

(see `tests/PhpwhoisTest.php`)
```php
require_once('src/phpwhois/whois.main.php');

$whois = new phpwhois\Whois();
$query = 'example.com';
$result = $whois->lookup($query,false);
echo "<pre>";
print_r($result);
echo "</pre>";
```
If you provide the domain name to query in UTF8, then you
must use:
```php
$result = $whois->lookup($query);
```
If the query string is not in UTF8 then it must be in
ISO-8859-1 or IDNA support will not work.

What you can query
------------------

You can use phpWhois to query domain names, ip addresses and
other information like AS, i.e, both of the following examples
work:
```php
$whois = new phpwhois\Whois();
$result = $whois->lookup('example.com');

$whois = new phpwhois\Whois();
$result = $whois->lookup('62.97.102.115');

$whois = new phpwhois\Whois();
$result = $whois->lookup('AS220');
```
Using special whois server
--------------------------

Some registrars can give special access to registered whois gateways
in order to have more fine control against abusing the whois services.
The currently known whois services that offer special acccess are:

### ripe

  The new ripe whois server software support some special parameters
  that allow to pass the real client ip address. This feature is only
  available to registered gateways. If you are registered you can use
  this service when querying ripe ip addresses that way:
  ```php
  $whois = new phpwhois\Whois();
  $whois->query->useServer('uk','whois.ripe.net?-V{version},{ip} {query}');
  $result = $whois->lookup('62.97.102.115');
  ```

### whois.isoc.org.il
  This server is also using the new ripe whois server software and
  thus works the same way. If you are registered you can use this service
  when querying `.il` domains that way:

```php
$whois = new phpwhois\Whois();
$whois->query->useServer('uk','whois.isoc.org.il?-V{version},{ip} {query}');
$result = $whois->lookup('example.co.uk');
```

### whois.nic.uk

  They offer what they call WHOIS2 (see http://www.nominet.org.uk/go/whois2 )
  to registered users (usually Nominet members) with a higher amount of
  permited queries by hour. If you are registered you can use this service
  when querying .uk domains that way:

```php
$whois = new phpwhois\Whois();
$whois->query->useServer('uk','whois.nic.uk:1043?{hname} {ip} {query}');
$result = $whois->lookup('example.co.uk');
```

This new feature also allows you to use a different whois server than
the preconfigured or discovered one by just calling whois->UseServer
and passing the tld and the server and args to use for the named tld.
For example you could use another whois server for `.au` domains that
does not limit the number of requests (but provides no owner 
information) using this:
```php
$whois = new phpwhois\Whois();
$whois->query->useServer('au','whois-check.ausregistry.net.au');
```
or:
```php
$whois = new phpwhois\Whois();
$whois->query->useServer('be','whois.tucows.com');
```

to avoid the restrictions imposed by the `.be` whois server

or:

```php
$whois = new phpwhois\Whois();
$whois->query->useServer('ip','whois.apnic.net');
```

to lookup an ip address at specific whois server (but losing the
ability to get the results parsed by the appropiate handler)

useServer can be called as many times as necessary. Please note that
if there is a handler for that domain it will also be called but
returned data from the whois server may be different than the data
expected by the handler, and thus results could be different.

Getting results faster
----------------------

If you just want to know if a domain is registered or not but do not
care about getting the real owner information you can set:

```php
$whois->query->deep_whois = false;
```

this will tell phpWhois to just query one whois server. For `.com`, `.net`
and `.tv` domains and ip addresses this will prevent phpWhois to ask more
than one whois server, you will just know if the donmain is registered
or not and which is the registrar but not the owner information.

UTF-8
-----

PHPWhois will assume that all whois servers return UTF-8 encoded output,
if some whois server does not return UTF-8 data, you can include it in
the `NON_UTF8` array in `src/phpwhois/whois/WhoisQuery.php`


Contributing
---------------

If you want to add support for new TLD, extend functionality or
correct a bug, fill free to create a new pull request on [Github's
repository @github.com](https://github.com/eVAL-Agency/phpwhois) or our [not-so-internal GIT tracker @git.eval.bz](https://git.eval.bz/eval/phpwhois).

Credits
-------

### [Original Team (1999-2011) @easyDNS](http://www.phpwhois.org)
* Mark Jeftovic &lt;<markjr@easydns.com>&gt;
* David Saez Padros &lt;<david@ols.es>&gt;
* Ross Golder &lt;<ross@golder.org>&gt;

### [Maintenance Work (2014) @lukashin](http://phpwhois.pw)
* Dmitry Lukashin &lt;<dmitry@lukashin.ru>&gt;

### [Code Refactor (2014) @eVAL Agency](http://eval.agency)
* Charlie Powell &lt;<charlie@evalagency.com>&gt;