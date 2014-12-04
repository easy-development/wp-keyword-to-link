<?php

$response = array();

if(isset($_POST['keyword_to_link-new'])) {
  $insertKeywordList = array();

  if(isset($_POST['keyword_to_link_link_new_bidimensional']))
    $insertKeywordList = $_POST['keyword_to_link_link_new'];
  else
    $insertKeywordList[] = $_POST['keyword_to_link_link_new'];

  foreach($insertKeywordList as $insert_information) {
    $insert_information['keyword'] = trim($insert_information['keyword']);

    $existing_information = KeywordToLink::getInstance()->database->getLinkByKeyword($insert_information['keyword']);

    if($insert_information['keyword'] == '') {
      if(!isset($_POST['keyword_to_link_link_new_bidimensional']))
        $response['errors'][] = 'Your keyword cannot be empty';
    } elseif(empty($existing_information)) {
      KeywordToLink::getInstance()->database->insertLink($insert_information);
      $response['success'][] = 'Added Keyword "' . $insert_information['keyword']. '"';
    } else {
      $response['errors'][] = 'Keyword "' . $insert_information['keyword']. '" already exists - Not Added';
    }
  }
}elseif(isset($_POST['keyword_to_link-update'])) {
  $arrayKeysOfUpdate = array_keys($_POST['keyword_to_link-update']);
  $to_update = array_shift($arrayKeysOfUpdate);
  $update_information = $_POST['keyword_to_link_link'][$to_update];
  $update_information['keyword'] = trim($update_information['keyword']);

  $existing_information  = KeywordToLink::getInstance()->database->getLinkByKeyword($update_information['keyword']);
  $to_update_information = KeywordToLink::getInstance()->database->getLinkById($to_update);


  if($update_information['keyword'] == '')
    $response['errors'][] = 'Keyword "' . $update_information['keyword']. '" cannot be empty';
  elseif(empty($existing_information) || $existing_information->id == $to_update) {
    KeywordToLink::getInstance()->database->updateLink($update_information, $to_update);
    $response['success'][] = 'Updated Keyword "' . $update_information['keyword']. '"';
  } else {
    $response['errors'][] = 'Keyword "' . $update_information['keyword']. '" already exists - "' . $to_update_information->keyword .'" was not updated';
  }
}elseif(isset($_POST['keyword_to_link-delete'])) {

  $deleteKeys = array_keys($_POST['keyword_to_link-delete']);
  foreach($deleteKeys as $toDelete) {
    $delete_information = $_POST['keyword_to_link_link'][$toDelete];

    KeywordToLink::getInstance()->database->deleteLink($toDelete);
    $response['warnings'][] = 'Deleted Keyword "' . $delete_information['keyword']. '"';
  }
}elseif(isset($_POST['keyword_to_link-bulk-delete'])) {
  $deleteKeys = $_POST['keyword_to_link-bulk'];
  foreach($deleteKeys as $toDelete) {
    $delete_information = $_POST['keyword_to_link_link'][$toDelete];

    KeywordToLink::getInstance()->database->deleteLink($toDelete);
    $response['warnings'][] = 'Deleted Keyword "' . $delete_information['keyword']. '"';
  }
}

$keywords_information = KeywordToLink::getInstance()->database->getAllLinksWithInformation();

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
// Do more rendering to avoid the wordpress annoying ajax sistem while making the script be more fun
?>

<form method="POST" id="keyword_to_link_form">
  <input type="submit" name="keyword_to_link-bulk-delete" value="Bulk Delete &raquo;" class="btn btn-danger bulk-operation" style="display: none;">
  <div class="clear"></div>
  <br/>
  <?php if(KeywordToLink::getInstance()->settings->getGroupByLinks() == 0) : ?>
    <?php require_once("partials/_keywords_display-classic.php");?>
  <?php else : ?>
    <?php if(count($keywords_information) == 0) : ?>
      <div class="alert alert-info">
        <?php echo __("Add at least a keyword in order to activate the group by links feature"); ?>
      </div>
      <?php require_once("partials/_keywords_display-classic.php");?>
    <?php else : ?>
      <?php require_once("partials/_keywords_display-group-by-links.php");?>
    <?php endif;?>
  <?php endif;?>
</form>

<script>
  var form = jQuery('#keyword_to_link_form');

  form.find('a.close-edit').bind('click', function(event){
    event.preventDefault();

    jQuery('#ap-edit-' + jQuery(this).attr('entry-id')).hide();
    jQuery('#ap-information-' + jQuery(this).attr('entry-id')).show();
  });

  form.find('a.open-edit').bind('click', function(event){
    event.preventDefault();

    jQuery('#ap-edit-' + jQuery(this).attr('entry-id')).show();
    jQuery('#ap-information-' + jQuery(this).attr('entry-id')).hide();
  });

  form.find('input[name="keyword_to_link-bulk-mark"]').bind('click change', function(event){
    var bulkCheckboxes = jQuery(this).parents("thead:first").next().find('input[name="keyword_to_link-bulk[]"]');

    if(jQuery(this).is(":checked"))
      bulkCheckboxes.attr("checked", "checked");
    else
      bulkCheckboxes.removeAttr("checked");

    bulkCheckboxes.first().trigger("click").trigger("click");
  });

  form.find('input[name="keyword_to_link-bulk[]"]').bind('click change', function(event){
    if(form.find('input[name="keyword_to_link-bulk[]"]:checked').length > 0) {
      form.find(".bulk-operation").stop().fadeIn("slow");
    } else {
      form.find(".bulk-operation").stop().fadeOut("slow");
      form.find('input[name="keyword_to_link-bulk-mark"]').removeAttr("checked");
    }
  });

  form.find("table.tablesorter").tablesorter({
    theme : 'blue',
    cssInfoBlock : "avoid-sort",
    widgets: [ 'zebra' ],
    headers: {
      0: {sorter: false},
      6: {sorter: false}
    }
  });


</script>