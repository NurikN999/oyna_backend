<?php return array(
    'root' => array(
        'name' => '__root__',
        'pretty_version' => 'dev-main',
        'version' => 'dev-main',
        'reference' => 'b5566a36727412584e96ed96d9c534edaa568428',
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        '__root__' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => 'b5566a36727412584e96ed96d9c534edaa568428',
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'composer/pcre' => array(
            'pretty_version' => '3.1.3',
            'version' => '3.1.3.0',
            'reference' => '5b16e25a5355f1f3afdfc2f954a0a80aec4826a8',
            'type' => 'library',
            'install_path' => __DIR__ . '/./pcre',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'composer/semver' => array(
            'pretty_version' => '3.4.0',
            'version' => '3.4.0.0',
            'reference' => '35e8d0af4486141bc745f23a29cc2091eb624a32',
            'type' => 'library',
            'install_path' => __DIR__ . '/./semver',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'composer/xdebug-handler' => array(
            'pretty_version' => '3.0.4',
            'version' => '3.0.4.0',
            'reference' => '4f988f8fdf580d53bdb2d1278fe93d1ed5462255',
            'type' => 'library',
            'install_path' => __DIR__ . '/./xdebug-handler',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'friendsofphp/php-cs-fixer' => array(
            'pretty_version' => 'v3.52.1',
            'version' => '3.52.1.0',
            'reference' => '6e77207f0d851862ceeb6da63e6e22c01b1587bc',
            'type' => 'application',
            'install_path' => __DIR__ . '/../friendsofphp/php-cs-fixer',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'psr/container' => array(
            'pretty_version' => '2.0.2',
            'version' => '2.0.2.0',
            'reference' => 'c71ecc56dfe541dbd90c5360474fbc405f8d5963',
            'type' => 'library',
            'install_path' => __DIR__ . '/../psr/container',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'psr/event-dispatcher' => array(
            'pretty_version' => '1.0.0',
            'version' => '1.0.0.0',
            'reference' => 'dbefd12671e8a14ec7f180cab83036ed26714bb0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../psr/event-dispatcher',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'psr/event-dispatcher-implementation' => array(
            'dev_requirement' => true,
            'provided' => array(
                0 => '1.0',
            ),
        ),
        'psr/log' => array(
            'pretty_version' => '3.0.0',
            'version' => '3.0.0.0',
            'reference' => 'fe5ea303b0887d5caefd3d431c3e61ad47037001',
            'type' => 'library',
            'install_path' => __DIR__ . '/../psr/log',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'psr/log-implementation' => array(
            'dev_requirement' => true,
            'provided' => array(
                0 => '1.0|2.0|3.0',
            ),
        ),
        'sebastian/diff' => array(
            'pretty_version' => '5.1.1',
            'version' => '5.1.1.0',
            'reference' => 'c41e007b4b62af48218231d6c2275e4c9b975b2e',
            'type' => 'library',
            'install_path' => __DIR__ . '/../sebastian/diff',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/console' => array(
            'pretty_version' => 'v6.4.4',
            'version' => '6.4.4.0',
            'reference' => '0d9e4eb5ad413075624378f474c4167ea202de78',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/console',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/deprecation-contracts' => array(
            'pretty_version' => 'v3.4.0',
            'version' => '3.4.0.0',
            'reference' => '7c3aff79d10325257a001fcf92d991f24fc967cf',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/deprecation-contracts',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/event-dispatcher' => array(
            'pretty_version' => 'v6.4.3',
            'version' => '6.4.3.0',
            'reference' => 'ae9d3a6f3003a6caf56acd7466d8d52378d44fef',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/event-dispatcher',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/event-dispatcher-contracts' => array(
            'pretty_version' => 'v3.4.0',
            'version' => '3.4.0.0',
            'reference' => 'a76aed96a42d2b521153fb382d418e30d18b59df',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/event-dispatcher-contracts',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/event-dispatcher-implementation' => array(
            'dev_requirement' => true,
            'provided' => array(
                0 => '2.0|3.0',
            ),
        ),
        'symfony/filesystem' => array(
            'pretty_version' => 'v6.4.3',
            'version' => '6.4.3.0',
            'reference' => '7f3b1755eb49297a0827a7575d5d2b2fd11cc9fb',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/filesystem',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/finder' => array(
            'pretty_version' => 'v6.4.0',
            'version' => '6.4.0.0',
            'reference' => '11d736e97f116ac375a81f96e662911a34cd50ce',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/finder',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/options-resolver' => array(
            'pretty_version' => 'v6.4.0',
            'version' => '6.4.0.0',
            'reference' => '22301f0e7fdeaacc14318928612dee79be99860e',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/options-resolver',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/polyfill-ctype' => array(
            'pretty_version' => 'v1.29.0',
            'version' => '1.29.0.0',
            'reference' => 'ef4d7e442ca910c4764bce785146269b30cb5fc4',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/polyfill-ctype',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/polyfill-intl-grapheme' => array(
            'pretty_version' => 'v1.29.0',
            'version' => '1.29.0.0',
            'reference' => '32a9da87d7b3245e09ac426c83d334ae9f06f80f',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/polyfill-intl-grapheme',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/polyfill-intl-normalizer' => array(
            'pretty_version' => 'v1.29.0',
            'version' => '1.29.0.0',
            'reference' => 'bc45c394692b948b4d383a08d7753968bed9a83d',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/polyfill-intl-normalizer',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/polyfill-mbstring' => array(
            'pretty_version' => 'v1.29.0',
            'version' => '1.29.0.0',
            'reference' => '9773676c8a1bb1f8d4340a62efe641cf76eda7ec',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/polyfill-mbstring',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/polyfill-php80' => array(
            'pretty_version' => 'v1.29.0',
            'version' => '1.29.0.0',
            'reference' => '87b68208d5c1188808dd7839ee1e6c8ec3b02f1b',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/polyfill-php80',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/polyfill-php81' => array(
            'pretty_version' => 'v1.29.0',
            'version' => '1.29.0.0',
            'reference' => 'c565ad1e63f30e7477fc40738343c62b40bc672d',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/polyfill-php81',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/process' => array(
            'pretty_version' => 'v6.4.4',
            'version' => '6.4.4.0',
            'reference' => '710e27879e9be3395de2b98da3f52a946039f297',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/process',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/service-contracts' => array(
            'pretty_version' => 'v3.4.1',
            'version' => '3.4.1.0',
            'reference' => 'fe07cbc8d837f60caf7018068e350cc5163681a0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/service-contracts',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/stopwatch' => array(
            'pretty_version' => 'v6.4.3',
            'version' => '6.4.3.0',
            'reference' => '416596166641f1f728b0a64f5b9dd07cceb410c1',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/stopwatch',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'symfony/string' => array(
            'pretty_version' => 'v6.4.4',
            'version' => '6.4.4.0',
            'reference' => '4e465a95bdc32f49cf4c7f07f751b843bbd6dcd9',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/string',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
    ),
);