<?php
/*
 * This file is part of the ws/content-type-menu-extension package.
 *
 * (c) Benjamin Georgeault <github@wedgesama.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bolt\Extension\WS\ContentTypeMenuExtension;

use Bolt\BaseExtension;

/**
 * Extension
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class Extension extends BaseExtension
{
    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $menus = $this->app['config']->get('menu');

        $updateMenus = array();
        foreach ($menus as $name => $items) {
            $updateMenus[$name] = $this->parseItems($items);
        }

        $this->app['config']->set('menu', $updateMenus);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "WSContentTypeMenuExtension";
    }

    /**
     * Apply contenttype to a menu/submenu tree.
     *
     * @param array $items
     * @return array
     */
    protected function parseItems(array $items)
    {
        $parsedItems = array();
        foreach ($items as $item) {
            if (array_key_exists('contenttype', $item)) {
                $params = array_key_exists('contenttype_params', $item)?$item['contenttype_params']:array();

                $parsedItems[] = array_merge($item, array(
                    'submenu' => $this->getContentItems($item['contenttype'], $params),
                ));
            } else if (array_key_exists('submenu', $item)) {
                $parsedItems[] = array_merge($item, array(
                    'submenu' => $this->parseItems($item['submenu']),
                ));
            } else {
                $parsedItems[] = $item;
            }
        }

        return $parsedItems;
    }

    /**
     * Get contents from database.
     *
     * @param string $contenttype
     * @param array $params
     * @return array
     */
    protected function getContentItems($contenttype, array $params = array())
    {
        /** @var \Bolt\Storage $storage */
        $storage = $this->app['storage'];

        $items = array();
        $contents = $storage->searchContentType($contenttype, $params);

        /**
         * @var integer $id
         * @var \Bolt\Content $content
         */
        foreach ($contents as $id => $content) {
            $items[] = array(
                'label' => $content->getTitle(),
                'path' => $content->getReference(),
            );
        }

        return $items;
    }
}
