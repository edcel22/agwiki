Creating Messages
=================

Creating messages in Swift Mailer is done by making use of the various MIME
entities provided with the library. Complex messages can be quickly created
with very little effort.

Quick Reference
---------------

You can think of creating a Message as being similar to the steps you perform
when you click the Compose button in your mail client. You give it a subject,
specify some recipients, add any attachments and write your message::

    // Create the message
    $message = (new Swift_Message())

      // Give the message a subject
      ->setSubject('Your subject')

      // Set the From address with an associative array
      ->setFrom(['john@doe.com' => 'John Doe'])

      // Set the To addresses with an associative array (setTo/setCc/setBcc)
      ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])

      // Give it a body
      ->setBody('Here is the message itself')

      // And optionally an alternative body
      ->addPart('<q>Here is the message itself</q>', 'text/html')

      // Optionally add any attachments
      ->attach(Swift_Attachment::fromPath('my-document.pdf'))
      ;

Message Basics
--------------

A message is a container for anything you want to send to somebody else. There
are several basic aspects of a message that you should know.

An e-mail message is made up of several relatively simple entities that are
combined in different ways to achieve different results. All of these entities
have the same fundamental outline but serve a different purpose. The Message
itself can be defined as a MIME entity, an Attachment is a MIME entity, all
MIME parts are MIME entities -- and so on!

The basic units of each MIME entity -- be it the Message itself, or an
Attachment -- are its Headers and its body:

.. code-block:: text

    Header-Name: A header value
    Other-Header: Another value

    The body content itself

The Headers of a MIME entity, and its body must conform to some strict
standards defined by various RFC documents. Swift Mailer ensures that these
specifications are followed by using various types of object, including
Encoders and different Header types to generate the entity.

The Structure of a Message
~~~~~~~~~~~~~~~~~~~~~~~~~~

Of all of the MIME entities, a message -- ``Swift_Message`` is the largest and
most complex. It has many properties that can be updated and it can contain
other MIME entities -- attachments for example -- nested inside it.

A Message has a lot of different Headers which are there to present information
about the message to the recipients' mail client. Most of these headers will be
familiar to the majority of users, but we'll list the basic ones. Although it's
possible to work directly with the Headers of a Message (or other MIME entity),
the standard Headers have accessor methods provided to abstract away the
complex details for you. For example, although the Date on a message is written
with a strict format, you only need to pass a DateTimeInterface instance to
``setDate()``.

+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+
| Header                        | Description                                                                                                                        | Accessors                                   |
+===============================+====================================================================================================================================+=============================================+
| ``Message-ID``                | Identifies this message with a unique ID, usually containing the domain name and time generated                                    | ``getId()`` / ``setId()``                   |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+
| ``Return-Path``               | Specifies where bounces should go (Swift Mailer reads this for other uses)                                                         | ``getReturnPath()`` / ``setReturnPath()``   |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+
| ``From``                      | Specifies the address of the person who the message is from. This can be multiple addresses if multiple people wrote the message.  | ``getFrom()`` / ``setFrom()``               |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+
| ``Sender``                    | Specifies the address of the person who physically sent the message (higher precedence than ``From:``)                             | ``getSender()`` / ``setSender()``           |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+
| ``To``                        | Specifies the addresses of the intended recipients                                                                                 | ``getTo()`` / ``setTo()``                   |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+
| ``Cc``                        | Specifies the addresses of recipients who will be copied in on the message                                                         | ``getCc()`` / ``setCc()``                   |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+
| ``Bcc``                       | Specifies the addresses of recipients who the message will be blind-copied to. Other recipients will not be aware of these copies. | ``getBcc()`` / ``setBcc()``                 |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+
| ``Reply-To``                  | Specifies the address where replies are sent to                                                                                    | ``getReplyTo()`` / ``setReplyTo()``         |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+
| ``Subject``                   | Specifies the subject line that is displayed in the recipients' mail client                                                        | ``getSubject()`` / ``setSubject()``         |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+
| ``Date``                      | Specifies the date at which the message was sent                                                                                   | ``getDate()`` / ``setDate()``               |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+
| ``Content-Type``              | Specifies the format of the message (usually ``text/plain`` or ``text/html``)                                                      | ``getContentType()`` / ``setContentType()`` |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+
| ``Content-Transfer-Encoding`` | Specifies the encoding scheme in the message                                                                                       | ``getEncoder()`` / ``setEncoder()``         |
+-------------------------------+------------------------------------------------------------------------------------------------------------------------------------+---------------------------------------------+

Working with a Message Object
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Although there are a lot of available methods on a message object, you only
need to make use of a small subset of them. Usually you'll use
``setSubject()``, ``setTo()`` and ``setFrom()`` before setting the body of your
message with ``setBody()``::

    $message = new Swift_Message();
    $message->setSubject('My subject');

All MIME entities (including a message) have a ``toString()`` method that you
can call if you want to take a look at what is going to be sent. For example,
if you ``echo $message->toString();`` you would see something like this:

.. code-block:: text

    Message-ID: <1230173678.4952f5eeb1432@swift.generated>
    Date: Thu, 25 Dec 2008 13:54:38 +1100
    Subject: Example subject
    From: Chris Corbyn <chris@w3style.co.uk>
    To: Receiver Name <recipient@example.org>
    MIME-Version: 1.0
    Content-Type: text/plain; charset=utf-8
    Content-Transfer-Encoding: quoted-printable

    Here is the message

We'll take a closer look at the methods you use to create your message in the
following sections.

Adding Content to Your Message
------------------------------

Rich content can be added to messages in Swift Mailer with relative ease by
calling methods such as ``setSubject()``, ``setBody()``, ``addPart()`` and
``attach()``.

Setting the Subject Line
~~~~~~~~~~~~~~~~~~~~~~~~

The subject line, displayed in the recipients' mail client can be set with the
``setSubject()`` method, or as a parameter to ``new Swift_Message()``::

    // Pass it as a parameter when you create the message
    $message = new Swift_Message('My amazing subject');

    // Or set it after like this
    $message->setSubject('My amazing subject');

Setting the Body Content
~~~~~~~~~~~~~~~~~~~~~~~~

The body of the message -- seen when the user opens the message -- is specified
by calling the ``setBody()`` method. If an alternative body is to be included,
``addPart()`` can be used.

The body of a message is the main part that is read by the user. Often people
want to send a message in HTML format (``text/html``), other times people want
to send in plain text (``text/plain``), or sometimes people want to send both
versions and allow the recipient to choose how they view the message.

As a rule of thumb, if you're going to send a HTML email, always include a
plain-text equivalent of the same content so that users who prefer to read
plain text can do so.

If the recipient's mail client offers preferences for displaying text vs. HTML
then the mail client will present that part to the user where available. In
other cases the mail client will display the "best" part it can - usually HTML
if you've included HTML::

    // Pass it as a parameter when you create the message
    $message = new Swift_Message('Subject here', 'My amazing body');

    // Or set it after like this
    $message->setBody('My <em>amazing</em> body', 'text/html');

    // Add alternative parts with addPart()
    $message->addPart('My amazing body in plain text', 'text/plain');

Attaching Files
---------------

Attachments are downloadable parts of a message and can be added by calling the
``attach()`` method on the message. You can add attachments that exist on disk,
or you can create attachments on-the-fly.

Although we refer to files sent over e-mails as "attachments" -- because
they're attached to the message -- lots of other parts of the message are
actually "attached" even if we don't refer to these parts as attachments.

File attachments are created by the ``Swift_Attachment`` class and then
attached to the message via the ``attach()`` method on it. For all of the
"every day" MIME types such as all image formats, word documents, PDFs and
spreadsheets you don't need to explicitly set the content-type of the
attachment, though it would do no harm to do so. For less common formats you
should set the content-type -- which we'll cover in a moment.

Attaching Existing Files
~~~~~~~~~~~~~~~~~~~~~~~~

Files that already exist, either on disk or at a URL can be attached to a
message with just one line of code, using ``Swift_Attachment::fromPath()``.

You can attach files that exist locally, or if your PHP installation has
``allow_url_fopen`` turned on you can attach files from other
websites.

The attachment will be presented to the recipient as a downloadable file with
the same filename as the one you attached::

    // Create the attachment
    // * Note that you can technically leave the content-type parameter out
    $attachment = Swift_Attachment::fromPath('/path/to/image.jpg', 'image/jpeg');

    // Attach it to the message
    $message->attach($attachment);

    // The two statements above could be written in one line instead
    $message->attach(Swift_Attachment::fromPath('/path/to/image.jpg'));

    // You can attach files from a URL if allow_url_fopen is on in php.ini
    $message->attach(Swift_Attachment::fromPath('https://site.tld/logo.png'));

Setting the Filename
~~~~~~~~~~~~~~~~~~~~

Usually you don't need to explicitly set the filename of an attachment because
the name of the attached file will be used by default, but if you want to set
the filename you use the ``setFilename()`` method of the Attachment.

The attachment will be attached in the normal way, but meta-data sent inside
the email will rename the file to something else::

    // Create the attachment and call its setFilename() method
    $attachment = Swift_Attachment::fromPath('/path/to/image.jpg')
      ->setFilename('cool.jpg');

    // Because there's a fluid interface, you can do this in one statement
    $message->attach(
      Swift_Attachment::fromPath('/path/to/image.jpg')->setFilename('cool.jpg')
    );

Attaching Dynamic Content
~~~~~~~~~~~~~~~~~~~~~~~~~

Files that are generated at runtime, such as PDF documents or images created
via GD can be attached directly to a message without writing them out to disk.
Use ``Swift_Attachment`` directly.

The attachment will be presented to the recipient as a downloadable file
with the filename and content-type you specify::

    // Create your file contents in the normal way, but don't write them to disk
    $data = create_my_pdf_data();

    // Create the attachment with your data
    $attachment = new Swift_Attachment($data, 'my-file.pdf', 'application/pdf');

    // Attach it to the message
    $message->attach($attachment);


    // You can alternatively use method chaining to build the attachment
    $attachment = (new Swift_Attachment())
      ->setFilename('my-file.pdf')
      ->setContentType('application/pdf')
      ->setBody($data)
      ;

.. note::

    If you would usually write the file to disk anyway you should just attach
    it with ``Swift_Attachment::fromPath()`` since this will use less memory.

Changing the Disposition
~~~~~~~~~~~~~~~~~~~~~~~~

Attachments just appear as files that can be saved to the Desktop if desired.
You can make attachment appear inline where possible by using the
``setDisposition()`` method of an attachment.

The attachment will be displayed within the email viewing window if the mail
client knows how to display it::

    // Create the attachment and call its setDisposition() method
    $attachment = Swift_Attachment::fromPath('/path/to/image.jpg')
      ->setDisposition('inline');


    // Because there's a fluid interface, you can do this in one statement
    $message->attach(
      Swift_Attachment::fromPath('/path/to/image.jpg')->setDisposition('inline')
    );

.. note::

    If you try to create an inline attachment for a non-displayable file type
    such as a ZIP file, the mail client should just present the attachment as
    normal.

Embedding Inline Media Files
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Often, people want to include an image or other content inline with a HTML
message. It's easy to do this with HTML linking to remote resources, but this
approach is usually blocked by mail clients. Swift Mailer allows you to embed
your media directly into the message.

Mail clients usually block downloads from remote resources because this
technique was often abused as a mean of tracking who opened an email. If
you're sending a HTML email and you want to include an image in the message
another approach you can take is to embed the image directly.

Swift Mailer makes embedding files into messages extremely streamlined. You
embed a file by calling the ``embed()`` method of the message,
which returns a value you can use in a ``src`` or
``href`` attribute in your HTML.

Just like with attachments, it's possible to embed dynamically generated
content without having an existing file available.

The embedded files are sent in the email as a special type of attachment that
has a unique ID used to reference them within your HTML attributes. On mail
clients that do not support embedded files they may appear as attachments.

Although this is commonly done for images, in theory it will work for any
displayable (or playable) media type. Support for other media types (such as
video) is dependent on the mail client however.

Embedding Existing Files
........................

Files that already exist, either on disk or at a URL can be embedded in a
message with just one line of code, using ``Swift_EmbeddedFile::fromPath()``.

You can embed files that exist locally, or if your PHP installation has
``allow_url_fopen`` turned on you can embed files from other websites.

The file will be displayed with the message inline with the HTML wherever its ID
is used as a ``src`` attribute::

    // Create the message
    $message = new Swift_Message('My subject');

    // Set the body
    $message->setBody(
    '<html>' .
    ' <body>' .
    '  Here is an image <img src="' . // Embed the file
         $message->embed(Swift_Image::fromPath('image.png')) .
       '" alt="Image" />' .
    '  Rest of message' .
    ' </body>' .
    '</html>',
      'text/html' // Mark the content-type as HTML
    );

    // You can embed files from a URL if allow_url_fopen is on in php.ini
    $message->setBody(
    '<html>' .
    ' <body>' .
    '  Here is an image <img src="' .
         $message->embed(Swift_Image::fromPath('https://site.tld/logo.png')) .
       '" alt="Image" />' .
    '  Rest of message' .
    ' </body>' .
    '</html>',
      'text/html'
    );

.. note::

    ``Swift_Image`` and ``Swift_EmbeddedFile`` are just aliases of one another.
    ``Swift_Image`` exists for semantic purposes.

.. note::

    You can embed files in two stages if you prefer. Just capture the return
    value of ``embed()`` in a variable and use that as the ``src`` attribute::

        // If placing the embed() code inline becomes cumbersome
        // it's easy to do this in two steps
        $cid = $message->embed(Swift_Image::fromPath('image.png'));

        $message->setBody(
        '<html>' .
        ' <body>' .
        '  Here is an image <img src="' . $cid . '" alt="Image" />' .
        '  Rest of message' .
        ' </body>' .
        '</html>',
          'text/html' // Mark the content-type as HTML
        );

Embedding Dynamic Content
.........................

Images that are generated at runtime, such as images created via GD can be
embedded directly to a message without writing them out to disk. Use the
standard ``new Swift_Image()`` method.

The file will be displayed with the message inline with the HTML wherever its ID
is used as a ``src`` attribute::

    // Create your file contents in the normal way, but don't write them to disk
    $img_data = create_my_image_data();

    // Create the message
    $message = new Swift_Message('My subject');

    // Set the body
    $message->setBody(
    '<html>' .
    ' <body>' .
    '  Here is an image <img src="' . // Embed the file
         $message->embed(new Swift_Image($img_data, 'image.jpg', 'image/jpeg')) .
       '" alt="Image" />' .
    '  Rest of message' .
    ' </body>' .
    '</html>',
      'text/html' // Mark the content-type as HTML
    );

.. note::

    ``Swift_Image`` and ``Swift_EmbeddedFile`` are just aliases of one another.
    ``Swift_Image`` exists for semantic purposes.

.. note::

    You can embed files in two stages if you prefer. Just capture the return
    value of ``embed()`` in a variable and use that as the ``src`` attribute::

        // If placing the embed() code inline becomes cumbersome
        // it's easy to do this in two steps
        $cid = $message->embed(new Swift_Image($img_data, 'image.jpg', 'image/jpeg'));

        $message->setBody(
        '<html>' .
        ' <body>' .
        '  Here is an image <img src="' . $cid . '" alt="Image" />' .
        '  Rest of message' .
        ' </body>' .
        '</html>',
          'text/html' // Mark the content-type as HTML
        );

Adding Recipients to Your Message
---------------------------------

Recipients are specified within the message itself via ``setTo()``, ``setCc()``
and ``setBcc()``. Swift Mailer reads these recipients from the message when it
gets sent so that it knows where to send the message to.

Message recipients are one of three types:

* ``To:`` recipients -- the primary recipients (required)

* ``Cc:`` recipients -- receive a copy of the message (optional)

* ``Bcc:`` recipients -- hidden from other recipients (optional)

Each type can contain one, or several addresses. It's possible to list only the
addresses of the recipients, or you can personalize the address by providing
the real name of the recipient.

Make sure to add only valid email addresses as recipients. If you try to add an
invalid email address with ``setTo()``, ``setCc()`` or ``setBcc()``, Swift
Mailer will throw a ``Swift_RfcComplianceException``.

If you add recipients automatically based on a data source that may contain
invalid email addresses, you can prevent possible exceptions by validating the
addresses using::

    use Egulias\EmailValidator\EmailValidator;
    use Egulias\EmailValidator\Validation\RFCValidation;

    $validator = new EmailValidator();
    $validator->isValid("example@example.com", new RFCValidation()); //true

and only adding addresses that validate. Another way would be to wrap your ``setTo()``, ``setCc()`` and
``setBcc()`` calls in a try-catch block and handle the
``Swift_RfcComplianceException`` in the catch block.

.. sidebar:: Syntax for Addresses

    If you only wish to refer to a single email address (for example your
    ``From:`` address) then you can just use a string::

          $message->setFrom('some@address.tld');

    If you want to include a name then you must use an associative array::

         $message->setFrom(['some@address.tld' => 'The Name']);

    If you want to include multiple addresses then you must use an array::

         $message->setTo(['some@address.tld', 'other@address.tld']);

    You can mix personalized (addresses with a name) and non-personalized
    addresses in the same list by mixing the use of associative and
    non-associative array syntax::

         $message->setTo([
           'recipient-with-name@example.org' => 'Recipient Name One',
           'no-name@example.org', // Note that this is not a key-value pair
           'named-recipient@example.org' => 'Recipient Name Two'
         ]);

Setting ``To:`` Recipients
~~~~~~~~~~~~~~~~~~~~~~~~~~

``To:`` recipients are required in a message and are set with the ``setTo()``
or ``addTo()`` methods of the message.

To set ``To:`` recipients, create the message object using either ``new
Swift_Message( ... )``, then call the ``setTo()`` method with a complete array
of addresses, or use the ``addTo()`` method to iteratively add recipients.

The ``setTo()`` method accepts input in various formats as described earlier in
this chapter. The ``addTo()`` method takes either one or two parameters. The
first being the email address and the second optional parameter being the name
of the recipient.

``To:`` recipients are visible in the message headers and will be seen by the
other recipients::

    // Using setTo() to set all recipients in one go
    $message->setTo([
      'person1@example.org',
      'person2@otherdomain.org' => 'Person 2 Name',
      'person3@example.org',
      'person4@example.org',
      'person5@example.org' => 'Person 5 Name'
    ]);

.. note::

    Multiple calls to ``setTo()`` will not add new recipients -- each
    call overrides the previous calls. If you want to iteratively add
    recipients, use the ``addTo()`` method::

        // Using addTo() to add recipients iteratively
        $message->addTo('person1@example.org');
        $message->addTo('person2@example.org', 'Person 2 Name');

Setting ``Cc:`` Recipients
~~~~~~~~~~~~~~~~~~~~~~~~~~

``Cc:`` recipients are set with the ``setCc()`` or ``addCc()`` methods of the
message.

To set ``Cc:`` recipients, create the message object using either ``new
Swift_Message( ... )``, then call the ``setCc()`` method with a complete array
of addresses, or use the ``addCc()`` method to iteratively add recipients.

The ``setCc()`` method accepts input in various formats as described earlier in
this chapter. The ``addCc()`` method takes either one or two parameters. The
first being the email address and the second optional parameter being the name
of the recipient.

``Cc:`` recipients are visible in the message headers and will be seen by the
other recipients::

    // Using setTo() to set all recipients in one go
    $message->setTo([
      'person1@example.org',
      'person2@otherdomain.org' => 'Person 2 Name',
      'person3@example.org',
      'person4@example.org',
      'person5@example.org' => 'Person 5 Name'
    ]);

.. note::

    Multiple calls to ``setCc()`` will not add new recipients -- each call
    overrides the previous calls. If you want to iteratively add Cc:
    recipients, use the ``addCc()`` method::

        // Using addCc() to add recipients iteratively
        $message->addCc('person1@example.org');
        $message->addCc('person2@example.org', 'Person 2 Name');

Setting ``Bcc:`` Recipients
~~~~~~~~~~~~~~~~~~~~~~~~~~~

``Bcc:`` recipients receive a copy of the message without anybody else knowing
it, and are set with the ``setBcc()`` or ``addBcc()`` methods of the message.

To set ``Bcc:`` recipients, create the message object using either ``new
Swift_Message( ... )``, then call the ``setBcc()`` method with a complete array
of addresses, or use the ``addBcc()`` method to iteratively add recipients.

The ``setBcc()`` method accepts input in various formats as described earlier
in this chapter. The ``addBcc()`` method takes either one or two parameters.
The first being the email address and the second optional parameter being the
name of the recipient.

Only the individual ``Bcc:`` recipient will see their address in the message
headers. Other recipients (including other ``Bcc:`` recipients) will not see
the address::

    // Using setBcc() to set all recipients in one go
    $message->setBcc([
      'person1@example.org',
      'person2@otherdomain.org' => 'Person 2 Name',
      'person3@example.org',
      'person4@example.org',
      'person5@example.org' => 'Person 5 Name'
    ]);

.. note::

    Multiple calls to ``setBcc()`` will not add new recipients -- each call
    overrides the previous calls. If you want to iteratively add Bcc:
    recipients, use the ``addBcc()`` method::

        // Using addBcc() to add recipients iteratively
        $message->addBcc('person1@example.org');
        $message->addBcc('person2@example.org', 'Person 2 Name');

.. sidebar:: Internationalized Email Addresses

    Traditionally only ASCII characters have been allowed in email addresses.
    With the introduction of internationalized domain names (IDNs), non-ASCII
    characters may appear in the domain name. By default, Swiftmailer encodes
    such domain names in Punycode (e.g. xn--xample-ova.invalid). This is
    compatible with all mail servers.

    RFC 6531 introduced an SMTP extension, SMTPUTF8, that allows non-ASCII
    characters in email addresses on both sides of the @ sign. To send to such
    addresses, your outbound SMTP server must support the SMTPUTF8 extension.
    You should use the ``Swift_AddressEncoder_Utf8AddressEncoder`` address
    encoder and enable the ``Swift_Transport_Esmtp_SmtpUtf8Handler`` SMTP
    extension handler::

        $smtpUtf8 = new Swift_Transport_Esmtp_SmtpUtf8Handler();
        $transport->setExtensionHandlers([$smtpUtf8]);
        $utf8Encoder = new Swift_AddressEncoder_Utf8AddressEncoder();
        $transport->setAddressEncoder($utf8Encoder);

Specifying Sender Details
-------------------------

An email must include information about who sent it. Usually this is managed by
the ``From:`` address, however there are other options.

The sender information is contained in three possible places:

* ``From:`` -- the address(es) of who wrote the message (required)

* ``Sender:`` -- the address of the single person who sent the message
  (optional)

* ``Return-Path:`` -- the address where bounces should go to (optional)

You must always include a ``From:`` address by using ``setFrom()`` on the
message. Swift Mailer will use this as the default ``Return-Path:`` unless
otherwise specified.

The ``Sender:`` address exists because the person who actually sent the email
may not be the person who wrote the email. It has a higher precedence than the
``From:`` address and will be used as the ``Return-Path:`` unless otherwise
specified.

Setting the ``From:`` Address
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

A ``From:`` address is required and is set with the ``setFrom()`` method of the
message. ``From:`` addresses specify who actually wrote the email, and usually
who sent it.

What most people probably don't realize is that you can have more than one
``From:`` address if more than one person wrote the email -- for example if an
email was put together by a committee.

The ``From:`` address(es) are visible in the message headers and will be seen
by the recipients.

.. note::

    If you set multiple ``From:`` addresses then you absolutely must set a
    ``Sender:`` address to indicate who physically sent the message.

::

    // Set a single From: address
    $message->setFrom('your@address.tld');

    // Set a From: address including a name
    $message->setFrom(['your@address.tld' => 'Your Name']);

    // Set multiple From: addresses if multiple people wrote the email
    $message->setFrom([
      'person1@example.org' => 'Sender One',
      'person2@example.org' => 'Sender Two'
    ]);

Setting the ``Sender:`` Address
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

A ``Sender:`` address specifies who sent the message and is set with the
``setSender()`` method of the message.

The ``Sender:`` address is visible in the message headers and will be seen by
the recipients.

This address will be used as the ``Return-Path:`` unless otherwise specified.

.. note::

    If you set multiple ``From:`` addresses then you absolutely must set a
    ``Sender:`` address to indicate who physically sent the message.

You must not set more than one sender address on a message because it's not
possible for more than one person to send a single message::

    $message->setSender('your@address.tld');

Setting the ``Return-Path:`` (Bounce) Address
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The ``Return-Path:`` address specifies where bounce notifications should be
sent and is set with the ``setReturnPath()`` method of the message.

You can only have one ``Return-Path:`` and it must not include a personal name.

Bounce notifications will be sent to this address::

    $message->setReturnPath('bounces@address.tld');

Signed/Encrypted Message
------------------------

To increase the integrity/security of a message it is possible to sign and/or
encrypt an message using one or multiple signers.

S/MIME
~~~~~~

S/MIME can sign and/or encrypt a message using the OpenSSL extension.

When signing a message, the signer creates a signature of the entire content of
the message (including attachments).

The certificate and private key must be PEM encoded, and can be either created
using for example OpenSSL or obtained at an official Certificate Authority (CA).

**The recipient must have the CA certificate in the list of trusted issuers in
order to verify the signature.**

**Make sure the certificate supports emailProtection.**

When using OpenSSL this can done by the including the *-addtrust
emailProtection* parameter when creating the certificate::

    $message = new Swift_Message();

    $smimeSigner = new Swift_Signers_SMimeSigner();
    $smimeSigner->setSignCertificate('/path/to/certificate.pem', '/path/to/private-key.pem');
    $message->attachSigner($smimeSigner);

When the private key is secured using a passphrase use the following instead::

    $message = new Swift_Message();

    $smimeSigner = new Swift_Signers_SMimeSigner();
    $smimeSigner->setSignCertificate('/path/to/certificate.pem', ['/path/to/private-key.pem', 'passphrase']);
    $message->attachSigner($smimeSigner);

By default the signature is added as attachment, making the message still
readable for mailing agents not supporting signed messages.

Storing the message as binary is also possible but not recommended::

    $smimeSigner->setSignCertificate('/path/to/certificate.pem', '/path/to/private-key.pem', PKCS7_BINARY);

When encrypting the message (also known as enveloping), the entire message
(including attachments) is encrypted using a certificate, and the recipient can
then decrypt the message using corresponding private key.

Encrypting ensures nobody can read the contents of the message without the
private key.

Normally the recipient provides a certificate for encrypting and keeping the
decryption key private.

Using both signing and encrypting is also possible::

    $message = new Swift_Message();

    $smimeSigner = new Swift_Signers_SMimeSigner();
    $smimeSigner->setSignCertificate('/path/to/sign-certificate.pem', '/path/to/private-key.pem');
    $smimeSigner->setEncryptCertificate('/path/to/encrypt-certificate.pem');
    $message->attachSigner($smimeSigner);

The used encryption cipher can be set as the second parameter of
setEncryptCertificate()

See https://secure.php.net/manual/openssl.ciphers for a list of supported ciphers.

By default the message is first signed and then encrypted, this can be changed
by adding::

    $smimeSigner->setSignThenEncrypt(false);

**Changing this is not recommended as most mail agents don't support this
none-standard way.**

Only when having trouble with sign then encrypt method, this should be changed.

Requesting a Read Receipt
-------------------------

It is possible to request a read-receipt to be sent to an address when the
email is opened. To request a read receipt set the address with
``setReadReceiptTo()``::

    $message->setReadReceiptTo('your@address.tld');

When the email is opened, if the mail client supports it a notification will be
sent to this address.

.. note::

    Read receipts won't work for the majority of recipients since many mail
    clients auto-disable them. Those clients that will send a read receipt
    will make the user aware that one has been requested.

Setting the Character Set
-------------------------

The character set of the message (and its MIME parts) is set with the
``setCharset()`` method. You can also change the global default of UTF-8 by
working with the ``Swift_Preferences`` class.

Swift Mailer will default to the UTF-8 character set unless otherwise
overridden. UTF-8 will work in most instances since it includes all of the
standard US keyboard characters in addition to most international characters.

It is absolutely vital however that you know what character set your message
(or it's MIME parts) are written in otherwise your message may be received
completely garbled.

There are two places in Swift Mailer where you can change the character set:

* In the ``Swift_Preferences`` class

* On each individual message and/or MIME part

To set the character set of your Message:

* Change the global UTF-8 setting by calling
  ``Swift_Preferences::setCharset()``; or

* Call the ``setCharset()`` method on the message or the MIME part::

    // Approach 1: Change the global setting (suggested)
    Swift_Preferences::getInstance()->setCharset('iso-8859-2');

    // Approach 2: Call the setCharset() method of the message
    $message = (new Swift_Message())
      ->setCharset('iso-8859-2');

    // Approach 3: Specify the charset when setting the body
    $message->setBody('My body', 'text/html', 'iso-8859-2');

    // Approach 4: Specify the charset for each part added
    $message->addPart('My part', 'text/plain', 'iso-8859-2');

Setting the Encoding
--------------------

The body of each MIME part needs to be encoded. Binary attachments are encoded
in base64 using the ``Swift_Mime_ContentEncoder_Base64ContentEncoder``. Text
parts are traditionally encoded in quoted-printable using
``Swift_Mime_ContentEncoder_QpContentEncoder`` or
``Swift_Mime_ContentEncoder_NativeQpContentEncoder``.

The encoder of the message or MIME part is set with the ``setEncoder()`` method.

Quoted-printable is the safe choice, because it converts 8-bit text as 7-bit.
Most modern SMTP servers support 8-bit text. This is advertised via the 8BITMIME
SMTP extension. If your outbound SMTP server supports this SMTP extension, and
it supports downgrading the message (e.g converting to quoted-printable on the
fly) when delivering to a downstream server that does not support the extension,
you may wish to use ``Swift_Mime_ContentEncoder_PlainContentEncoder`` in
``8bit`` mode instead. This has the advantage that the source data is slightly
more readable and compact, especially for non-Western languages.

        $eightBitMime = new Swift_Transport_Esmtp_EightBitMimeHandler();
        $transport->setExtensionHandlers([$eightBitMime]);
        $plainEncoder = new Swift_Mime_ContentEncoder_PlainContentEncoder('8bit');
        $message->setEncoder($plainEncoder);

Setting the Line Length
-----------------------

The length of lines in a message can be changed by using the
``setMaxLineLength()`` method on the message::

    $message->setMaxLineLength(1000);

Swift Mailer defaults to using 78 characters per line in a message. This is
done for historical reasons and so that the message can be easily viewed in
plain-text terminals

Lines that are longer than the line length specified will be wrapped between
words.

.. note::

    You should never set a maximum length longer than 1000 characters
    according to RFC 2822. Doing so could have unspecified side-effects such
    as truncating parts of your message when it is transported between SMTP
    servers.

Setting the Message Priority
----------------------------

You can change the priority of the message with ``setPriority()``. Setting the
priority will not change the way your email is sent -- it is purely an
indicative setting for the recipient::

    // Indicate "High" priority
    $message->setPriority(2);

The priority of a message is an indication to the recipient what significance
it has. Swift Mailer allows you to set the priority by calling the
``setPriority`` method. This method takes an integer value between 1 and 5:

* ``Swift_Mime_SimpleMessage::PRIORITY_HIGHEST``: 1
* ``Swift_Mime_SimpleMessage::PRIORITY_HIGH``: 2
* ``Swift_Mime_SimpleMessage::PRIORITY_NORMAL``: 3
* ``Swift_Mime_SimpleMessage::PRIORITY_LOW``: 4
* ``Swift_Mime_SimpleMessage::PRIORITY_LOWEST``: 5

::

    // Or use the constant to be more explicit
    $message->setPriority(Swift_Mime_SimpleMessage::PRIORITY_HIGH);
