(function(){

  window.app = {};
  app.collections = {};
  app.models = {};
  app.views = {};
  app.mixins = {};
  app.modules = {}; // Referencia a todos los modulos del sistema

  $(document).ready(function() {

    var Workspace = Backbone.Router.extend({
      
      // Define todas las rutas de la aplicacion
      // tiene un comportamiento por defecto que puede ser sobreescrito
      // Si existe una funcion con el mismo nombre que el modulo, se sobreescribe
      // sino funciona con la siguiente logica:
      // :mod indica el nombre del modulo
      // :id es el ID del elemento
      // Ej:
      // modulo/    listado
      // modulo/0   nuevo
      // modulo/1   editar
      routes: {

        // REGLAS DE EXCEPCIONES
        "ver_proyecto/:id":function(id) {
          this.ver_empresas(id);
        },
        "nuevo_proyecto/:id":function(id) {
          this.nueva_empresa(id);
        },

        // Configuracion de la web
        "menu_web(/)": "ver_web", // DESP ELIMINAR
        "web(/)": "ver_web",
        "web/:id(/)": "ver_web",

        // Consultas vencidas
        "consultas_vencidas(/)": "ver_consultas_vencidas",

        // Edicion de plantilla
        "editar_template(/)": "ver_editar_template",

        // Configuracion General
        "configuracion_menu(/)": "ver_configuracion", // DESP ELIMINAR
        "configuracion(/)": "ver_configuracion",
        "configuracion/:id(/)": "ver_configuracion",

        // Tutoriales
        "tutoriales(/)": "ver_tutoriales",
        "tutoriales/:id(/)": "ver_tutoriales",

        // Permisos de la RED
        "permisos_red(/)": "ver_permisos_red",
        "permisos_red/:id(/)": "ver_permisos_red",
        "solicitudes_pendientes(/)": "ver_solicitudes_pendientes",

        "alquileres(/)": "ver_alquileres",
        "recibos_alquileres": function() { this.ver_recibos_alquileres(0); },
        "recibos_alquileres/:estado": "ver_recibos_alquileres",

        // 
        "contacto_acciones/:id": "ver_contacto_acciones",

        "mi_cuenta(/)": "ver_mi_cuenta",
        "precios(/)": "ver_precios",

        // Cuentas corrientes de clientes
        "cuentas_corrientes_clientes": "ver_cuentas_corrientes_clientes",
        "cuentas_corrientes_clientes/:id": "ver_cuentas_corrientes_clientes",        

        "facturacion": "ver_facturacion",
        "facturacion/:id": "ver_facturacion",
        "comprobante/:id/:id_punto_venta": "ver_comprobante",

        "cajas": "ver_cajas",
        "cajas/:todas": "ver_cajas",
        "caja": "ver_caja",
        "caja/:id": "ver_caja",
        "ver_cajas_movimientos/:id_caja": "ver_cajas_movimientos",

        "videos": "ver_videos",
        "video": "ver_video",
        "video/:id": "ver_video",        

        "clientes": "ver_clientes",
        "inquilinos": "ver_inquilinos",
        "propietarios": "ver_propietarios",

        "versiones_db": "ver_versiones_db",
        "version_db": "ver_version_db",
        "version_db/:id": "ver_version_db",

        "novedades": "ver_novedades",
        "novedad": "ver_novedad",
        "novedad/:id": "ver_novedad",        

        // Funcionamiento de ABM General
        '': 'router',
        ':mod(/)': 'router',
        ':mod/:id(/)': 'router',    
      },

      // Funcion principal
      router: function(mod, id) {
        var self = this;
        mod = mod || 'inicio'; // Por defecto
        if (typeof(this[mod]) != "undefined") {
          // Si la funcion que estamos llamando esta definida, la llamamos
          this[mod](id);
          return;
        }

        // Calculamos el permiso a ese modulo
        var permiso = 3;
        //var permiso = control.check(mod);
        //if (permiso <= 0) return; // No lo dejamos continuar

        mod = ucfirst(mod); // Primera en mayuscula
        if (id == undefined) {

          // Si existe una pagina unica para ese modulo
          if (typeof app.views[mod+"SingleView"] != "undefined") {

            // Si existe un modelo especifico, sino ponemos el generico
            var modelo = new app.models.AbstractModel();
            if (typeof app.models[mod] != "undefined") {
              modelo = new app.models[mod]();
            }
            var view = new app.views[mod+"SingleView"]({
              model: modelo,
              permiso: permiso,
            });
          } else {
            // Es un LISTADO
            var view = new app.views[mod+"TableView"]({
              collection: new app.collections[mod](),
              permiso: permiso,
            });            
          }
          this.mostrar({
            "top" : view.el,
          });

        } else if (id == 0) {
          // Es un elemento NUEVO
          let view = new app.views[mod+"EditView"]({
            model: new app.models[mod](),
            permiso: permiso
          });
          this.mostrar({
            "top" : view.el,
          });

        } else if (id != 0) {
          // EDICION
          var modelo = new app.models[mod]({ "id": id });
          console.log(modelo);
          modelo.fetch({
            "success":function() {
              var view = new app.views[mod+"EditView"]({
                model: modelo,
                permiso: permiso
              });
              self.mostrar({
                "top" : view.el,
              });
            }
          });
        }
      },

      // ==========================================
      // FUNCIONES DE EXCEPCIONES

      mostrar_notificaciones() {
        if ($("#notification_panel").is(":visible")) {
          $("#notification_panel").hide();
          return;
        }
        $("#notification_panel").show();
        $("#notification_panel .list-group").empty();
        $.ajax({
          "url":"notificaciones/function/buscar/",
          "dataType":"json",
          "success":function(r) {
            for(var i=0;i<r.results.length;i++) {
              var n = r.results[i];
              var el = new app.views.NotificacionItem({
                "model":new app.models.AbstractModel(n),
              });
              $("#notification_panel .list-group").append(el.el);
            }
            if (r.results.length > 0) {
              $(".notification_quantity").show();
              $(".notification_quantity").html(r.results.length);
            } else {
              $(".notification_quantity").html("");
              $(".notification_quantity").hide();
            }
          },
        });
      },

      ver_cuentas_corrientes_clientes : function(id) {
        var permiso = 3;
        //if (ID_EMPRESA == 1) {
          var modelo = new app.models.CuentasCorrientesClientes();
          if (typeof id !== "undefined" && id != null) modelo.set({ "id_cliente":id });
          app.views.cuentas_corrientes_clientesResultados = new app.views.CuentasCorrientesClientesResultados({
            permiso: permiso,
            model: modelo,
          });
          this.mostrar({
            "top" : app.views.cuentas_corrientes_clientesResultados.el,
          });
          $("#cuentas_corrientes_clientes_codigo").select();
        //}
      },  

      ver_versiones_db: function() {
        var permiso = control.check("versiones_db");
        if (permiso > 0) {
          window.versiones_db = new app.collections.VersionesDb();
          app.views.versiones_dbTableView = new app.views.VersionesDbTableView({
            collection: window.versiones_db,
            permiso: permiso
          });    
          this.mostrar({
            "top" : app.views.versiones_dbTableView.el,
          });
        }
      },
      ver_version_db: function(id) {
        var self = this;
        var permiso = control.check("versiones_db");
        if (permiso > 0) {
          if (id == undefined) {
            app.views.version_dbEditView = new app.views.VersionDbEditView({
              model: new app.models.VersionDb(),
              permiso: permiso
            });
            this.mostrar({
              "top" : app.views.version_dbEditView.el,
            });
          } else {
            var version_db = new app.models.VersionDb({ "id": id });
            version_db.fetch({
              "success":function() {
                app.views.version_dbEditView = new app.views.VersionDbEditView({
                  model: version_db,
                  permiso: permiso
                });
                self.mostrar({
                  "top" : app.views.version_dbEditView.el,
                });
              }
            });
          }
        }                
      },

      ver_novedades: function() {
        if (PERFIL == -1) {
          window.novedades = new app.collections.Novedades();
          view = new app.views.NovedadesTableView({
            collection: window.novedades,
            novedades: novedades
          });    
          this.mostrar({
            "top" : view.el,
          });
        }
      },
      ver_novedad: function(id) {
        var self = this;
        if (PERFIL == -1) {
          if (id == undefined) {
            view = new app.views.NovedadesEditView({
              model: new app.models.Novedades(),
              permiso: 3
            });
            this.mostrar({
              "top" : view.el,
            });
          } else {
            var novedad = new app.models.Novedades({ "id": id });
            novedad.fetch({
              "success":function() {
                view = new app.views.NovedadesEditView({
                  model: novedad,
                  permiso: 3
                });
                self.mostrar({
                  "top" : view.el,
                });
              }
            });
          }
        }                
      },

      ver_facturacion: function(id) {
        if (ID_EMPRESA == 1) {
          var self = this;
          // Estamos viendo una factura
          if (id != undefined) {
            var modelo = new app.models.Factura({
              "id": id,
            });
            modelo.fetch({
              "success":function() {
                app.views.facturaEditView = new app.views.FacturaEditView({
                  model: modelo,
                  permiso: 3,
                  id_modulo: "facturas"
                });
                var conf = {
                  "top" : app.views.facturaEditView.el,
                };
                self.mostrar(conf);
              }
            });
            
          // Facturacion nueva
          } else {
            var factura = new app.models.Factura({
              "items":[],
              "tarjetas":[],
              "cheques":[],
              "cotizacion_dolar":(typeof COTIZACION_DOLAR != "undefined" ? COTIZACION_DOLAR : 0),
            });
            if (typeof window.factura_nueva != "undefined") {
              factura = window.factura_nueva;
              delete window.factura_nueva;
            }
            
            app.views.facturaEditView = new app.views.FacturaEditView({
              model: factura,
              permiso: 3,
              id_modulo: "facturas"
            });
            var conf = {
              "top" : app.views.facturaEditView.el,
            };
            self.mostrar(conf);
            $("#facturacion_codigo_cliente").select();  
          }
        }
      },

      ver_comprobante: function(id,id_punto_venta) {
        var perm = 3;
        var self = this;
        $.ajax({
          "url":"facturas/function/ver_comprobante/"+id+"/"+id_punto_venta+"/",
          "dataType":"json",
          "success":function(r){
            var modelo = new app.models.Factura(r);
            var view = null;
            view = new app.views.FacturaEditView({
              model: modelo,
              permiso: perm,
              id_modulo: "facturas"
            });            
            self.mostrar({
              "top" : view.el,
            });
          },
        });
      },      

      ver_clientes: function() {
        var clientes = new app.collections.Clientes();
        window.clientes_custom_3 = 1;
        window.clientes_custom_4 = 0;
        window.clientes_custom_5 = 0;
        var permiso = control.check("contactos");
        if (permiso > 0) {
          var view = new app.views.ClientesTableView({
            collection: clientes,
            permiso: permiso,
          });    
          this.mostrar({
            "top" : view.el,
          });
        }
      },

      ver_inquilinos: function() {
        var clientes = new app.collections.Clientes();
        window.clientes_custom_3 = 0;
        window.clientes_custom_4 = 1;
        window.clientes_custom_5 = 0;
        var permiso = control.check("contactos");
        if (permiso > 0) {
          var view = new app.views.ClientesTableView({
            collection: clientes,
            permiso: permiso,
          });    
          this.mostrar({
            "top" : view.el,
          });
        }
      },

      ver_propietarios: function() {
        var clientes = new app.collections.Clientes();
        window.clientes_custom_3 = 0;
        window.clientes_custom_4 = 0;
        window.clientes_custom_5 = 1;
        var permiso = control.check("contactos");
        if (permiso > 0) {
          var view = new app.views.ClientesTableView({
            collection: clientes,
            permiso: permiso,
          });    
          this.mostrar({
            "top" : view.el,
          });
        }
      },

      ver_cajas: function(todas) {
        var cajas = new app.collections.Cajas();
        if (todas == undefined) window.cajas_ver_todas = 1;
        else window.cajas_ver_todas = -1;
        app.views.cajasTableView = new app.views.CajasTableView({
          collection: cajas,
          permiso: 3,
        });    
        this.mostrar({
          "top" : app.views.cajasTableView.el,
        });
      },
      ver_caja: function(id) {
        var self = this;
        if (id == undefined) {
          app.views.cajaEditView = new app.views.CajaEditView({
            model: new app.models.Caja(),
            permiso: 3
          });
          this.mostrar({
            "top" : app.views.cajaEditView.el,
          });
        } else {
          var caja = new app.models.Caja({ "id": id });
          caja.fetch({
            "success":function() {
              app.views.cajaEditView = new app.views.CajaEditView({
                model: caja,
                permiso: 3
              });
              self.mostrar({
                "top" : app.views.cajaEditView.el,
              });
            }
          });
        }
      },      

      ver_cajas_movimientos: function(id_caja) {
        var view = new app.views.ListadoCajasMovimientosView({
          ver_saldos: 1,
          id_caja: id_caja,
          permiso: 3
        });
        this.mostrar({
          "top" : view.el,
        });
      },

      ver_oportunidades: function() {
        var view = new app.views.OportunidadesTableView({
          collection: new app.collections.Oportunidades(),
          permiso: 3,
        });    
        this.mostrar({
          "top" : view.el,
        });
      },

      ver_precios: function() {
        var precio = new app.views.PreciosView({
          model: new app.models.AbstractModel(),
        });
        this.mostrar({
          "top" : precio.el,
          "mostrar_mensaje_full":0, // Con esto deshabilitamos siempre el mensaje full por si quiere pagar
        });                    
      },

      ver_editar_template: function() {
        var self = this;
        var conf = new app.models.WebConfiguracion({
          "id":ID_EMPRESA
        });
        conf.fetch({
          "success":function(model) {
            var view = new app.views.WebConfiguracionEditView({
              model: model,
              id_modulo: "web_configuracion"
            });
            self.mostrar({
              "top" : view.el,
            });
          }
        });
      },  

      ver_mi_cuenta: function() {
        var self = this;
        $.ajax({
          "url":"empresas/function/get_datos_cuenta/",
          "dataType":"json",
          "success":function(res) {
            var view = new app.views.MiCuentaView({
              model: new app.models.AbstractModel(res)
            });
            self.mostrar({
              "top": view.el,
              "mostrar_mensaje_full":0, // Con esto deshabilitamos siempre el mensaje full por si quiere pagar
            });                    
          }
        });
      },  

      ver_permisos_red: function(id) {
        var self = this;
        var permiso = control.check("permisos_red");
        if (permiso == 0) return;
        var edit = new app.views.PermisosRedView({
          permiso: permiso,
          model: new app.models.AbstractModel(),
          id_inmobiliaria: ((typeof id == "undefined")?0:id),
        });
        self.mostrar({
          "top": edit.el,
        });
      },  

      ver_solicitudes_pendientes: function() {
        var self = this;
        var edit = new app.views.SolicitudesPendientesView({
          model: new app.models.AbstractModel(),
        });
        self.mostrar({
          "top": edit.el,
        });
      },       

      ver_alquileres: function(id) {
        var self = this;
        var permiso = control.check("alquileres");
        if (permiso == 0) return;
        var edit = new app.views.AlquileresTableView({
          collection: new app.collections.Alquileres(),
          permiso: permiso,
        });
        self.mostrar({
          "top": edit.el,
        });
      },  
      ver_recibos_alquileres: function(estado) {
        var estado = ((typeof estado != "undefined") ? estado : 0);
        var permiso = control.check("alquileres");
        if (permiso == 0) return;
        app.views.recibos_alquileresTableView = new app.views.RecibosAlquileresTableView({
          collection: new app.collections.RecibosAlquileres(),
          permiso: permiso,
          estado: estado,
        });    
        this.mostrar({
          "top" : app.views.recibos_alquileresTableView.el,
        });
      },
      ver_alquiler: function(id) {
        var self = this;
        var permiso = control.check("alquileres");
        if (permiso == 0) return;
        if (id == undefined) {
          var alquilerEditView = new app.views.AlquileresEditView({
            model: new app.models.Alquileres(),
            permiso: permiso
          });
          this.mostrar({
            "top" : alquilerEditView.el,
          });
        } else {
          var alquiler = new app.models.Alquiler({ "id": id });
          alquiler.fetch({
            "success":function() {
              var alquilerEditView = new app.views.AlquileresEditView({
                model: alquiler,
                permiso: permiso
              });
              self.mostrar({
                "top" : alquilerEditView.el,
              });
            }
          });
        }
      },  
      
      // Tabla especial que muestra las consultas vencidas
      ver_consultas_vencidas: function() {
        var self = this;
        window.consultas_tipo = -1;
        window.consultas_vencidas = 1;
        var edit = new app.views.ConsultasTableView({
          collection: new app.collections.Consultas(),
        });
        self.mostrar({
          "top" : edit.el,
        });        
      },

      ver_web: function(id) {
        var self = this;
        if (id == undefined) id = "diseno";
        var edit = new app.views.WebSingleView({
          model: new app.models.AbstractModel({
            "id_modulo":id,
          }),
        });
        self.mostrar({
          "top" : edit.el,
        });
      },

      ver_configuracion: function(id) {
        var self = this;
        var permiso = control.check("configuracion_menu");
        if (permiso == 0) return;
        if (id == undefined) id = "datos";
        var edit = new app.views.Configuracion_menuSingleView({
          model: new app.models.AbstractModel({
            "id_modulo":id,
            "permiso":permiso,
          }),
        });
        self.mostrar({
          "top" : edit.el,
        });
      },

      ver_tutoriales: function(id) {
        var self = this;
        if (id == undefined) id = "Propiedades";
        var edit = new app.views.TutorialesSingleView({
          model: new app.models.AbstractModel({
            "id_modulo":id,
          }),
        });
        self.mostrar({
          "top" : edit.el,
        });
      },      

      ver_empresas: function(id_proyecto) {
        var permiso = (PERFIL == -1)?3:0;
        if (permiso > 0) {
          if (id_proyecto == undefined) id_proyecto = 0;
          var empresas = new app.collections.Empresas();
          var view = new app.views.EmpresasTableView({
            collection: empresas,
            permiso: permiso,
            id_proyecto: id_proyecto,
          });    
          this.mostrar({
            "top" : view.el,
          });
        }
      },
      
      nueva_empresa: function(id_proyecto) {
        var self = this;
        var permiso = (PERFIL == -1)?3:0;
        if (permiso > 0) {
          var empresa = new app.models.Empresas({
            "asignado_a":ID_USUARIO,
            "id_proyecto":id_proyecto,
          });
          var view = new app.views.EmpresasEditView({
            model: empresa,
            permiso: permiso
          });
          this.mostrar({
            "top" : view.el,
          });
        }                
      },

      ver_contacto_acciones: function(id) {
        var self = this;
        var permiso = control.check("consultas");
        if (permiso > 0) {
          var contacto = new app.models.Contacto({"id":id});
          contacto.fetch({
            "success":function() {
              var edit = new app.views.ContactoFichaView({
                model: contacto,
                permiso: permiso,
                contacto_tab_principal: "seguimiento", // Abrimos en la parte de seguimiento
              });
              self.mostrar({
                "top" : edit.el,
              });
            }
          });
        }
      },      

      // Antes de cambiar a la siguiente pagina del ROUTER
      before: function () {
        $(".customcomplete.closable").remove(); // Cerramos si hay un customcomplete abierto
      },

      // ==========================================
      // FUNCION PARA MOSTRAR EN EL TEMPLATE

      mostrar: function(params) {
        var self = this;
        // Valores por defecto de los parametros
        params.top || ( params.top = "" );
        params.top_width || ( params.top_width = "100%" );
        if (typeof params.mostrar_mensaje_full == "undefined") params.mostrar_mensaje_full = MENSAJE_CUENTA_NIVEL;
        
        $("#top_container").hide();
        $("#top_container").empty();
        $("#top_container").html(params.top);
        $("#top_container").css("width",params.top_width);
        
        if (params.top === "") $("#top_container").hide();
        else $("#top_container").fadeIn();

        // Si tenemos que mostrar el mensaje full
        if (params.mostrar_mensaje_full == 2) {
          $(".full-message").show();
        } else {
          $(".full-message").hide();
        }

        // Controlamos si hay algun editor de texto
        $("textarea[data-ckeditor='basic']").each(function(i,e){
          self.crear_editor($(e).attr("id"));
        });

      },

      ver_videos: function() {
        if (PERFIL != -1) return;
        app.views.videosTableView = new app.views.VideosTableView({
          collection: new app.collections.Videos(),
          permiso: 3
        });    
        this.mostrar({
          "top" : app.views.videosTableView.el,
        });
      },
      ver_video: function(id) {
        var self = this;
        if (PERFIL != -1) return;
        if (id == undefined) {
          app.views.videoEditView = new app.views.VideoEditView({
            model: new app.models.Video(),
            permiso: 3
          });
          this.mostrar({
            "top" : app.views.videoEditView.el,
          });
        } else {
          var video = new app.models.Video({ "id": id });
          video.fetch({
            "success":function() {
              app.views.videoEditView = new app.views.VideoEditView({
                model: video,
                permiso: 3
              });
              self.mostrar({
                "top" : app.views.videoEditView.el,
              });
            }
          });
        }
      },

      // ==========================
      // FUNCIONES COMUNES:

      imprimir_factura: function(id,id_punto_venta,tipo_impresion,callback) {
        $('.modal:last').modal('hide'); // Cerramos si hay otro lightbox abierto
        var iframe = "<iframe style='width:100%; border:none; height:600px;' src='facturas/function/ver_pdf/"+id+"/"+id_punto_venta+"'></iframe>";
        iframe+='<div class="text-right wrapper">';
        iframe+='<button onclick="workspace.enviar_factura('+id+','+id_punto_venta+')" class="btn btn-info btn-addon m-r">';
        iframe+='<i class="fa fa-send"></i><span>Enviar</span>';
        iframe+='</button>';
        iframe+='<button class="btn btn-default" onclick="workspace.cerrar_impresion()">Cerrar</button>';
        iframe+='</div>';
        crearLightboxHTML({
          "html":iframe,
          "width":920,
          "height":600,
          "callback":callback
        });
      },      

      nuevo_email: function(consulta,callback) {

        // Si no se manda un modelo
        if (consulta == undefined) {
          consulta = new app.models.Consulta({
            "tipo":1, // 0=Recibido, 1=Enviado
          });
        }

        // Si no tiene seteado adjuntos por defecto
        if (typeof consulta.get("links_adjuntos") == "undefined") {
          consulta.set({"links_adjuntos":[]});
        }

        // Indica que estamos mandando un email con el usuario que estamos logueados
        consulta.set({
          "id_origen":5,
          "id_usuario":ID_USUARIO,
          "fecha":moment().format("DD/MM/YYYY"),
          "hora":moment().format("HH:mm:ss"),
        });

        var emailView = new app.views.EmailView({
          model: consulta
        });
        var d = $("<div/>").append(emailView.el);
        crearLightboxHTML({
          "html":d,
          "width":800,
          "height":400,
          "escapable":false,
          "callback":callback,
        });
        this.crear_editor('email_texto');
      },

      crear_editor:function(nombre,config) {
        // Esto se hace para que no tire error de que el CKEditor ya fue creado
        if (typeof config === "undefined") config = {};
        CKEDITOR.dtd.$removeEmpty['span'] = false;
        if (IDIOMA == "en") {
          config.defaultLanguage = 'en';
          config.language = 'en-EN';
          config.wsc_lang = 'en_EN';
          config.scayt_sLang = 'en_EN';
        } else {
          config.defaultLanguage = 'es';
          config.language = 'es-ES';
          config.wsc_lang = 'es_ES';
          config.scayt_sLang = 'es_ES';
        }
        config.filebrowserBrowseUrl = '/admin/uploads/'+ID_EMPRESA+'/editor/index.php';
        config.disableNativeSpellChecker = false;
        config.allowedContent = true;
        config.extraPlugins = 'image2,youtube,codemirror,widget,lineutils,colordialog,fontawesome,confighelper,scayt,iframe,font,pastefromword';
        config.uploadUrl = '/admin/uploads/'+ID_EMPRESA+'/editor/connectors/php/filemanager.php';
        config.contentsCss = ['/admin/resources/css/font-awesome.min.css','/admin/resources/js/libs/ckeditor_4.6/contents.css'];
        config.toolbar = [
          { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
          { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', 'FontSize', 'Image', 'PasteFromWord', 'Link', 'Unlink', 'TextColor','BGColor', 'Youtube', 'Source' ] },
        ];
        config.forcePasteAsPlainText = true;
        config.scayt_autoStartup = true;
        config.scayt_autoStartup = true;
        myinstance = CKEDITOR.instances[nombre];
        if (myinstance) CKEDITOR.remove(myinstance);
        CKEDITOR.replace(nombre,config);
      },    

      toggle_menu: function() {
        //$('.app-aside').toggleClass('off-screen');
      },

      ver_red: function() {
        window.propiedades_buscar_red = 1;
        location.href="app/#propiedades";
      },

      asignar_color: function(i) {
        if (i == 0) return "#14d0ad";
        else if (i == 1) return "#28bfd2";
        else if (i == 2) return "#e7ad63";
        else if (i == 3) return "#7798cd";
        else if (i == 4) return "#ea6c5e";
        else if (i == 5) return "#7266ba";
        else if (i == 6) return "#ff8137";
        else if (i == 7) return "#ea5ed9";
        else return "#000";
      },

      crear_nestable: function(array, config) {

        if (typeof config === "undefined") config = {};
        config.seleccionar = (config.seleccionar || false);
        if (typeof config.ordenable === "undefined") config = {};

        if (typeof array === "undefined") return "";
        if (array.length == 0) return "";
        var r = '<ol class="dd-list">';
        for(var i=0;i<array.length;i++) {
          var o = array[i];
          r+='<li class="dd-item dd3-item" data-id="'+o.id+'">';
          if (!config.seleccionar) r+='<div class="dd-handle dd3-handle">Drag</div>';
          r+='<div class="dd3-content">';
          if (!config.seleccionar) {
            r+= '<label class="i-checks m-b-none m-r-xs">';
            r+= '<input class="esc check-row" value="'+o.id+'" type="checkbox"><i></i>';
            r+= '</label>';
            r+= '<a href="javascript:void" class="editar cp text-info">'+(typeof o.title != "undefined" ? o.title : (typeof o.nombre != "undefined" ? o.nombre : "") )+'</a>';
          } else {
            r+=o.title;
          } 
          r+='</div>';       
            if (!config.seleccionar) {
            r+=workspace.crear_nestable(o.children);
          }
          r+='</li>';
        }
        r+='</ol>';
        return r;
      },      

      // Crea el arbol de <select> a partir de una estructura de Array con children
      crear_select:function(array,ident,selected,condition) {
        var r = "";
        if (!$.isArray(array) || array.length <= 0) return r;
        for(var i=0;i<array.length;i++) {
          var o = array[i];

          var ingresar = true;
          if (typeof condition == "function") {
            ingresar = condition(o);
          }
          if (ingresar) {
            // En data-ids ponemos todos los hijos de la categoria padre
            var ids = workspace.get_sub_ids(o.children);
            var ids_s = (ids.length > 0) ? o.id+"-"+ids.join("-") : o.id;

            r+= "<option data-ids='"+ids_s+"' value='"+o.id+"' "+((selected == o.id)?"selected":"");
            if (typeof o.totaliza_en != "undefined") r+=" data-totaliza_en='"+o.totaliza_en+"' ";
            r+=">";
            r+= ident + o.title;
            r+="</option>";
            r+= workspace.crear_select(o.children,ident+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",selected,condition);          
          }
        }
        return r;
      },
      get_sub_ids:function(array) {
        // Esta funcion es utilizada para obtener todos los IDS de las categorias hijos
        var ids = new Array();
        for(var i=0;i<array.length;i++) {
          var o = array[i];
          ids.push(o.id);
          if (o.children.length > 0) ids = ids.concat(workspace.get_sub_ids(o.children));
        }
        return ids;
      },

      // Aplana una estructura con children
      flatten: function(array) {
        var res = new Array();
        if (!$.isArray(array) || array.length <= 0) return null;
        for(var i=0;i<array.length;i++) {
          var o = array[i];
          res.push(o);
          var r = this.flatten(o.children);
          if (r !== null) res = res.concat(r);
        }
        return res;
      },

      // Abre un lightbox con un mensaje de espera
      esperar: function(mensaje) {
        var a = new app.mixins.Wait({
          model: new app.models.AbstractModel(),
          mensaje: mensaje,
        });
        crearLightboxHTML({
          "html":a.el,
          "width":400,
          "height":200,
        });
      },
      
      cerrar_impresion: function() {
        $('.modal:last').modal('hide');        
      },

      enviar_visita: function(data) {
        $.ajax({
          "url":"propiedades/function/guardar_visita_panel",
          "dataType":"json",
          "type": "post",
          "data":{
            "id_empresa": data.id_empresa,
            "id_propiedad": data.id_propiedad,
            "id_inmobiliaria": data.id_inmobiliaria,
            "tipo": data.tipo,
          },
        });     
      },

      volver_superadmin: function() {
        $.ajax({
          "url":"login/cambiar_empresa/",
          "dataType":"json",
          "success":function(r) {
            if (r.error == false) window.location = "app/";
          }
        });
      },
      
      imprimir_reporte: function(url,callback) {
        var iframe = "<iframe style='width:100%; border:none; height:600px;' src='"+url+"'></iframe>";
        iframe+='<div class="text-right wrapper">';
        iframe+='<button class="btn btn-default" onclick="workspace.cerrar_impresion()">Cerrar</button>';
        iframe+='</div>';
        crearLightboxHTML({
          "html":iframe,
          "width":920,
          "height":600,
          "callback":callback
        });
      },

    }); // FIN WORKSPACE

    window.workspace = new Workspace();

    // Cuando cambia de pagina
    window.workspace.on("route", function(route, params) {

      // Si hay algun EventSource abierto, lo cerramos
      if (typeof window.source !== "undefined") {
        window.source.close();
      }

      $('.app-aside').removeClass('off-screen');
      $(".app-aside-fixed .aside-wrap").removeClass("open");

      window.ajax_request = 0;
      
      // Simulamos el resize del window por si en la pagina que estamos entrando tiene que tener la barra cerrada
      $(window).trigger("resize");
      
      // Simulamos un click en el header para que se cierren los autocompletes si quedaron abiertos
      $(".navbar-header").trigger("click");

    });
      
    Backbone.history.start();
    
    if (inicio != "") {
      location.hash = inicio;
    }
    
    $(".navbar-btn").click(function(e){
      $(".app").toggleClass("app-aside-folded");
    });

    // Esta funcion se llama cada cierto tiempo, con el unico objetivo
    // de mantener viva la session
    window.setInterval(function() {
      $.ajax({
        cache: false,
        type: "GET",
        url: "/admin/app/refresh_session/",
        success: function(data) {}
      });
    },600000); // Cada 10 minutos        
    
  });

  // IMPORTANTE: LAS CONSULTAS EN AJAX NO SE PUEDEN CACHEAR
  $.ajaxSetup({ cache: false, timeout: 0 });
  
})();