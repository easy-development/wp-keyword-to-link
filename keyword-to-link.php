<?php
/*
Plugin Name: Keyword to Link
Description: Create any keyword you want, and assign a link to it, the keywords will be hidden.
Version: 1.9.7
Plugin URI: https://github.com/easy-development/wp-keyword-to-link
Author: Andrei-Robert Rusu
Author URI: http://easy-development.com/
*/


class KeywordToLink {

  protected static $_instance;

  public static function getInstance() {
    if(self::$_instance == null)
      self::$_instance = new self();

    return self::$_instance;
  }

  public static function resetInstance() {
    self::$_instance = null;
  }

  public $scriptName          = 'Keyword To Link';
  public $scriptShortName     = "Keywords";
  public $scriptAlias    = "keyword-to-link";
  public $scriptBasePath = '';
  /**
   * @var KeywordToLinkDatabase
   */
  public $database;
  /**
   * @var KeywordToLinkSettings
   */
  public $settings;
  /**
   * @var KeywordToLinkVersionControl
   */
  public $versionControl;
  /**
   * @var KeywordToLinkPostWidget
   */
  public $postWidget;
  public $frontProcessing;
  public $keywordLinkIdentifier   = 'information-about-keyword';
  public $keywordIdLinkIdentifier = 'information-about-keyword-id';

  public function __construct() {
    $this->scriptBasePath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    $this->setDependencies();
    $this->setWordPressHooks();
  }

  public function setDependencies() {
    require_once($this->scriptBasePath . 'helper/object.php');
    require_once($this->scriptBasePath . 'model/database.php');
    require_once($this->scriptBasePath . 'model/versionControl.php');
    require_once($this->scriptBasePath . 'model/settings.php');
    require_once($this->scriptBasePath . 'model/frontProcessing.php');
    require_once($this->scriptBasePath . 'model/postWidget.php');
    $this->database         = new KeywordToLinkDatabase();
    $this->settings         = new KeywordToLinkSettings();
    $this->versionControl   = new KeywordToLinkVersionControl();
    $this->frontProcessing  = new KeywordToLinkPageRequest();
    $this->postWidget       = new KeywordToLinkPostWidget();
  }

  public function setWordPressHooks() {
    register_activation_hook(__FILE__, array($this, '_activationHook'));
    add_action( 'admin_menu', array( $this, '_addAdministrationMenu' ) );
    add_action( 'admin_enqueue_scripts', array($this, '_adminScripts') );

    return $this;
  }

  public function _adminScripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'keyword-to-link-admin', plugins_url('admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
  }

  public function _addAdministrationMenu() {
    add_menu_page(
      $this->scriptName,
      '&nbsp;' . $this->scriptShortName,
      'manage_options',
      $this->scriptAlias,
      array(
        $this, 'displayAdministration'
      ),
      plugins_url( 'keyword-to-link/icon.png')
    );
  }

  public function displayAdministration() {
    $page = isset($_GET['sub_page']) ? $_GET['sub_page'] : 'main';

    if($page == 'main')
      KeywordToLinkKeywords();
    elseif($page == 'settings')
      KeywordToLinkSettings();
    elseif($page == 'statistics')
      KeywordToLinkKeywordsChart();
    else
      KeywordToLinkKeywords();
  }

  public function _activationHook() {
    global $wpdb;

    $query = file_get_contents($this->scriptBasePath . 'model/install.sql');

    $query = str_replace($this->database->_table_prefix ,
                         $wpdb->base_prefix . $this->database->_table_prefix,
                         $query);

    $queries = explode(';', $query);


    foreach($queries as $query)
      if(strlen($query)> 20)
        $response = $wpdb->query($query);

    $this->versionControl->setCurrentDatabaseVersion($this->versionControl->currentDatabaseVersion);
  }

}

KeywordToLink::getInstance();

function KeywordToLinkKeywords() {
  echo '<script type="text/javascript" src="' . plugins_url('scripts/tablesorter/tablesorter.js', __FILE__) . '"></script>';
  echo '<link rel="stylesheet" href="' . plugins_url('scripts/tablesorter/tablesorter.css', __FILE__) . '" />';
  echo '<link rel="stylesheet" href="' . plugins_url('styles/style.css', __FILE__) . '" />';
  echo '<div class="bootstrap_enviorement">';
  require_once('_header.php');
  require_once('keywords_display.php');
  echo '</div>';
}

function KeywordToLinkSettings() {
  echo '<link rel="stylesheet" href="' . plugins_url('styles/style.css', __FILE__) . '" />';
  echo '<div class="bootstrap_enviorement">';
  require_once('_header.php');
  require_once('keywords_settings.php');
  echo '</div>';
}

function KeywordToLinkKeywordsChart() {
  echo '<script type="text/javascript" src="' . plugins_url('scripts/highcharts/highcharts.js', __FILE__) . '"></script>';
  echo '<script type="text/javascript" src="' . plugins_url('scripts/highcharts/modules/exporting.js', __FILE__) . '"></script>';
  echo '<script type="text/javascript" src="' . plugins_url('scripts/layout_helper_easy_chart.js', __FILE__) . '"></script>';
  echo '<link rel="stylesheet" href="' . plugins_url('styles/style.css', __FILE__) . '" />';
  echo '<div class="bootstrap_enviorement">';
  require_once('_header.php');
  require_once('keywords_chart.php');
  echo '</div>';
}