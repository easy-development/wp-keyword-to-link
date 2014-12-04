jQuery(document).ready(function(){
  var container = jQuery('.bootstrap_enviorement');

  container.find('.colorpicker').not('.triggered').addClass('triggered').wpColorPicker();
});