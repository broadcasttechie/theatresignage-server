<?php
    $db = parse_url($_ENV['CLEARDB_DATABASE_URL']); 
    $container->setParameter('database_driver', 'pdo_mysql'); 
    $container->setParameter('database_host', $db['host']); 
    $container->setParameter('database_port', '~');
    $container->setParameter('database_name', trim($db['path'], '/')); 
    $container->setParameter('database_user', $db['user']); 
    $container->setParameter('database_password', $db['pass']);
    

    $container->setParameter('secret', getenv('SECRET'));
    $container->setParameter('locale', 'en');
    $container->setParameter('mailer_transport', null);
    $container->setParameter('mailer_host', null);
    $container->setParameter('mailer_user', null);
    $container->setParameter('mailer_password', null);