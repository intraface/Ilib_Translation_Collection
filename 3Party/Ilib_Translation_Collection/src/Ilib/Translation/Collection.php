<?php
/**
 * Contains an collection of translation objects, which makes it possible to use more than one translation source
 * Works together with PEAR Translation2.
 * 
 * @author Sune Jensen
 * @package Ilib_Translation_Collection
 */
class Ilib_Translation_Collection
{
    
    /**
     * @var array $translation contains translations objects 
     */
    private $translator = array();
    
    /**
     * Add a translator to the translation collection
     * 
     * @param $obejct PEAR Translation2 object
     * @return void
     */
    public function addTranslator($object) 
    {
        $this->translator[] = $object; 
    }
    
    /**
     * Returns translators in collection
     * 
     * @return array translators
     */
    private function getTranslators()
    {
        return $this->translator;
    }
    
    /**
     * Translate a string
     * @param string $string
     * @param string $page_id
     * @param string $lang_id
     * @param string $default_text
     * @return string translation of string
     */
    public function get($string , $page_id = TRANSLATION2_DEFAULT_PAGEID , $lang_id = null  , $default_text = '')
    {
        foreach($this->getTranslators() AS $translator) {
            $page = $translator->getPage($page_id, $lang_id);
            if(!empty($page[$string])) {
                return $page[$string];
            }
        }
        
        # If we haven't found any translations yet, we use default Text from the last one.
        return $translator->get($string , $page_id, $lang_id, $default_text);
    }
}