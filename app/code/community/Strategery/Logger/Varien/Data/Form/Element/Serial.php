<?php
class Strategery_Logger_Varien_Data_Form_Element_Serial extends Varien_Data_Form_Element_Abstract
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setType('file');
    }

    public function getElementHtml()
    {
        $matches = array();
        preg_match_all(
            '/"(([a-z]+_)+[a-z]+Controller)"/i',
            $this->_getObject(),
            $matches
        );
        $controllerClasses = $matches[1];
        foreach ($controllerClasses as $controllerClass) {
            $controllerClass = explode('_', $controllerClass);
            $module = array_shift($controllerClass).'_'.array_shift($controllerClass);
            $filename = array_pop($controllerClass).'.php';
            $path = Mage::getModuleDir('controllers', $module).DS.implode(DS, $controllerClass).DS.$filename;
            require_once $path;
        }
        //print_r($controllerClasses);die;
        $object = print_r(unserialize($this->_getObject()), true);

        return "<pre>$object</pre>";

    }

    protected function _getObject()
    {
        return $this->getValue();
    }

    public function getName()
    {
        return $this->getData('name');
    }
}
