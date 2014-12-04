<?php

/**
 * KeywordToLink_Helper_Object
 *
 * Access KeywordToLink_Helper_Object - internal functions
 *
 * @author Robert
 */
class KeywordToLink_Helper_Object {

    /**
     *  MapByParam an object
     *  Features : CheckArray . If the param does not exist in one of the arrays this will return FALSE
     *             Avoid Collisions . If this is True is the key is identical it will transform the `entries` into an array
     * @param $toMap - @type object
     * @param $param - @type string
     * @param bool $check_array - @type boolean ; DEFAULT : FALSE
     * @param bool $avoid_collisions - @type boolean ; DEFAULT : FALSE
     * @return array
     */
    public static function mapByParam($toMap , $param , $check_array = false , $avoid_collisions = false){
      $collision = array();
      $final = array();
      if(!empty($toMap)){
        foreach($toMap as $k=>$map){
          if(isset($map->$param)){
            if($avoid_collisions == true){
              $final[$map->$param][] = $map;
            } else {
              $final[$map->$param] = $map;
            }
          } else {
            // Return False because array is malformed,there is no $param in the $toMap[$key]
            if($check_array == true)
              return false;
          }
        }
      }
      return $final;
    }

}
