<?php

class KeywordToLinkVersionControl {

  public $wpOptionDatabaseVersion = 'keyword_to_link_database_version';
  public $currentDatabaseVersion  = '1.1';

  public $databaseUpdateVersion = array(
    '1.1' => 'update.sql'
  );

  public function __construct() {
    add_action('init', array($this, 'init'));
  }

  public function init() {
    if(get_option($this->wpOptionDatabaseVersion) != $this->currentDatabaseVersion) {
      foreach($this->databaseUpdateVersion as $versionAlias => $versionFile) {
        if(floatval($versionAlias) > floatval(get_option($this->wpOptionDatabaseVersion))) {
          global $wpdb;


          $query = file_get_contents(
            KeywordToLink::getInstance()->scriptBasePath
                . 'model/sql-update/'
                . $versionFile
          );

          if($query == false)
            throw new Exception('Keyword to link, missing DB UPDATE File');

          $query = str_replace(KeywordToLink::getInstance()->database->_table_prefix ,
                               $wpdb->base_prefix . KeywordToLink::getInstance()->database->_table_prefix,
                               $query);

          $queries = explode(';', $query);


          foreach($queries as $query)
            if(strlen($query)> 20)
              $response = $wpdb->query($query);

          $this->setCurrentDatabaseVersion($versionAlias);
        }
      }
    }
  }

  public function setCurrentDatabaseVersion($currentVersion) {
    $this->currentDatabaseVersion = $currentVersion;
    update_option($this->wpOptionDatabaseVersion, $this->currentDatabaseVersion);

  }

}