API Bundle Readme
=================

This bundle supports Gastro API's functionality, specified and used
by desktop and mobile apps, written by wwsh.

For more information contact Thomas Parys at [this site](http://wwsh.io).

Configuration
-------------

Enable Doctrine ORM in your mail config.yml and add the configuration for FOSRestBundle, listed below:

    fos_rest:
        param_fetcher_listener: true
        body_listener: true
        body_converter:
            enabled: true
        format_listener:
            rules:
                - { path: '^/api', priorities: [ json ], fallback_format: json, prefer_extension: true }
                - { path: '^/', priorities: [html, json], fallback_format: html, prefer_extension: false }
        view:
            view_response_listener: 'true'
            mime_types: ['application/json', 'application/json;version=1.0', 'application/json;version=1.1']
            formats:
              json: true
              html: false
              xml:  false
        routing_loader:
            default_format: json
            include_format: false
        exception:
            codes:
                'Symfony\Component\Routing\Exception\ResourceNotFoundException': 404
                'Doctrine\ORM\OptimisticLockException': HTTP_CONFLICT
            messages:
                'Symfony\Component\Routing\Exception\ResourceNotFoundException': true
        access_denied_listener:
            json: true

Don't forget to enable these bundles in the kernel:

            new \FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new \Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),

Now it's time to include the routes in your routing.yml:

            api:
                resource: "@ApiBundle/Resources/config/routing.yml"
                type:     rest
                prefix:   /api

You can customize your prefix, but I am recommending to use the standard one.

Now the api should be set. To create the database schema and fill will example data, you can use:

    php bin/console database:create
    php bin/console doctrine:schema:create
    php bin/console doctrine:fixtures:load

See if your API is working here: [API DOC](//api/doc)

On any questions, feel free to ask.