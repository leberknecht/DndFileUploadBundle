<?php
/**
 * Created by PhpStorm.
 * User: leberknecht
 * Date: 11.08.13
 * Time: 21:31
 */

namespace tps\DndFileUploadBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseTestCase extends WebTestCase {
    public static function createKernel(array $options = array()) {
        return new AppKernel('config.yml');
    }
} 