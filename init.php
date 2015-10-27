<?php
/*
 * This file is part of the ws/content-type-menu-extension package.
 *
 * (c) Benjamin Georgeault <github@wedgesama.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Bolt\Extension\WS\ContentTypeMenuExtension\Extension;

$app['extensions']->register(new Extension($app));
