(function ( app ) {

app.views.ImageUpload = app.mixins.View.extend({
  template: _.template($("#image_upload_template").html()),
  myEvents: {
    "click .aceptar":"aceptar",
    "click .cerrar":"cerrar",
  },
  initialize: function(options) {
    $(this.el).html(this.template());
    this.url = options.url;
    this.name = (options.name != undefined) ? options.name : "images";
    this.images = new Array();
    this.render();
  },
  render: function() {
    var self = this;
    this.$('#fileupload').fileupload({
      url: self.url,
      dataType: 'json',
      done: function (e, data) {
        $.each(data.result.files, function (index, file) {
          self.images.push(file.url);
          $('<p/>').text(file.name).appendTo('#files');
        });
      },
      progressall: function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
          'width',
          progress + '%'
        );
      }
    }).prop('disabled', !$.support.fileInput)
      .parent().addClass($.support.fileInput ? undefined : 'disabled');
  },
  aceptar:function() {
    var self = this;
    var im = this.model.get(self.name);
    for(var i=0;i<this.images.length;i++) {
      var image = this.images[i];
      var pos = image.indexOf("uploads/");
      image = image.substr(pos);
      im.push(image);
    }
    var obj = {};
    obj[self.name] = im;
    this.model.set(obj);
    this.model.trigger("change_table");
    this.cerrar();
  },
  cerrar: function() {
    $('.modal:last').modal('hide');
  }

});

})(app);
