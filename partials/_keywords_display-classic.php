<table id="main-table" class="table table-bordered table-striped keyword_to_link-table tablesorter">
  <thead>
  <tr>
    <th><input type="checkbox" name="keyword_to_link-bulk-mark"/></th>
    <th>Name</th>
    <th>Title</th>
    <th>Link</th>
    <th>Displayed</th>
    <th>Clicks Generated</th>
    <th></th>
  </tr>
  </thead>
  <?php if(count($keywords_information) > 15) : ?>
  <tbody class="avoid-sort">
    <tr>
      <td></td>
      <td><input type="text" style="width:100%" name="keyword_to_link_link_new[keyword]"></td>
      <td><input type="text" style="width:100%" name="keyword_to_link_link_new[title]"></td>
      <td><input type="text" style="width:100%" name="keyword_to_link_link_new[url]"></td>
      <td>-</td>
      <td>-</td>
      <td style="width: 200px;">
        <input type="submit" class="btn btn-success btn-sm" name="keyword_to_link-new" style="margin:0 20px;" value="Add New &raquo;">
      </td>
    </tr>
  </tbody>
  <?php endif;?>
  <tbody>
  <?php foreach($keywords_information as $keyword) : ?>
    <tr id="ap-information-<?php echo $keyword->id;?>">
      <td><input type="checkbox" name="keyword_to_link-bulk[]" value="<?php echo $keyword->id;?>"/></td>
      <td><?php echo $keyword->keyword;?></td>
      <td><?php echo $keyword->title;?></td>
      <td><?php echo $keyword->url;?></td>
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
      <td><input type="text" style="width:100%" name="keyword_to_link_link[<?php echo $keyword->id?>][title]" value="<?php echo $keyword->title;?>"></td>
      <td><input type="text" style="width:100%" name="keyword_to_link_link[<?php echo $keyword->id?>][url]" value="<?php echo $keyword->url;?>"></td>
      <td><?php echo $keyword->display_count;?></td>
      <td><?php echo strpos($keyword->url, '@') !== false || KeywordToLink::getInstance()->settings->getTrackClicksAndHideLinks() == false ? __('Not Tracked') : $keyword->click_count;?></td>
      <td style="width: 150px;">
        <input type="submit" class="btn btn-success btn-sm" name="keyword_to_link-update[<?php echo $keyword->id;?>]" value="Save &raquo;">
        <a class="btn btn-default btn-sm close-edit" entry-id="<?php echo $keyword->id;?>">Close &raquo;</a>
      </td>
    </tr>
  <?php endforeach;?>
  </tbody>
  <?php if(count($keywords_information) <= 15) : ?>
  <tbody class="avoid-sort">
    <tr>
      <td></td>
      <td><input type="text" style="width:100%" name="keyword_to_link_link_new[keyword]"></td>
      <td><input type="text" style="width:100%" name="keyword_to_link_link_new[title]"></td>
      <td><input type="text" style="width:100%" name="keyword_to_link_link_new[url]"></td>
      <td>-</td>
      <td>-</td>
      <td style="width: 200px;">
        <input type="submit" class="btn btn-success btn-sm" name="keyword_to_link-new" style="margin:0 20px;" value="Add New &raquo;">
      </td>
    </tr>
  </tbody>
  <?php endif;?>
  <?php if(count($keywords_information) > 10) : ?>
  <tfoot>
  <tr>
    <td></td>
    <td>Name</td>
    <td>Title</td>
    <td>Link</td>
    <td>Displayed</td>
    <td>Clicks Generated</td>
    <td></td>
  </tr>
  </tfoot>
  <?php endif;?>
</table>
