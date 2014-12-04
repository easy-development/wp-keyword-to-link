<?php

class KeywordToLinkSettings {

	private $_prefix = 'keyword_to_link_';

	private $_linkOpenOptions = array(
		'_blank'  => 'Opens the keyword link in a new window or tab',
		'_self'   => 'Opens the keyword link in the same frame as it was clicked (this is default)',
		'_parent' => 'Opens the keyword link in the parent frame',
		'_top' 	  => 'Opens the keyword link in the full body of the window'
	);

	private $_linkOpenMethodAlias = "link_open_method";
	private $_linkOpenMethodWPOptionName = "";
	private $_linkOpenMethod  	  = "_self";

  private $_allowH1TagAlias        = "allow_h1_tag";
  private $_allowH1TagWPOptionName = "";
  private $_allowH1Tag  	         = 1;

  private $_allowH2TagAlias        = "allow_h2_tag";
  private $_allowH2TagWPOptionName = "";
  private $_allowH2Tag  	         = 1;

  private $_allowH3TagAlias        = "allow_h3_tag";
  private $_allowH3TagWPOptionName = "";
  private $_allowH3Tag  	         = 1;

  private $_allowH4TagAlias        = "allow_h4_tag";
  private $_allowH4TagWPOptionName = "";
  private $_allowH4Tag  	         = 1;

  private $_allowH5TagAlias        = "allow_h5_tag";
  private $_allowH5TagWPOptionName = "";
  private $_allowH5Tag  	         = 1;

  private $_maximumKeywordsAllowedPerPageAlias       = "maximum_keywords_allowed_per_page";
  private $_maximumKeywordsAllowedPerPageOptionName  = "";
  private $_maximumKeywordsAllowedPerPage            = 0;

  private $_maximumEachKeywordsAllowedPerPageAlias       = "maximum_each_keywords_allowed_per_page";
  private $_maximumEachKeywordsAllowedPerPageOptionName  = "";
  private $_maximumEachKeywordsAllowedPerPage            = 0;

  private $_preventInsideLinkAlias = "prevent_inside_link";
  private $_preventInsideLinkWPOptionName = "";
  private $_preventInsideLink   = 1;

  private $_allowKeywordLinkingToCurrentPageAlias        = "allow_keyword_linking_to_current_page";
  private $_allowKeywordLinkingToCurrentPageWPOptionName = "";
  private $_allowKeywordLinkingToCurrentPage             = 1;

  private $_trackClicksAndHideLinksAlias        = "track_clicks_and_hide_links";
  private $_trackClicksAndHideLinksWPOptionName = "";
  private $_trackClicksAndHideLinks             = 1;

  private $_groupByLinksAlias             = "group_by_links";
  private $_groupByLinksAliasWPOptionName = "";
  private $_groupByLinks                  = 0;

  private $_keywordHasSpaceSeparatorAlias        = "keyword_has_space_separator";
  private $_keywordHasSpaceSeparatorWPOptionName = "";
  private $_keywordHasSpaceSeparator             = 1;

  private $_keywordColorAlias        = "keyword_color";
  private $_keywordColorWPOptionName = "";
  private $_keywordColor             = "";

  private $_theContentFilterPriorityAlias        = "the_content_filter_priority";
  private $_theContentFilterPriorityWPOptionName = "";
  private $_theContentFilterPriority             = 10;

  public function __construct() {
		$this->_handleWordPressOptionNameSetup();
		$this->_linkOpenMethod    = get_option($this->_linkOpenMethodWPOptionName, $this->_linkOpenMethod);
    $this->_preventInsideLink = get_option($this->_preventInsideLinkWPOptionName, $this->_preventInsideLink);
    $this->_allowH1Tag        = get_option($this->_allowH1TagWPOptionName, $this->_allowH1Tag);
    $this->_allowH2Tag        = get_option($this->_allowH2TagWPOptionName, $this->_allowH2Tag);
    $this->_allowH3Tag        = get_option($this->_allowH3TagWPOptionName, $this->_allowH3Tag);
    $this->_allowH4Tag        = get_option($this->_allowH4TagWPOptionName, $this->_allowH4Tag);
    $this->_allowH5Tag        = get_option($this->_allowH5TagWPOptionName, $this->_allowH5Tag);

    $this->_allowKeywordLinkingToCurrentPage  = get_option($this->_allowKeywordLinkingToCurrentPageWPOptionName, $this->_allowKeywordLinkingToCurrentPage);

    $this->_maximumKeywordsAllowedPerPage     = get_option($this->_maximumKeywordsAllowedPerPageOptionName, $this->_maximumKeywordsAllowedPerPage);
    $this->_maximumEachKeywordsAllowedPerPage = get_option($this->_maximumEachKeywordsAllowedPerPageOptionName, $this->_maximumEachKeywordsAllowedPerPage);

    $this->_trackClicksAndHideLinks  = get_option($this->_trackClicksAndHideLinksWPOptionName, $this->_trackClicksAndHideLinks);
    $this->_groupByLinks             = get_option($this->_groupByLinksAliasWPOptionName, $this->_groupByLinks);
    $this->_keywordHasSpaceSeparator = get_option($this->_keywordHasSpaceSeparatorWPOptionName, $this->_keywordHasSpaceSeparator);

    $this->_keywordColor             = get_option($this->_keywordColorWPOptionName, $this->_keywordColor);
    $this->_theContentFilterPriority = get_option($this->_theContentFilterPriorityWPOptionName, $this->_theContentFilterPriority);
  }

	private function _handleWordPressOptionNameSetup() {
		$this->_linkOpenMethodWPOptionName    = $this->_prefix . $this->_linkOpenMethodAlias;
    $this->_preventInsideLinkWPOptionName = $this->_prefix . $this->_preventInsideLinkAlias;
    $this->_allowH1TagWPOptionName        = $this->_prefix . $this->_allowH1TagAlias;
    $this->_allowH2TagWPOptionName        = $this->_prefix . $this->_allowH2TagAlias;
    $this->_allowH3TagWPOptionName        = $this->_prefix . $this->_allowH3TagAlias;
    $this->_allowH4TagWPOptionName        = $this->_prefix . $this->_allowH4TagAlias;
    $this->_allowH5TagWPOptionName        = $this->_prefix . $this->_allowH5TagAlias;

    $this->_allowKeywordLinkingToCurrentPageWPOptionName = $this->_prefix . $this->_allowKeywordLinkingToCurrentPageAlias;

    $this->_maximumKeywordsAllowedPerPageOptionName      = $this->_prefix . $this->_maximumKeywordsAllowedPerPageAlias;
    $this->_maximumEachKeywordsAllowedPerPageOptionName  = $this->_prefix . $this->_maximumEachKeywordsAllowedPerPageAlias;

    $this->_trackClicksAndHideLinksWPOptionName = $this->_prefix . $this->_trackClicksAndHideLinksAlias;
    $this->_groupByLinksAliasWPOptionName       = $this->_prefix . $this->_groupByLinksAlias;
    $this->_keywordHasSpaceSeparatorWPOptionName= $this->_prefix . $this->_keywordHasSpaceSeparatorAlias;

    $this->_keywordColorWPOptionName             = $this->_prefix . $this->_keywordColorAlias;
    $this->_theContentFilterPriorityWPOptionName = $this->_prefix . $this->_theContentFilterPriorityAlias;
	}

  public function getLinkOpenMethodOptions() {
    return $this->_linkOpenOptions;
  }

	public function getLinkOpenMethod() {
		return $this->_linkOpenMethod;
	}

	public function setLinkOpenMethod($linkOpenMethod) {
		if(!isset($this->_linkOpenOptions[$linkOpenMethod]))
			throw new Exception('Invalid Wordpress Link Open Method Option given to KeywordToLinkSettings->setLinkOpenMethod ');

		$this->_linkOpenMethod = $linkOpenMethod;

		update_option( $this->_linkOpenMethodWPOptionName, $this->_linkOpenMethod);
	}

  public function getPreventInsideLink() {
    return $this->_preventInsideLink;
  }

  public function setPreventInsideLink($preventInsideLink) {

    $this->_preventInsideLink = $preventInsideLink;

    update_option( $this->_linkOpenMethodWPOptionName, $this->_linkOpenMethod);
  }

  public function getAllowH1Tag() {
    return $this->_allowH1Tag;
  }

  public function setAllowH1Tag($allowH1Tag) {

    $this->_allowH1Tag = $allowH1Tag;

    update_option( $this->_allowH1TagWPOptionName, $this->_allowH1Tag);
  }

  public function getAllowH2Tag() {
    return $this->_allowH2Tag;
  }

  public function setAllowH2Tag($allowH2Tag) {

    $this->_allowH2Tag = $allowH2Tag;

    update_option( $this->_allowH2TagWPOptionName, $this->_allowH2Tag);
  }

  public function getAllowH3Tag() {
    return $this->_allowH3Tag;
  }

  public function setAllowH3Tag($allowH3Tag) {

    $this->_allowH3Tag = $allowH3Tag;

    update_option( $this->_allowH3TagWPOptionName, $this->_allowH3Tag);
  }

  public function getAllowH4Tag() {
    return $this->_allowH4Tag;
  }

  public function setAllowH4Tag($allowH4Tag) {

    $this->_allowH4Tag = $allowH4Tag;

    update_option( $this->_allowH4TagWPOptionName, $this->_allowH4Tag);
  }

  public function getAllowH5Tag() {
    return $this->_allowH5Tag;
  }

  public function setAllowH5Tag($allowH5Tag) {

    $this->_allowH5Tag = $allowH5Tag;

    update_option( $this->_allowH5TagWPOptionName, $this->_allowH5Tag);
  }

  public function getMaximumKeywordsAllowedPerPage() {
    return $this->_maximumKeywordsAllowedPerPage;
  }

  public function setMaximumKeywordsAllowedPerPage($maximumKeywordsAllowedPerPage) {
    $this->_maximumKeywordsAllowedPerPage = $maximumKeywordsAllowedPerPage;

    update_option( $this->_maximumKeywordsAllowedPerPageOptionName, $this->_maximumKeywordsAllowedPerPage);
  }

  public function getMaximumEachKeywordsAllowedPerPage() {
    return $this->_maximumEachKeywordsAllowedPerPage;
  }

  public function setMaximumEachKeywordsAllowedPerPage($maximumEachKeywordsAllowedPerPage) {
    $this->_maximumEachKeywordsAllowedPerPage = $maximumEachKeywordsAllowedPerPage;

    update_option( $this->_maximumEachKeywordsAllowedPerPageOptionName, $this->_maximumEachKeywordsAllowedPerPage);
  }

  public function setAllowKeywordLinkingToCurrentPage($allowKeywordLinkingToCurrentPage) {
    $this->_allowKeywordLinkingToCurrentPage = $allowKeywordLinkingToCurrentPage;

    update_option( $this->_allowKeywordLinkingToCurrentPageWPOptionName, $this->_allowKeywordLinkingToCurrentPage);
  }

  public function getAllowKeywordLinkingToCurrentPage() {
    return $this->_allowKeywordLinkingToCurrentPage;
  }

  public function setTrackClicksAndHideLinks($trackClicksAndHideLinks) {
    $this->_trackClicksAndHideLinks = $trackClicksAndHideLinks;

    update_option( $this->_trackClicksAndHideLinksWPOptionName, $this->_trackClicksAndHideLinks);
  }

  public function getTrackClicksAndHideLinks() {
    return $this->_trackClicksAndHideLinks;
  }

  public function setGroupByLinks($groupByLinks) {
    $this->_groupByLinks = $groupByLinks;

    update_option( $this->_groupByLinksAliasWPOptionName, $this->_groupByLinks);
  }

  public function getGroupByLinks() {
    return $this->_groupByLinks;
  }

  public function setKeywordHasSpaceSeparator($keywordHasSpaceSeparator) {
    $this->_keywordHasSpaceSeparator = $keywordHasSpaceSeparator;

    update_option( $this->_keywordHasSpaceSeparatorWPOptionName, $this->_keywordHasSpaceSeparator);
  }

  public function getKeywordHasSpaceSeparator() {
    return $this->_keywordHasSpaceSeparator;
  }

  public function setKeywordColor($keywordColor) {
    $this->_keywordColor = $keywordColor;

    update_option( $this->_keywordColorWPOptionName, $this->_keywordColor);
  }

  public function getKeywordColor() {
    return $this->_keywordColor;
  }

  public function setTheContentFilterPriority($theContentFilterPriority) {
    $this->_theContentFilterPriority = $theContentFilterPriority;

    update_option( $this->_theContentFilterPriorityWPOptionName, $this->_theContentFilterPriority);
  }

  public function getTheContentFilterPriority() {
    return $this->_theContentFilterPriority;
  }

}