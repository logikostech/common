<?php
namespace Logikos\Events;

trait EventsAwareTrait {
  
  /**
   * Attach an event listener, if no event manager has been setup it will set one up for you.
   * @param string $eventType leave blank (null, false, '') to place a listener for all events or specify the event you want
   * @param object|callable $handler
   */
  public function attachEventListener($eventType,$handler) {
    if (!$eventType)
      $eventType = $this->getEventPrefix();
    elseif (!strstr($eventType,':') && $eventType != $this->getEventPrefix())
      $eventType = $this->getEventPrefix().':'.$eventType;
    
    return $this->_forceGetEventsManager()->attach($eventType,$handler);
  }
  
  /**
   * Prefix uses static::EVENT_PREFIX if defined
   * else it uses static::class without the namespace
   * @return string
   */
  public function getEventPrefix() {
    static $prefix;
    if (!$prefix) {
      if (defined(static::class.'::EVENT_PREFIX'))
        $prefix = static::EVENT_PREFIX;
      else
        $prefix = strtolower(array_slice(explode('\\', static::class), -1)[0]);
    }
    return $prefix;
  }
  
  /**
   * @return \Phalcon\Events\Manager
   */
  protected function _forceGetEventsManager() {
    if (!$this->getEventsManager()) {
      $eventsManager = new \Phalcon\Events\Manager();
      $this->setEventsManager($eventsManager);
    }
    return $this->getEventsManager();
  }
  /**
   * Fire Event - checks if eventsmanager is setup, and if so it fires the event
   * if no prefix is used in $eventType it defaults to const EVENT_PREFIX
   * if no constant EVENT_PREFIX is defined it uses static::class without the namespace
   * @param string $eventType
   * @param mixed $data 
   * @param boolean $cancelable
   * @return mixed this will return whatever the listener returns
   * @see \Phalcon\Events\Manager ::fire()
   */
  protected function _fireEvent($eventType, $data = null, $cancelable = true) {
    if ($this->getEventsManager() instanceof \Phalcon\Events\ManagerInterface) {
      $prefix = strstr($eventType,':') ? '' : $this->getEventPrefix().':';
      return $this->getEventsManager()->fire($prefix.$eventType,$this,$data,$cancelable);
    }
  }
}