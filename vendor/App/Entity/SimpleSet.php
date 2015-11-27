<?php

namespace App\Entity;

use App\Entity\Service\FactoryInterface;
use App\Storage\StorageAwareInterface;

class SimpleSet implements EntitySetInterface, StorageAwareInterface
{
    /**
     * The factory of entities
     *
     * @var FactoryInterface
     */
    protected $factory = null;

    /**
     * Inner data
     *
     * @var array
     */
    protected $data = array();

    /**
     * The storage 
     *
     * @var object
     */
    protected $storage = null;

    /**
     * The property name that is the unique key name
     *
     * @var string
     */
    protected $keyName = null;

    /**
     *
     * @param mixed $data
     */
    public function __construct($data = null, FactoryInterface $factory = null, $keyName = null)
    {
        if (null !== $factory) {
            $this->factory = $factory;
        }

        $this->keyName = $keyName;
        if (null !== $data) {
            $this->set($data);
        }
    }

    /**
     * 
     * {@inheritdoc}
     * @param \Traversable|array $set
     * @param string|null $keyName
     * @return \App\Entity\SimpleSet
     * @throws \Exception
     */
    public function set($set, $keyName = null)
    {
        if (!is_array($set)
            && !$set instanceof \Traversable) {
            throw new \Exception('data must be accessible for foreach');
        }

        $keyName = (null === $this->keyName ? $keyName : $this->keyName);
        foreach ($set as $data) {
            $this->add($data, $keyName);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $data
     * @param string|null $keyName
     * @return \App\Entity\SimpleSet
     */
    public function add($data, $keyName = null)
    {
        $class = $this->getFactory()->getInstanceClass();
        if ($data instanceof $class) {
            $item = $data;
        } else {
            $item = $this->getFactory()->create($data);
        }

        if ($item) {
            $this->injectStorage($item);
            $keyName = (null === $this->keyName ? $keyName : $this->keyName);
            if (null !== $keyName && $item instanceof EntityInterface && null !== ($keyValue = $item->{$keyName})) {
                $this->data[$keyValue] = $item;
            } else {
                $this->data[] = $item;
            }
        }

        return $this;
    }

    /**
     * @inheritdocs
     */
    public function toArray($keyAsKeyValue = false)
    {
        $data = array();
        foreach ($this->data as $item) {
            if ($item instanceof Simple) {
                if (true === $keyAsKeyValue) {
                    $data[$item->getKeyValue()] = $item->getValues();
                } elseif (is_string($keyAsKeyValue) && null !== ($key = $item->{$keyAsKeyValue})) {
                    $data[$key] = $item->getValues();
                } else {
                    $data[] = $item->getValues();
                }
            } else {
                $data[] = (array) $item;
            }
        }

        return $data;
    }

    /**
     * Inject storage object into entity if need
     *
     * @param \App\Storage\StorageAwareInterface $item
     * @return void
     */
    protected function injectStorage($item)
    {
        if (null === $this->storage
            || !$item instanceof StorageAwareInterface) {
            return;
        }

        $item->setStorage($this->storage);
    }

    /**
     *
     * @param object $storage
     * @return \App\Entity\SimpleSet
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @return FactoryInterface
     */
    public function getFactory()
    {
        if (null === $this->factory) {
            $this->setFactory(new \App\Entity\Service\SimpleFactory);
        }

        return $this->factory;
    }

    /**
     * {@inheritdoc}
     * @param FactoryInterface $factory
     * @return \App\Entity\SimpleSet
     */
    public function setFactory(FactoryInterface $factory)
    {
        $this->factory = $factory;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return \App\Entity\SimpleSet
     */
    public function reset()
    {
        $this->data = array();

        return $this;
    }

    /**
     *
     * @return integer
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     *
     * @return integer
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     *
     * @return mixed
     */
    public function next()
    {
        return next($this->data);
    }

    /**
     *
     * @return mixed
     */
    public function rewind()
    {
        return reset($this->data);
    }

    /**
     *
     * @return boolean
     */
    public function valid()
    {
        return (bool) $this->current();
    }

    /**
     *
     * @param integer $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     *
     * @param integer $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     *
     * @param integer $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     *
     * @param integer $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }
}
