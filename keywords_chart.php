<?php $time_to = time();
      $time_from = time() - 1296000;

      $keywords = KeywordToLink::getInstance()->database->getAllLinksWithInformation();
      $keyword_ids = array();

      foreach($keywords as $keyword)
        $keyword_ids[] = $keyword->id;

      $link_statistics = KeywordToLink::getInstance()->database->getAllLinksClicksMAPForInterval($time_from, $time_to, $keyword_ids);

      $display_information = array();
      $first_line = array();

      foreach($link_statistics as $link_date => $link_statistic) {
        $to_add = date('F d, Y', strtotime($link_date));

        $current_day_sum = 0;

        foreach($keywords as $keyword)
          $current_day_sum += (isset($link_statistic[$keyword->id]) ? $link_statistic[$keyword->id] : 0);

        $to_add .= "\t " . $current_day_sum;

        foreach($keywords as $keyword)
          $to_add .= "\t" . (isset($link_statistic[$keyword->id]) ? $link_statistic[$keyword->id] : 0);

        $display_information[$link_date] = $to_add;
      }

      ksort($display_information);

      $display_information = implode("\n", $display_information);
?>

<div id="highcharts_information_container" style="display: none"><?php echo $display_information; ?></div>
<div id="highcharts_information">

</div>

<script>
  LayoutHelperEasyChart.SetInformation(
      'highcharts_information',
      'Generated Clicks',
      '<?php echo date('F d, Y', $time_from) .' - ' . date('F d, Y', $time_to);?>',
      ['Everything' <?php foreach($keywords as $keyword) echo ", '" . $keyword->keyword. "'"?>]
  );

  LayoutHelperEasyChart.SetInformationLines(jQuery('#highcharts_information_container').html());
</script>

