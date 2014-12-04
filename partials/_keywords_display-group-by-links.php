<?php $keywords_information_grouped = KeywordToLink_Helper_Object::mapByParam($keywords_information, 'url', true, true);?>

<input type="hidden" name="keyword_to_link_link_new_bidimensional" value="1">
<table class="table table-bordered table-striped keyword_to_link-table">
  <?php foreach($keywords_information_grouped as $keywords_link => $keywords_information) : ?>
    <thead>
      <tr>
        <td colspan="6" class="text-center"><?php echo $keywords_link;?></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="keyword_to_link-bulk-mark"/></td>
        <td>Name</td>
        <td>Title</td>
        <td>Displayed</td>
        <td>Clicks Generated</td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach($keywords_information as $keyword) : ?>
        <tr id="ap-information-<?php echo $keyword->id;?>">
          <td style="width:34px;"><input type="checkbox" name="keyword_to_link-bulk[]" value="<?php echo $keyword->id;?>"/></td>
          <td><?php echo $keyword->keyword;?></td>
          <td><?php echo $keyword->title;?></td>
          <td><?php echo $keyword->display_count;?></td>
          <td><?php echo strpos($keyword->url, '@') !== false || KeywordToLink::getInstance()->settings->getTrackClicksAndHideLinks() == false ? __('Not Tracked') : $keyword->click_count;?></td>
          <td style="width: 150px;">
            <a class="btn btn-primary btn-sm open-edit" entry-id="<?php echo $keyword->id;?>">Edit &raquo;</a>
            <input type="submit" class="btn btn-danger btn-sm" name="keyword_to_link-delete[<?php echo $keyword->id;?>]" value="Delete &raquo;">
          </td>
        </tr>
        <tr id="ap-edit-<?php echo $keyword->id;?>" style="display: none">
          <td></td>
          <td><input type="text" style="width:100%" name="keyword_to_link_link[<?php echo $keyword->id?>][keyword]" value="<?php echo $keyword->keyword;?>"></td>
          <td><?php echo $keyword->display_count;?></td>
          <td><?php echo strpos($keyword->url, '@') !== false || KeywordToLink::getInstance()->settings->getTrackClicksAndHideLinks() == false ? __('Not Tracked') : $keyword->click_count;?></td>
          <td style="width: 150px;">
            <input type="submit" class="btn btn-success btn-sm" name="keyword_to_link-update[<?php echo $keyword->id;?>]" value="Save &raquo;">
            <a class="btn btn-default btn-sm close-edit" entry-id="<?php echo $keyword->id;?>">Close &raquo;</a>
          </td>
        </tr>
      <?php endforeach;?>
      <tr>
        <td></td>
        <td>
          <input type="text" style="width:100%" name="keyword_to_link_link_new[<?php echo $keywords_link;?>][keyword]"/>
          <input type="hidden" name="keyword_to_link_link_new[<?php echo $keywords_link;?>][url]" value="<?php echo $keywords_link;?>"/>
        </td>
        <td>
          <input type="text" style="width:100%" name="keyword_to_link_link_new[<?php echo $keywords_link;?>][title]"/>
        </td>
        <td>-</td>
        <td>-</td>
        <td style="width: 200px;">
          <input type="submit" class="btn btn-success btn-sm" name="keyword_to_link-new" style="margin:0 20px;" value="Add New &raquo;">
        </td>
      </tr>
    </tbody>
    <?php if(count($keywords_information) > 10) : ?>
      <tfoot>
        <tr>
          <td>Name</td>
          <td>Title</td>
          <td>Link</td>
          <td>Displayed</td>
          <td>Clicks Generated</td>
          <td></td>
        </tr>
      </tfoot>
    <?php endif;?>

  <?php endforeach;?>

  <thead>
    <tr>
      <td colspan="6" class="text-center">New Link Group</td>
    </tr>
    <tr>
      <td></td>
      <td>Name</td>
      <td>Title</td>
      <td colspan="2">Link</td>
      <td></td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td></td>
      <td><input type="text" style="width:100%" name="keyword_to_link_link_new[new][keyword]"></td>
      <td><input type="text" style="width:100%" name="keyword_to_link_link_new[new][title]"></td>
      <td colspan="2"><input type="text" style="width:100%" name="keyword_to_link_link_new[new][url]"></td>
      <td style="width: 200px;">
        <input type="submit" class="btn btn-success btn-sm" name="keyword_to_link-new" style="margin:0 20px;" value="Add New &raquo;">
      </td>
    </tr>
  </tbody>
</table>
