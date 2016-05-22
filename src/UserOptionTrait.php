<?php

namespace Logikos;

/**
 * Trait to add user option handeling
 * <code>
 * class foo {
 *   use \Logikos\UserOptionTrait;
 *   
 *   private $_defaultOptions = [
 *       'some_option' => 'some_value'
 *   ];
 *   
 *   public function __construct(array $userOptions) {
 *     $this->_setDefaultUserOptions($this->_defaultOptions);
 *     $this->mergeUserOptions($userOptions);
 *   }
 * }
 * </code>
 * 
 * @author Todd Empcke
 */
trait UserOptionTrait {
  protected $_options = array();

  /**
   * Sets an option
   * 
   * @param string option
   * @param mixed value
   * @return \Phalcon\Forms\Form
   */
  public function setUserOption($option, $value) {
    $this->_options[$option] = $value;
    return $this;
  }
  
  /**
   * Returns the value of an option if present
   *
   * @param string option
   * @param mixed defaultValue
   * @return mixed
   */
  public function getUserOption($option, $defaultValue=null) {
    return isset($this->_options[$option])
        ? $this->_options[$option]
        : $defaultValue;
  }

  /**
   * Sets/overwrites all options
   */
  public function setUserOptions(array $options) {
    $this->_options = $options;
    return $this;
  }

  /**
   * Returns all options
   * 
   * @return array
   */
  public function getUserOptions() {
    return $this->_options;
  }
  
  /**
   * Merge $options into existing options
   * 
   * @param array $options
   */
  public function mergeUserOptions(array $options) {
    foreach ($options as $option=>$value)
      $this->_options[$option] = $value;
    return $this;
  }
  
  /**
   * Used to set defaults, will not overwrite existing values
   * 
   * @param array $options
   */
  protected function _setDefaultUserOptions(array $options) {
    foreach ($options as $option=>$value) {
      if (!$this->getUserOption($option))
        $this->setUserOption($option,$value);
    }
    return $this;
  }
  
  
}