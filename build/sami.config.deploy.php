<?php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('entities')
    ->in($dir = dirname(__FILE__) . '/../src');

return new Sami($iterator, array(
    'title'                => 'horstoeko/zugferd API',
    'build_dir'            => dirname(__FILE__) . '/../doc',
    'cache_dir'            => dirname(__FILE__) . '/../cache',
    'include_parent_data'  => false,
    'default_opened_level' => 3,
));
