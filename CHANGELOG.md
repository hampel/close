CHANGELOG
=========

3.2.0 (2024-02-29)
------------------

* implement stricter typing and thus minimum php version 7.1
* require Carbon 2.x|3.x

3.1.0 (2021-09-27)
------------------

* breaking change: remove redundant addNote and rename addNoteObject to addNote to be consistent with other calls.
In summary: addNote still exists, but the signature has changed.

3.0.1 (2021-09-27)
------------------

* lead name isn't actually required - Close.com can handle an empty lead request. Also: if a contact is supplied when 
creating a lead, Close.com will use the contact name as a temporary lead name 

3.0.0 (2021-09-27)
------------------

* NOTE: backwards compatibility breaks in this version!
* re-wrote most classes to only specify required parameters in constructor and only output non-null values in array
* lots of new unit tests written for types

2.3.0 (2021-09-23)
------------------

* added psr-3 debug logging
* adjust dependencies - should be compatible with both carbon v1 and v2

2.2.0 (2021-09-22)
------------------

* updated getLead to accept a list of fields to retrieve
* new functions: getContact; updateContact; updateLead

2.1.0 (2021-09-21)
------------------

* add support for additional custom field types

2.0.2 (2021-06-09)
------------------

* bugfix - missing use clause

2.0.1 (2021-06-03)
------------------

* bugfix - catching the wrong exception

2.0.0 (2021-06-03)
------------------

* change namespace from CloseIo to Close
* change package name from hampel/closeio to hampel/close

1.0.1 (2016-05-16)
------------------

* remove tests from composer - not used yet

1.0.0 (2016-05-16)
------------------

* first release version

0.7.0 (2016-05-16)
------------------

* add task
* added function to add a note using the note activity object
* added getMe and getUser functions

0.6.0 (2016-04-01)
------------------

* added getCustomField function

0.5.0 (2015-12-14)
------------------

* added some static factory functions to EmailAddress and Activity/Email

0.4.2 (2015-12-10)
------------------

* fixed bad use clause in CloseIo

0.4.1 (2015-12-10)
------------------

* fixed bad use clause in Types/Lead/Lead

0.4.0 (2015-12-09)
------------------

* new functions queryEmails, queryEmailThreads, addEmail, plus updates to types

0.3.0 (2015-11-30)
------------------

* renamed getLeads to queryLeads; added getCustomFields function; added addNote function

0.2.0 (2015-11-26)
------------------

* implemented create lead (POST lead)

0.1.1 (2015-11-24)
------------------

* fix paths for repository

0.1.0 (2015-11-24)
------------------

* First version - get leads
