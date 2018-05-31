# sylius-mail-bundle
Configure how your emails are sent by Sylius

# Installation-procedure
```bash
$ composer require behappy/mail-plugin
```

## Enable the plugin

```php
// in app/AppKernel.php
public function registerBundles() {
	$bundles = array(
		// ...
		new BeHappy\SyliusMailPlugin\BeHappySyliusMailPlugin,
	);
	// ...
}
```

```yml
#in app/config/config.yml
imports:
    ...
    - { resource: "@BeHappySyliusMailPlugin/Resources/config/app/config.yml" }
```

```yml
# in routing.yml
...

behappy_mail_plugin:
    resource: '@BeHappySyliusMailPlugin/Resources/config/routing.yml'
...
```


# That's it !
In the BackOffice, you have now a new entry under the configuration menu where you can create your mail configuration. You can register one configuration by channel.

/!\ At this moment, SMTP mode isn't tested.

You can define the user sending address, their name and a reply-to.

DKIM Signature is also fully supported by setting the domain, the selector and the private key content.

Once your configuration is created, you can send a test email to any address and check the result. (don't forget do enable delivery in dev by modifying config_dev.yml)

# Feel free to contribute
You can also ask your questions at the mail address in the composer.json mentioning this package.