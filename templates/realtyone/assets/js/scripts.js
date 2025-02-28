

/*
$(function () {
  $('input')
    .on('change', function (event) {
      var $element = $(event.target);
      var $container = $element.closest('.example');

      if (!$element.data('tagsinput')) return;

      var val = $element.val();
      if (val === null) val = 'null';
      var items = $element.tagsinput('items');

      $('code', $('pre.val', $container)).html(
        $.isArray(val)
          ? JSON.stringify(val)
          : '"' + val.replace('"', '\\"') + '"'
      );
      $('code', $('pre.items', $container)).html(
        JSON.stringify($element.tagsinput('items'))
      );
    })
    .trigger('change');
});
*/

$(".form-check").click(function(e){
  e.stopPropagation();
  e.preventDefault();
  var a = $(e.currentTarget).find("input");
  if ($(a).attr("type") == "checkbox") {
    if ($(a).attr("checked") == "checked") $(a).removeAttr("checked");
    else $(a).attr("checked", true);
  } else if ($(a).attr("type") == "radio" && $(a).attr("name") != "") {
    var name = $(a).attr("name");
    $(".form-check input[name="+name+"]").removeAttr("checked");
    $(a).attr("checked", true);
  }
});
$(".checkbox-list").click(function(e){
  e.stopPropagation();
  e.preventDefault();
  return false;
});

$(".multiple-checkbox.drowdown-options-mobile").click(function(e){
  $(".drowdown-options-mobile-container").slideToggle();
});

$(".multiple-checkbox.drowdown-options").click(function(e){
  $(".checkbox-list").not($(e.currentTarget).find(".checkbox-list")).hide();
  $(e.currentTarget).find(".checkbox-list").slideToggle();
});

var btn = $('#button');

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});