<?php

namespace Administr\Assets;

use Administr\Assets\Contracts\Shortcut;

class Manager
{
    /**
     * @var array
     */
    private $assets = [];

    /**
     * @var array
     */
    private $shortcuts = [];

    /**
     * Add an asset of a given type
     *
     * @param $asset - The full path relative to the Bundle
     * @param string $type - The type - CSS, JS or any custom type of asset, the same type should be used with the Get() method
     * @param int $priority
     * @return $this
     */
    public function add($asset, $type, $priority = 0)
    {
        $type = strtolower($type);
        $this->assets[$type][md5($asset)] = new Asset($asset, $priority);
        return $this;
    }

    /**
     * Get an array with assets by type
     *
     * @param string $type
     * @return array
     */
    public function get($type)
    {
        $type = strtolower($type);

        if( !array_key_exists($type, $this->assets) || count($this->assets[$type]) === 0 )
        {
            return [];
        }

        $assets = $this->assets[$type];

        // Sort the assets by their priority,
        // the higher priority, the higher in list
        usort($assets, function(Asset $a, Asset $b) {
            return $a->getPriority() < $b->getPriority();
        });

        // Return an array with only the assets names
        return array_map(function(Asset $item){
            return $item->getName();
        }, $assets);
    }

    /**
     * Register an Asset shortcut.
     *
     * Shortcuts are a way to register multiple assets at once.
     *
     * @param $name
     * @param Shortcut $shortcut
     * @return $this
     */
    public function shortcut($name, $shortcut)
    {
        $this->shortcuts[$name] = $shortcut;

        return $this;
    }

    /**
     * Register multiple shortcuts.
     *
     * @param array $shortcuts
     * @return $this
     */
    public function shortcuts(array $shortcuts)
    {
        foreach ($shortcuts as $name => $shortcut) {
            $this->shortcut($name, $shortcut);
        }

        return $this;
    }

    public function __call($name, $params)
    {
        if ( starts_with($name, 'get') || starts_with($name, 'add') )
        {
            $method = substr($name, 0, 3);
            $type = substr($name, 3);

            switch($method)
            {
                case 'get':
                    return $this->get($type);
                break;
                default:
                    $name = $params[0];
                    $priority = array_key_exists(1, $params) ? $params[1] : 0;
                    return $this->add($name, $type, $priority);
                break;
            }
        }

        // If we have registered a shortcut with this name,
        // resolve it through the IoC and execute it.
        if(array_key_exists($name, $this->shortcuts)) {
            return app($this->shortcuts[$name])->execute();
        }

        $className = get_class($this);
        $args = implode(', ', $params);

        throw new \BadMethodCallException("Call to undefined method {$className}::{$name}({$args})");
    }


}