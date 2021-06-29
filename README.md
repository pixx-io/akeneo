# Pixxio connector for Akeneo5 Community

This Bundle provides integration for the pixx.io DAM into the Akeneo 5 CE.

## Installation
For installing the Bundle use the composer installation

```bash
docker-compose run -u www-data --rm php php -d memory_limit=4G /usr/local/bin/composer require "flagbit/akeneo-pixxio-connector"
```

Register the bundle in the `config/bundles.php`
```php
return [
    \Flagbit\PixxioConnector\PixxioConnectorBundle::class => ['dev' => true, 'test' => true, 'prod' => true],
];
```

And register the route for the config settings in the `config/routes/routes.yml` (if there is no file/directory, then create it)
```yml
flagbit_pixxio_internal_api:
    resource: '@PixxioConnectorBundle/Resources/config/routing.yml'
```

For the last file edit the `.env` file and add your pixxio configuration to it
```
PIXXIO_KEY=yourPixxioKey
PIXXIO_URL=https://yourPixxioUrl
PIXXIO_OLD_VERSION=true
```
Unless told otherwise the `PIXXIO_OLD_VERSION` flag will indicate the v1 version when set to true

After that, clear cache and rebuild the frontend
```bash
make cache #upgrade-front should do it also but to be sure just clear it
make upgrade-front
```

Once done that the system is ready to use the new attribute type.

## Usage
