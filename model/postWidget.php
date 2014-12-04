<?php

class KeywordToLinkPostWidget {

  public $metaBoxId     = "";
  public $metaBoxName   = "Keyword To Link Options";
  public $postTypes     = array('post', 'page');

  public $fieldAliasPrefix        = '';
  public $fieldAliasNonce         = 'nonce';
  public $fieldAliasAllowKeywords = "allow_keyword_to_link";

  public function __construct() {
    add_action( 'init', array($this, 'init'));
    add_action( 'add_meta_boxes', array($this, 'registerMetaBoxes') );
    add_action( 'save_post', array($this, 'metaBoxSaveCallback') );
  }

  public function init() {
    $this->metaBoxId      = KeywordToLink::getInstance()->scriptAlias . '_post';

    $this->_fieldPrefixHandler();
  }

  private function _fieldPrefixHandler() {
    $this->fieldAliasPrefix  = str_replace("-", "_", KeywordToLink::getInstance()->scriptAlias);
    $this->fieldAliasNonce = $this->fieldAliasPrefix . $this->fieldAliasNonce;
  }

  public function registerMetaBoxes() {
    foreach ( $this->postTypes as $postType )
      add_meta_box(
          $this->metaBoxId,
          __( $this->metaBoxName ),
          array($this, 'metaBoxDisplayCallback'),
          $postType,
          'side'
      );
  }

  public function metaBoxDisplayCallback($post) {
    wp_nonce_field( $this->fieldAliasPrefix, $this->fieldAliasNonce );

    $allowKeywordToLink = get_post_meta( $post->ID, $this->fieldAliasAllowKeywords, true );

    if($allowKeywordToLink == "")
      $allowKeywordToLink = 1;

    echo '<label for="' . $this->fieldAliasAllowKeywords . '">';
      _e( 'Disable Keyword To Link');
    echo '</label> ';
    echo '<input type="hidden" name="' . $this->fieldAliasAllowKeywords . '" value="1" />';
    echo '<input type="checkbox" id="' . $this->fieldAliasAllowKeywords . '" name="' . $this->fieldAliasAllowKeywords . '" value="0" ' . ($allowKeywordToLink == 0 ? 'checked="checked"' : '') . '/>';
  }

  public function metaBoxSaveCallback($post_id) {
    if ( ! isset( $_POST[$this->fieldAliasNonce] ) )
      return;
    if ( ! wp_verify_nonce( $_POST[$this->fieldAliasNonce], $this->fieldAliasPrefix ) )
      return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_page', $post_id ) )
        return;
    } else {
      if ( ! current_user_can( 'edit_post', $post_id ) )
        return;
    }

    if ( ! isset( $_POST[$this->fieldAliasAllowKeywords] ) ) {
      return;
    }

    update_post_meta( $post_id, $this->fieldAliasAllowKeywords, intval( $_POST[$this->fieldAliasAllowKeywords] ) );
  }

}