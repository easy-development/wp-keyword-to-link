<?php

class KeywordToLinkPageRequest {

  public function __construct() {
    add_action('init', array($this, 'keywordRequestCheck'));
  }

  public function keywordRequestCheck(){
    add_filter('the_content', array($this, 'postContentParse'), KeywordToLink::getInstance()->settings->getTheContentFilterPriority());

    if(isset($_GET[KeywordToLink::getInstance()->keywordLinkIdentifier])) {
      $keyword = $_GET[KeywordToLink::getInstance()->keywordLinkIdentifier];

      $keyword = urldecode($keyword);

      $keyword_information = KeywordToLink::getInstance()->database->getLinkByKeyword($keyword);

      if(!empty($keyword_information)) {
        KeywordToLink::getInstance()->database->insertLinkClick(array(
          'link_id'     =>  $keyword_information->id,
          'ip_address'  =>  $_SERVER['REMOTE_ADDR']
        ));

        wp_redirect( $keyword_information->url);
        exit;
      }
    }

    if(isset($_GET[KeywordToLink::getInstance()->keywordIdLinkIdentifier])) {
      $keyword_id = $_GET[KeywordToLink::getInstance()->keywordIdLinkIdentifier];

      $keyword_information = KeywordToLink::getInstance()->database->getLinkById($keyword_id);

      if(!empty($keyword_information)) {
        KeywordToLink::getInstance()->database->insertLinkClick(array(
          'link_id'     =>  $keyword_information->id,
          'ip_address'  =>  $_SERVER['REMOTE_ADDR']
        ));

        wp_redirect( $keyword_information->url);
        exit;
      }
    }
  }

  public function postContentParse( $content ) {
    global $post;

    if(!is_single() && $post->post_type == 'post')
      return $content;

    $allowKeywordToLink = get_post_meta( $post->ID, KeywordToLink::getInstance()->postWidget->fieldAliasAllowKeywords, 1 );
    $allowKeywordToLink = $allowKeywordToLink == "" ? 1 : $allowKeywordToLink;

    if($allowKeywordToLink == 0)
      return $content;

    return $this->_parseContent($content, $post);
  }

  private function _parseContent($content, $post) {
    if ( stripos( $content, '<!-- no keywords -->' ) !== false ) { return $content; }

    $keywords_db = KeywordToLink::getInstance()->database->getAllLinksWithInformation();

    if(empty($keywords_db))
      return $content;

    $aKeywords = array();
    $url_prefix = get_permalink();
    $url_prefix = strpos($url_prefix, '?') === false ? $url_prefix . '?' : $url_prefix . '&';

    foreach($keywords_db as $keyword)
      $aKeywords[] = array(
          $keyword->keyword,
          (
          strpos( $keyword->url, '@' ) === false ? $url_prefix . KeywordToLink::getInstance()->keywordLinkIdentifier . '=' . urlencode($keyword->keyword) : $keyword->url
          ),
          $keyword->url,
          $keyword->title
      );

    //---------------------------------------------
    //Find all pre-existing selectors

    $aSelector = array();
    $aDebug = array();
    $i = 0;
    $startSelector = 0;
    $endSelector = 0;
    while( $i < strlen( $content ) ) {

      //We have found a selector ('<' followed by a non-space char)
      if ( ( substr($content, $i, 1) == '<' ) && ( substr($content, $i+1, 1) != ' ' ) ) {
        $startSelector = $i;

        //Anchor selectors
        //We want to mark the selector and its content
        if ( substr($content, $i, 2) == '<a' ) {
          while( $i < strlen( $content ) ) {
            if (substr($content, $i, 4) == '</a>') {
              $endSelector = $i + 4;
              array_push( $aSelector, array( $startSelector, $endSelector ) );
              break;
            }
            $i++;
          }
        } else if(substr($content, $i, 3) == '<h1' && !KeywordToLink::getInstance()->settings->getAllowH1Tag()) {
          while( $i < strlen( $content ) ) {
            if (substr($content, $i, 5) == '</h1>') {
              $endSelector = $i + 5;
              array_push( $aSelector, array( $startSelector, $endSelector ) );
              break;
            }
            $i++;
          }
        } else if(substr($content, $i, 3) == '<h2' && !KeywordToLink::getInstance()->settings->getAllowH2Tag()) {
          while( $i < strlen( $content ) ) {
            if (substr($content, $i, 5) == '</h2>') {
              $endSelector = $i + 5;
              array_push( $aSelector, array( $startSelector, $endSelector ) );
              break;
            }
            $i++;
          }
        } else if(substr($content, $i, 3) == '<h3' && !KeywordToLink::getInstance()->settings->getAllowH3Tag()) {
          while( $i < strlen( $content ) ) {
            if (substr($content, $i, 5) == '</h3>') {
              $endSelector = $i + 5;
              array_push( $aSelector, array( $startSelector, $endSelector ) );
              break;
            }
            $i++;
          }
        } else if(substr($content, $i, 3) == '<h4'  && !KeywordToLink::getInstance()->settings->getAllowH4Tag()) {
          while( $i < strlen( $content ) ) {
            if (substr($content, $i, 5) == '</h4>') {
              $endSelector = $i + 5;
              array_push( $aSelector, array( $startSelector, $endSelector ) );
              break;
            }
            $i++;
          }
        } else if(substr($content, $i, 3) == '<h5'  && !KeywordToLink::getInstance()->settings->getAllowH5Tag()) {
          while( $i < strlen( $content ) ) {
            if (substr($content, $i, 5) == '</h5>') {
              $endSelector = $i + 5;
              array_push( $aSelector, array( $startSelector, $endSelector ) );
              break;
            }
            $i++;
          }
        } else {
          //Other selectors (all but anchors)
          //We only want to mark the selector, not its content.
          //Example: for '<p class="test">Test</p>' we only mark '<p class="test">' and '</p>', not 'Test'
          while( $i < strlen( $content ) ) {
            if ( substr($content, $i, 1) == '>') {
              $endSelector = $i+1;
              array_push( $aSelector, array( $startSelector, $endSelector ) );
              break;
            }
            $i++;
          }
        }
      }
      $i++;
    }

    //---------------------------------------------
    //Find all the keyword boundaries

    $aReplace = array();
    for ( $i=0; $i<count($aKeywords); $i++ ) {

      if(KeywordToLink::getInstance()->settings->getKeywordHasSpaceSeparator())
        preg_match_all('/(?<=^|[^\p{Cyrillic}{Greek}{L}])' . preg_quote($aKeywords[$i][0],'/') . '(?=[^\p{Cyrillic}{Greek}{L}]|$)/ui', $content, $matches, PREG_OFFSET_CAPTURE);
      else
        preg_match_all('/' . preg_quote($aKeywords[$i][0],'/') . '/ui', $content, $matches, PREG_OFFSET_CAPTURE);

      $aMatches = $matches[0];
      for ( $j=0; $j<count($aMatches); $j++ ) {
        $m = $aMatches[$j][1];
        $n = $m + strlen( $aMatches[$j][0] ) - 1;
        $inAnchor = 0;
        for ( $k=0; $k<count($aSelector); $k++ ) {
          $startAnchor = $aSelector[$k][0];
          $closeAnchor = $aSelector[$k][1];
          if ( ( $m > $startAnchor ) && ( $n < $closeAnchor ) ) { $inAnchor = 1;  break; }
        }
        if ( !$inAnchor ) {
          array_push( $aReplace, array( $m, $n, $aMatches[$j][0], $aKeywords[$i][1], $aKeywords[$i][2], $aKeywords[$i][3] ) );
        }
      }
    }
    usort($aReplace, 'KeywordToLinkContentCompareOrder');

    //---------------------------------------------
    //Replace keywords with their URLs

    $keywords_log = array();

    $i = 0;
    $temp = '';
    $keywordStyle = '';

    if(KeywordToLink::getInstance()->settings->getKeywordColor() != '')
      $keywordStyle .= 'color:' . KeywordToLink::getInstance()->settings->getKeywordColor() . ';';

    for ( $j = 0; $j<count($aReplace); $j++ ) {
      $keywordStart = $aReplace[$j][0];
      if ( $keywordStart > $i ) {
        $keywordEnd  = $aReplace[$j][1];
        $keyword     = $aReplace[$j][2];
        $url         = $aReplace[$j][3];
        $originalUrl = $aReplace[$j][4];
        $title       = $aReplace[$j][5];

        if(isset($keywords_log[$keyword])
            && $keywords_log[$keyword] >= KeywordToLink::getInstance()->settings->getMaximumEachKeywordsAllowedPerPage()
            && KeywordToLink::getInstance()->settings->getMaximumEachKeywordsAllowedPerPage() != 0)
          continue;

        if(array_sum($keywords_log) >= KeywordToLink::getInstance()->settings->getMaximumKeywordsAllowedPerPage()
            && KeywordToLink::getInstance()->settings->getMaximumKeywordsAllowedPerPage() != 0)
          continue;

        $keywords_log[$keyword] = isset($keywords_log[$keyword]) ? $keywords_log[$keyword] + 1 : 1;

        $temp .= substr( $content, $i, $keywordStart - $i );
        $urlSuffix = '';

        $urlSuffix = 'http://';

        if ( strpos( $url, '@' ) !== false ) {
          $urlSuffix = 'mailto:';
        }

        if(strpos($url, 'http://') === 0
            || strpos($url, 'https://') === 0)
          $urlSuffix = '';

        $finalLink = KeywordToLink::getInstance()->settings->getTrackClicksAndHideLinks() ? $urlSuffix . $url : $originalUrl;

        if(KeywordToLink::getInstance()->settings->getAllowKeywordLinkingToCurrentPage() == 0
            && get_permalink( $post->ID ) == $originalUrl)
            $temp .= $keyword;
        else
          $temp .= '<a ' . ($title != '' ? ('title="' . $title . '"') : '') .
                       ' target="' . KeywordToLink::getInstance()->settings->getLinkOpenMethod() . '"' .
                       ' href="' . $finalLink . '" ' .
                       ($keywordStyle != '' ? 'style="' . $keywordStyle . '" ' : '') .
                       '>' . $keyword . '</a>';

        $i = $keywordEnd + 1;
      }
    }

    $temp .= substr( $content, $i );

    foreach($keywords_db as $keyword) {
      if(strpos($temp, $url_prefix . KeywordToLink::getInstance()->keywordLinkIdentifier . '=' . urlencode($keyword->keyword)) !== false)
        KeywordToLink::getInstance()->database->insertLinkDisplay(array(
            'link_id'     =>  $keyword->id,
            'ip_address'  =>  $_SERVER['REMOTE_ADDR']
        ));
    }

    return ( $temp );
  }

}

function KeywordToLinkContentCompareOrder( $a, $b ) {
  $retval = $a[0] - $b[0];
  if( !$retval ) {
    return $b[1] - $a[1];
  }
  return $retval;
}