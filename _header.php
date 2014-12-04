<div role="navigation" class="navbar navbar-default">
    <div class="navbar-header">
      <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="?page=<?php echo KeywordToLink::getInstance()->scriptAlias;?>" class="navbar-brand">
        <?php echo KeywordToLink::getInstance()->scriptName;?>
      </a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li style="margin-bottom: 0;" class="<?php echo (!isset($_GET['sub_page']) || $_GET['sub_page'] == 'main') ? 'active' : ''?>">
          <a href="?page=<?php echo KeywordToLink::getInstance()->scriptAlias;?>">Keywords</a>
        </li>
        <li style="margin-bottom: 0;" class="<?php echo (isset($_GET['sub_page']) && $_GET['sub_page'] == 'settings') ? 'active' : ''?>">
          <a href="?page=<?php echo KeywordToLink::getInstance()->scriptAlias;?>&sub_page=settings">Settings</a>
        </li>
        <li style="margin-bottom: 0;" class="<?php echo (isset($_GET['sub_page']) && $_GET['sub_page'] == 'statistics') ? 'active' : ''?>">
          <a href="?page=<?php echo KeywordToLink::getInstance()->scriptAlias;?>&sub_page=statistics">Keywords Statistics</a>
        </li>
      </ul>
    </div>
</div>