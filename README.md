# Pixxio connector for Akeneo5 Community

This Bundle provides integration for the pixx.io DAM into the Akeneo 5 CE.

## Installation
For installing the Bundle use the composer installation

```bash
docker-compose run -u www-data --rm php php -d memory_limit=4G /usr/local/bin/composer require "pixxio/akeneo-pixxio-connector"
```

Register the bundle in the `config/bundles.php`
```php
return [
    \Pixxio\PixxioConnector\PixxioConnectorBundle::class => ['dev' => true, 'test' => true, 'prod' => true],
];
```

And register the route for the config settings in the `config/routes/routes.yml` (if there is no file/directory, then create it)
```yml
pixxio_pixxio_internal_api:
    resource: '@PixxioConnectorBundle/Resources/config/routing.yml'
```

For the last file edit the `.env.local` file and add your pixxio configuration to it
```
PIXXIO_KEY=yourPixxioKey
PIXXIO_URL=https://yourPixxioUrl
PIXXIO_OLD_VERSION=true
```
Unless told otherwise the `PIXXIO_OLD_VERSION` flag will indicate the v1 version when set to true

This bundle is overriding the server's [CSP headers](https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP) by default in `\Pixxio\PixxioConnector\EventListener\AddContentSecurityPolicyListener`, which might be unwanted in case of your own security configurations. If you have your own **CSP configuration** you can disable the ones provided by setting the `PIXXIO_CSP=false` variable in your `.env.local`. Make sure you enable Akeneo to connect to the Pixx.io servers, because otherwhise the connection to Pixx.io won't work anymore.

After that, clear cache and rebuild the frontend
```bash
make cache #upgrade-front should do it also but to be sure just clear it
make upgrade-front
```

Once done that the system is ready to use the new attribute type.

## Usage

See the [user guides](../master/doc)
