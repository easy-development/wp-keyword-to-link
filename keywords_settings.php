<?php

$response = array();

if(isset($_POST['keyword_to_link_open_method'])) {
  KeywordToLink::getInstance()->settings->setLinkOpenMethod($_POST['keyword_to_link_open_method']);
  KeywordToLink::getInstance()->settings->setAllowH1Tag($_POST['allow_h1']);
  KeywordToLink::getInstance()->settings->setAllowH2Tag($_POST['allow_h2']);
  KeywordToLink::getInstance()->settings->setAllowH3Tag($_POST['allow_h3']);
  KeywordToLink::getInstance()->settings->setAllowH4Tag($_POST['allow_h4']);
  KeywordToLink::getInstance()->settings->setAllowH5Tag($_POST['allow_h5']);

  KeywordToLink::getInstance()->settings->setAllowKeywordLinkingToCurrentPage(intval($_POST['allow_keyword_linking_to_current_page']));

  KeywordToLink::getInstance()->settings->setMaximumKeywordsAllowedPerPage(intval($_POST['maximum_allowed_keywords_per_page']));
  KeywordToLink::getInstance()->settings->setMaximumEachKeywordsAllowedPerPage(intval($_POST['maximum_allowed_each_keywords_per_page']));

  KeywordToLink::getInstance()->settings->setTrackClicksAndHideLinks(intval($_POST['track_clicks_and_hide_links']));

  KeywordToLink::getInstance()->settings->setGroupByLinks(intval($_POST['group_by_links']));

  KeywordToLink::getInstance()->settings->setKeywordHasSpaceSeparator($_POST['keyword_has_space_separator']);

  KeywordToLink::getInstance()->settings->setKeywordColor($_POST['keyword_color']);

  KeywordToLink::getInstance()->settings->setTheContentFilterPriority($_POST['the_content_filter_priority']);

  $response['success'][] = __('All your changes have been updated');
}

if(isset($response['errors']))
  foreach($response['errors'] as $error)
    echo '<div class="alert alert-danger">' . $error . '</div>';
if(isset($response['notifications']))
  foreach($response['notifications'] as $notification)
    echo '<div class="alert alert-info">' . $notification . '</div>';
if(isset($response['success']))
  foreach($response['success'] as $success)
    echo '<div class="alert alert-success">' . $success . '</div>';
if(isset($response['warnings']))
  foreach($response['warnings'] as $warning)
    echo '<div class="alert alert-warning">' . $warning . '</div>';

?>

<div class="container">
  <form method="POST">
    <div class="form-group">
      <label for="keyword_to_link_open_method"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Link Opening Method
      </label>
      <div class="col-sm-6">
        <select id="keyword_to_link_open_method" name="keyword_to_link_open_method" class="form-control">
          <?php foreach(KeywordToLink::getInstance()->settings->getLinkOpenMethodOptions() as $alias => $description) : ?>
          <option value="<?php echo $alias;?>"
                  <?php echo $alias == KeywordToLink::getInstance()->settings->getLinkOpenMethod() ? 'selected="selected"' : '';?>
              >
            <?php echo  __($description) . ' ( ' . __($alias) . ' ) ';?>
          </option>
          <?php endforeach;?>
        </select>
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label for="keyword_to_link_allow_h1"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Replace if within H1
      </label>
      <div class="col-sm-6">
        <input type="hidden" name="allow_h1" value="0"/>
        <input type="checkbox" name="allow_h1" value="1" <?php echo KeywordToLink::getInstance()->settings->getAllowH1Tag() == 1 ? 'checked="checked"' : '';?>/>
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label for="keyword_to_link_allow_h2"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Replace if within H2
      </label>
      <div class="col-sm-6">
        <input type="hidden" name="allow_h2" value="0"/>
        <input type="checkbox" name="allow_h2" value="1" <?php echo KeywordToLink::getInstance()->settings->getAllowH2Tag() == 1 ? 'checked="checked"' : '';?>/>
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label for="keyword_to_link_allow_h3"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Replace if within H3
      </label>
      <div class="col-sm-6">
        <input type="hidden" name="allow_h3" value="0"/>
        <input type="checkbox" name="allow_h3" value="1" <?php echo KeywordToLink::getInstance()->settings->getAllowH3Tag() == 1 ? 'checked="checked"' : '';?>/>
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label for="keyword_to_link_allow_h4"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Replace if within H4
      </label>
      <div class="col-sm-6">
        <input type="hidden" name="allow_h4" value="0"/>
        <input type="checkbox" name="allow_h4" value="1" <?php echo KeywordToLink::getInstance()->settings->getAllowH4Tag() == 1 ? 'checked="checked"' : '';?>/>
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label for="keyword_to_link_allow_h5"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Replace if within H5
      </label>
      <div class="col-sm-6">
        <input type="hidden" name="allow_h5" value="0"/>
        <input type="checkbox" name="allow_h5" value="1" <?php echo KeywordToLink::getInstance()->settings->getAllowH5Tag() == 1 ? 'checked="checked"' : '';?>/>
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label for="keyword_to_link_allow_h5"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Track Clicks & Hide Links
      </label>
      <div class="col-sm-6">
        <input type="hidden" name="track_clicks_and_hide_links" value="0"/>
        <input type="checkbox" name="track_clicks_and_hide_links" value="1" <?php echo KeywordToLink::getInstance()->settings->getTrackClicksAndHideLinks() == 1 ? 'checked="checked"' : '';?>/>
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label for="keyword_to_link_allow_h5"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Transform Keywords that link to the current page
      </label>
      <div class="col-sm-6">
        <input type="hidden" name="allow_keyword_linking_to_current_page" value="0"/>
        <input type="checkbox" name="allow_keyword_linking_to_current_page" value="1" <?php echo KeywordToLink::getInstance()->settings->getAllowKeywordLinkingToCurrentPage() == 1 ? 'checked="checked"' : '';?>/>
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label for="group_by_links"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Require Space between keywords
      </label>
      <div class="col-sm-6">
        <input type="hidden" name="keyword_has_space_separator" value="0"/>
        <input type="checkbox" name="keyword_has_space_separator" value="1" <?php echo KeywordToLink::getInstance()->settings->getKeywordHasSpaceSeparator() == 1 ? 'checked="checked"' : '';?>/>
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label for="group_by_links"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Group Keywords By Links
      </label>
      <div class="col-sm-6">
        <input type="hidden" name="group_by_links" value="0"/>
        <input type="checkbox" name="group_by_links" value="1" <?php echo KeywordToLink::getInstance()->settings->getGroupByLinks() == 1 ? 'checked="checked"' : '';?>/>
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label class="col-sm-6 control-label" style="margin-top: 8px;font-size: 120%">The Content Filter Priority</label>
      <div class="col-sm-6">
        <input type="text" name="the_content_filter_priority" value="<?php echo KeywordToLink::getInstance()->settings->getTheContentFilterPriority();?>">
        <br/>
        | If this plugin isn't properly working with others, just change the priority higher or lower.
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label for="maximum_allowed_keywords_per_page"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Maximum Allowed Keywords Per Page
      </label>
      <div class="col-sm-6">
        <input type="text"
               name="maximum_allowed_keywords_per_page"
               value="<?php echo KeywordToLink::getInstance()->settings->getMaximumKeywordsAllowedPerPage();?>"
            />
        <p>For "unlimited", you can use 0</p>
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label for="maximum_allowed_each_keywords_per_page"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Maximum Allowed Each Keywords Per Page
      </label>
      <div class="col-sm-6">
        <input type="text"
               name="maximum_allowed_each_keywords_per_page"
               value="<?php echo KeywordToLink::getInstance()->settings->getMaximumEachKeywordsAllowedPerPage();?>"
            />
        <p>For "unlimited", you can use 0</p>
      </div>
    </div>

    <div class="clear"></div>

    <div class="form-group">
      <label for="keyword_color"
             style="margin-top: 8px;font-size: 120%"
             class="col-sm-6 control-label">
        Keyword Color
      </label>
      <div class="col-sm-6 colorpicker-container">
        <input type="text"
               class="colorpicker"
               name="keyword_color"
               value="<?php echo KeywordToLink::getInstance()->settings->getKeywordColor();?>"
            />
        <p>Leave this field empty to not add any color.</p>
      </div>
    </div>

    <div class="clear"></div>

    <br/>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-6">
        <button type="submit" class="btn btn-success">Update &raquo;</button>
      </div>
    </div>
  </form>
</div>

<style>
  .box-sizing-normal *,
  .colorpicker-container *,
  .colorpicker-container *:after,
  .colorpicker-container *:before {
    -webkit-box-sizing: content-box !important;
    -moz-box-sizing: content-box !important;
    box-sizing: content-box !important;
  }
</style>