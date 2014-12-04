<?php

class KeywordToLinkDatabase {

  public $wp_db;
  public $_table_prefix       = 'keyword_to_link_';
  public $_link_table         = 'link';
  public $_link_click_table   = 'link_click';
  public $_link_display_table = 'link_display';

  public function __construct() {
    global $wpdb;

    $this->wp_db = $wpdb;

    $this->_link_table         = $this->wp_db->base_prefix . $this->_table_prefix . $this->_link_table;
    $this->_link_click_table   = $this->wp_db->base_prefix . $this->_table_prefix .  $this->_link_click_table;
    $this->_link_display_table = $this->wp_db->base_prefix . $this->_table_prefix .  $this->_link_display_table;
  }

  public function getLinkByKeyword($keyword) {
    $sql = 'SELECT link.*,
                   (SELECT count(id) FROM `' . $this->_link_click_table .'` link_click
                                     WHERE link_click.link_id = link.id) as click_count,
                   (SELECT count(id) FROM `' . $this->_link_display_table .'` link_display
                                     WHERE link_display.link_id = link.id) as display_count
                   FROM `' . $this->_link_table . '` link
                   WHERE `link`.`keyword` = "' . htmlentities($keyword, ENT_QUOTES, "UTF-8") . '"';

    return $this->wp_db->get_row($sql);
  }

  public function getLinkById($id) {
    $sql = 'SELECT link.*,
                   (SELECT count(id) FROM `' . $this->_link_click_table .'` link_click
                                     WHERE link_click.link_id = link.id) as click_count,
                   (SELECT count(id) FROM `' . $this->_link_display_table .'` link_display
                                     WHERE link_display.link_id = link.id) as display_count
                   FROM `' . $this->_link_table . '` link
                   WHERE `link`.`id` = "' . intval($id) . '"';

    return $this->wp_db->get_row($sql);
  }

  public function getAllLinksWithInformation() {
    $sql = 'SELECT link.*,
                   (SELECT count(id) FROM `' . $this->_link_click_table .'` link_click
                                     WHERE link_click.link_id = link.id) as click_count,
                   (SELECT count(id) FROM `' . $this->_link_display_table .'` link_display
                                     WHERE link_display.link_id = link.id) as display_count
                   FROM `' . $this->_link_table . '` link';

    $information = $this->wp_db->get_results($sql);

    return $information;
  }

  public function getAllLinksClicksMAPForInterval($from_time, $to_time, $link_ids = array()) {
    $sql = 'SELECT id, link_id, DATE(creation_date) as creation_date FROM ' . $this->_link_click_table . ' link_click
                     WHERE DATE(link_click.creation_date) >= "' . date ("Y-m-d", $from_time). '"
                       AND DATE(link_click.creation_date) <= "' . date ("Y-m-d", $to_time). '" ';

    if(!empty($link_ids))
      $sql .= ' AND link_click.link_id IN (' . implode(', ', $link_ids) .') ';

    $information = $this->wp_db->get_results($sql);

    $return = array();

    for($i = $from_time; $i <= $to_time; $i += 86400)
      $return[date("Y-m-d", $i)] = array();

    foreach($information as $info)
      if(isset($return[$info->creation_date][$info->link_id]))
        $return[$info->creation_date][$info->link_id]++;
      else
        $return[$info->creation_date][$info->link_id] = 1;

    return $return;
  }

  public function insertLink($information) {
    return $this->insert($this->_link_table, $information);
  }

  public function insertLinkClick($information) {
    return $this->insert($this->_link_click_table, $information);
  }

  public function insertLinkDisplay($information) {
    return $this->insert($this->_link_display_table, $information);
  }

  public function updateLink($information, $id) {
    return $this->update($this->_link_table, $information, array('id' =>  $id));
  }

  public function deleteLink($id) {
    $this->delete($this->_link_table, array('id' =>  $id));
  }


  /**
   *  Wrap my array
   *  @param array the array you want to wrap
   *  @param string wrapper , default double-quotes(")
   *  @return an array with wrapped strings
   */
  private function _wrapMyArray($array , $wrapper = '"') {
    $new_array = array();
    foreach($array as $k=>$element){
      if(!is_array($element)){
        $new_array[$k] = $wrapper . $element . $wrapper;
      }
    }
    return $new_array;

  }
  /**
   * Implode an array with the key and value pair giving
   * a glue, a separator between pairs and the array
   * to implode.
   * @param string $glue The glue between key and value
   * @param string $separator Separator between pairs
   * @param array $array The array to implode
   * @return string The imploded array
   */
  private function _arrayImplode( $glue, $separator, $array ) {
    if ( ! is_array( $array ) ) return $array;
    $string = array();
    foreach ( $array as $key => $val ) {
      if ( is_array( $val ) )
        $val = implode( ',', $val );
      $string[] = "{$key}{$glue}{$val}";

    }
    return implode( $separator, $string );
  }

  /**
   *  @param string db_name
   *  @param array data
   *  @uses wrap_my_array
   *  @uses array_implode
   */
  public function insert($db_name , $data){
    if(is_array($data) && !empty($data)){
      $keys = array_keys($data);

      $sql = 'INSERT INTO '.$db_name.' ('
          .implode("," , $this->_wrapMyArray($keys , '`'))
          .') VALUES ('
          .implode("," , $this->_wrapMyArray($data))
          .')';
      $this->wp_db->query($sql);
      return true;
    }
    return false;
  }

  /**
   *  @param string db_name
   *  @param array data
   *  @param array/string where
   *  @uses wrap_my_array
   *  @uses array_implode
   */
  public function update($db_name , $data = array() , $where = array()) {
    if(is_array($data) && !empty($data)){
      $data = $this->_wrapMyArray($data);

      $sql = 'UPDATE '.$db_name.' SET ';
      $sql .= $this->_arrayImplode("=" , "," , $data);

      if(!empty($where)){
        $sql .= ' WHERE ';
        if(is_array($where)){
          $where = $this->_wrapMyArray($where);
          $sql  .= $this->_arrayImplode("=" , "AND" , $where);
        }else{
          $sql  .= $where;
        }
      }

      $this->wp_db->query($sql);
      return true;
    }
    return false;
  }

  /**
   *  @param string db_name
   *  @param array/string where
   *  @uses wrap_my_array
   *  @uses array_implode
   */
  public function delete($db_name , $where = array()){
    $sql = 'DELETE FROM '.$db_name.' ';

    if(!empty($where)){
      $sql .= ' WHERE ';
      if(is_array($where)){
        $where = $this->_wrapMyArray($where);
        $sql  .= $this->_arrayImplode("=" , "AND" , $where);
      }else{
        $sql  .= $where;
      }
    }

    $this->wp_db->query($sql);
  }

}