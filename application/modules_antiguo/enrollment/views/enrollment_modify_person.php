<div class="main-content" >

  <!-- Breadcrumbs -->
  <div id="breadcrumbs" class="breadcrumbs">
    <script type="text/javascript">
      try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home home-icon"></i>
       <a href="#">Home</a>
        <span class="divider">
          <i class="icon-angle-right arrow-icon"></i>
        </span>
      </li>
      <li class="active"><?php echo "Consulta matrícula"?></li>
    </ul>
  </div><!-- /breadcrumbds -->

  <!-- Page Header -->
  <div class="page-header position-relative">
    <h1>
      <?php echo "Persones";?>
      <small>
        <i class="icon-double-angle-right"></i>
        <?php echo "Modificació de dades personals";?>
      </small>
    </h1>
  </div><!-- /.page-header -->	

  <div style='height:10px;'></div>  
  
  <div style="margin:10px;">

    <!-- PAGE CONTENT BEGINS -->
    <div class="row-fluid">
      

                    <div class="widget-box">
                      <div class="widget-header" style="text-align: center;">
                      <!-- /widget-header -->
                        <span >
                          <small class="green" >
                           <b><?php echo lang("enrollment_student_personal_data");?></b>
                          </small>
                        </span>
                        <div class="widget-toolbar">
                          <a href="#" data-action="collapse">
                            <i class="icon-chevron-up"></i>
                          </a>
                        </div>
                      </div>
                      <div class="widget-body">

                          <form id="validation-form" method="get">

                          <div class="row-fluid">
                            <div class="span12">

                                <div id="user-profile-1" class="user-profile row-fluid">
                                  
                                  <!-- AVATAR -->
                                  <div class="span3 center">
                                    
                                    <div class="span2"></div>
                                    <div class="span8 center">
                                      <div class="space-4"></div>
                                      
                                      <!-- Student Photo -->
                                      <div id="student_photo">
                                        <span class="profile-picture">
                                          <img id="avatar" style="height: 100px;" class="editable img-responsive editable-click" src="<?php echo base_url('assets/img/alumnes').'/foto.png';?>" alt="photo" />
                                          <input id="person_photo" name="person_photo" type="hidden" />  
                                        </span>
                                      </div>                                        

                                      <div id="student_full_name" class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                        <div class="inline position-relative">
                                          <i class="icon-circle light-green middle"></i> <span class="white">Alumne</span>
                                        </div>
                                      </div>                                      
                                    </div>  
                                    <div class="space-4"></div>
                                  </div>
                                  <!-- AVATAR END -->

                                  <div class="span9">
                                      
                                    <!-- DNI  -->
                                    <div class="span7">
                                        <div class="span2">
                                          <input type="radio" name="official_id_type" id="rb_is_dni" value="1"><span><?php echo lang('wizzard_official_DNI');?>&nbsp;</span>
                                        </div>
                                        <div class="span2">
                                          <input type="radio" name="official_id_type" id="rb_is_nie" value="2"><span><?php echo lang('wizzard_official_NIE');?>&nbsp;</span>
                                        </div>
                                        <div class="span4">
                                          <input type="radio" name="official_id_type" id="rb_is_passport" value="3"><span><?php echo lang('wizzard_official_passport');?>&nbsp;</span>
                                        </div>
                                      </div>

                                    <div class="span11" >
                                      
                                        <div class="span4" >                                  
                                          <label id="lbl_student_official_id" for="student_official_id" class="control-label no-padding-right"><?php echo "DNI/NIF/Passaport";?>&nbsp;</label>
                                          <div class="controls">
                                            <input type="hidden" id="person_id" name="person_id" />
                                            <input type="text" id="student_official_id" name="student_official_id" placeholder="Escriu el <?php echo lang('wizzard_official_DNI');?>" />
                                          </div>
                                        </div>
                                      
                                        <div class="span3">
                                          <label class="control-label" for="person_secondary_official_id"><?php echo lang('wizzard_secondary_official_id');?>&nbsp;</label>
                                          <input type="text" name="person_secondary_official_id" />
                                        </div>

                                    </div>

                                    <div class="span11" >
                                           
                                          <div class="span4">
                                            <label class="control-label" for="student_date_of_birth"><?php echo lang('wizzard_date_of_birth');?>&nbsp;</label>
                                            <div class="input-prepend">
                                              <span class="add-on">
                                               <i class="icon-calendar bigger-110"></i>
                                              </span> 
                                              <input class="form-control date-picker span11 input-mask-date" type="text" name="person_date_of_birth" data-date-format="dd-mm-yyyy" />                                                                    
                                            </div>  
                                          </div>

                                          
                                          <div class="span4">
                                            <label for="Tipus" >Sexe</label>
                                            <div class="span4">
                                              <label>
                                                <input name="sexe" type="radio" class="ace" value="M" checked="checked"  />
                                                <span class="lbl"> Home</span>
                                              </label>                                      
                                            </div>
                                            <div class="span4">
                                              <label>
                                                <input name="sexe" type="radio" class="ace" value="F" />
                                                <span class="lbl"> Dona</span>
                                              </label>                                      
                                            </div>
                                          </div>    

                                    </div>




                                    </div>
                                    
                                  </div>

                                  <div class="span11">
                                    <div class="span3">
                                        <div class="control-group">
                                          <label class="control-label" for="student_givenName"><?php echo lang('wizzard_givenName');?></label>

                                          <div class="controls">
                                             <input id="givenName" type="text" name="person_givenName"  />
                                          </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                          <label class="control-label"><?php echo lang('wizzard_sn1');?></label>

                                          <div class="controls">
                                             <input id="sn1" type="text" name="person_sn1" />
                                          </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                      <label class="control-label" for="student_sn2"><?php echo lang('wizzard_sn2');?>&nbsp;</label>
                                      <input id="sn2" type="text" name="person_sn2"   />
                                    </div>
                                    <div class="span3">
                                      <label class="control-label" for="student_username">Username:&nbsp;</label>
                                      <input id="username" type="text" name="person_username" readonly="true" />                                    
                                    </div>
                                  </div>
                                  
                                  <div class="span11" >
                                    
                                    
                                    <div class="span3">
                                      <label class="control-label" for="student_telephoneNumber"><?php echo lang('wizzard_telephoneNumber');?>&nbsp;</label>
                                      <div class="input-prepend">                         
                                        <span class="add-on">
                                          <i class="icon-phone"></i>
                                        </span>
                                        <input type="text" name="person_telephoneNumber" id="person_telephoneNumber"  />                          
                                      </div>
                                    </div>
                           
                                    <div class="span3">
                                      <label class="control-label" for="student_mobile"><?php echo lang('wizzard_mobile');?>&nbsp;</label>  
                                      <div class="input-prepend">                         
                                        <span class="add-on">
                                          <i class="icon-phone"></i>
                                        </span>                                     
                                        <input type="text" name="person_mobile" />                      
                                      </div>
                                    </div>
                                    
                                    <div class="span3">
                                      <div class="control-group">
                                        <label class="control-label" for="student_email"><?php echo lang('wizzard_email');?>&nbsp;</label>    
                                        <div class="controls">                      
                                          <input type="text" id="person_email" name="person_email" readonly="readonly" value="" />                         
                                        </div>  
                                      </div>  
                                    </div>  

                                    <div class="span3">
                                      <div class="control-group">
                                        <label class="control-label" for="student_email"><?php echo lang('wizzard_personal_email');?>&nbsp;</label>    
                                        <div class="controls">                      
                                          <input type="text" name="person_secondary_email" id="person_secondary_email" />                         
                                        </div>  
                                      </div>  
                                    </div>

                                  </div>                                  
                            
                                  <div class="span11" >
                                    <div class="span7">
                                      <label class="control-label" for="student_homePostalAddress"><?php echo lang('wizzard_homePostalAddress');?>&nbsp;</label>
                                      <input class="span12" type="text" name="person_homePostalAddress"  />                          
                                    </div>
                                    <div class="span5">
                                      <div class="span4">
                                        <label class="control-label" for="student_postal_code"><?php echo lang('wizzard_postal_code');?>&nbsp;</label> 
                                        <input class="span12 input-mask-postalcode" type="text" name="postalcode_code" id="postalcode_code" value="" />
                                      </div>  
                                      <div class="span8">
                                        <label class="control-label" for="student_locality"><?php echo lang('wizzard_locality_name');?>&nbsp;</label>
                                        <select id="person_locality_id" name="person_locality_id" class="select2 span4" style="width:300px" >
                                          <? foreach($localities as $locality): ?>
                                          <option id="locality_postal_code_<?php echo $locality['locality_postal_code'];;?>" value="<?php echo $locality['locality_id']; ?>" <?php if ( $this->config->item('default_locality_id') == $locality['locality_id'] ) { echo "selected=\"selected\""; } ;?> ><?php echo $locality['locality_name']; ?></option>
                                          <? endforeach; ?>
                                        </select>

                                      </div>                            
                                    </div>                                    
                                  </div>

                                  
                              </div><!-- /.span -->
                            </div><!-- /.row-fluid -->
                      </form>
                      </div>
                    </div> <!-- widget-box -->

                    <div class="row-fluid wizard-actions">
                      <button id="save_modify_person_button" data-last="Finalitzar" class="btn btn-success btn-next">
                        Guardar
                        <i class="icon-arrow-right icon-on-right"></i>
                      </button>
                    </div>


        </div> <!-- /row-fluid -->            
    </div> <!-- margin:10px; -->

</div>
<!-- PAGE CONTENT ENDS -->

<!--  
  JAVASCRIPT
-->  
<script type="text/javascript">
  if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

<!-- inline scripts related to this page -->
<script type="text/javascript">

function get_student_object_from_form_data() {
          
      var student = {
            student_official_id:$("input[name$='student_official_id']").val(),
            student_person_id: $("input[name$='person_id']").val(),
            
            student_official_id_type: $("input[name$='official_id_type']:checked").val(),
            
            student_secondary_official_id: $("input[name$='person_secondary_official_id']").val(),
            
            student_givenName: $("input[name$='person_givenName']").val(),
            student_sn1: $("input[name$='person_sn1']").val(),
            student_sn2: $("input[name$='person_sn2']").val(),

            student_username: $("input[name$='person_username']").val(),
            student_generated_password: "",
            student_password: "",
            student_verify_password: "",
            student_not_change_user_data: true,
            
            student_telephoneNumber: $("input[name$='person_telephoneNumber']").val(),
            student_mobile: $("input[name$='person_mobile']").val(),
            student_email: $("input[name$='person_email']").val(),
            student_secondary_email: $("input[name$='person_secondary_email']").val(),

            student_homePostalAddress: $("input[name$='person_homePostalAddress']").val(),

            student_locality: $("select[name$='person_locality_id']").val(),
            student_postal_code: $("input[name$='postalcode_code']").val(),

            student_date_of_birth: $("input[name$='person_date_of_birth']").val(),
            student_gender: $("input:radio[name=sexe]:checked").val(),
            student_photo: $("input[name$='person_photo']").val(),

        };



      return student;
}

function insert_update_user(student,action) {
    $.ajax({
      url:'<?php echo base_url("index.php/enrollment/insert_update_user");?>',
      type: 'post',
      data: {
          student_person_id: student.student_person_id,
          student_official_id : student.student_official_id,
          student_official_id_type : student.student_official_id_type,   
          student_secondary_official_id : student.student_secondary_official_id,
          student_givenName : student.student_givenName,
          student_sn1 : student.student_sn1,
          student_sn2 : student.student_sn2,
          student_username : student.student_username,
          student_generated_password : student.student_generated_password,
          student_password : student.student_password,
          student_verify_password : student.student_verify_password,
          student_not_change_user_data : student.student_not_change_user_data,
          student_email : student.student_email,
          student_secondary_email : student.student_secondary_email,
          student_homePostalAddress : student.student_homePostalAddress,
          student_locality : student.student_locality,
          student_postal_code : student.student_postal_code,
          student_telephoneNumber : student.student_telephoneNumber,
          student_mobile : student.student_mobile,
          student_date_of_birth : student.student_date_of_birth,
          student_gender : student.student_gender,
          student_photo : student.student_photo,
          action : action
      },
      datatype: 'json',
      statusCode: {
        404: function() {
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/insert_update_user ' ,
            class_name: 'gritter-error gritter-center'
          });
        },
        500: function() {
          $("#response").html('A server-side error has occurred.');
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/insert_update_user ' ,
            class_name: 'gritter-error gritter-center'
          });
        }
      },
      error: function() {
        $.gritter.add({
            title: 'Error!',
            text: 'Ha succeït un error!' ,
            class_name: 'gritter-error gritter-center'
          });
      },
      /*success: function(data) {
        //console.debug("data:" + JSON.stringify(data));
        $.gritter.add({
          title: 'Correcte!',
          text: 'S\'han modificat correctament les dades de l\'usuari'  ,
        });
        
      }*/
    }).done(function(data){
        //Check if change is correct.
        var all_data = $.parseJSON(data);
        //console.debug(all_data);
        
        if (all_data.error) {
          $.gritter.add({
            title: 'Error!',
            text: all_data.message,
            class_name: 'gritter-error gritter-center'
          });

        } else {
          $.gritter.add({
            title: 'Canvi realitzat correctament!',
            text: all_data.message,
          });
        }
        
    });
  }

      /******************
       *  Editable Avatar
      ******************/
      function editableAvatar() {

        //editables on first profile page
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
        
        // *** editable avatar *** //
        try {//ie8 throws some harmless exception, so let's catch it
      
          //it seems that editable plugin calls appendChild, and as Image doesn't have it, it causes errors on IE at unpredicted points
          //so let's have a fake appendChild for it!
          if( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ) Image.prototype.appendChild = function(el){}
      
          var last_gritter
          $('#avatar').editable({
            type: 'image',
            name: 'avatar',
            value: null,
            image: {
              //specify ace file input plugin's options here
              btn_choose: 'Canvieu el Avatar',
              droppable: true,
              /**
              //this will override the default before_change that only accepts image files
              before_change: function(files, dropped) {
                return true;
              },
              */
      
              //and a few extra ones here
              name: 'avatar',//put the field name here as well, will be used inside the custom plugin
              max_size: 110000,//~100Kb
              on_error : function(code) {//on_error function will be called when the selected file has a problem
                if(last_gritter) $.gritter.remove(last_gritter);
                if(code == 1) {//file format error
                  last_gritter = $.gritter.add({
                    title: 'El fitxer no és una imatge!',
                    text: 'Escolliu un fitxer jpg|gif|png!',
                    class_name: 'gritter-error gritter-center'
                  });
                } else if(code == 2) {//file size rror
                  last_gritter = $.gritter.add({
                    title: 'El fitxer és massa gran!',
                    text: 'La imatge no pot superar els 100Kb!',
                    class_name: 'gritter-error gritter-center'
                  });
                }
                else {//other error
                }
              },
              on_success : function() {
                $.gritter.removeAll();
              }
            },
              url: function(params) {

                    //Get username an DNI
                    username = $("#username").val();
                    sn1 = $("#sn1").val();
                    givenName = $("#givenName").val();
                    official_id = $("#student_official_id").val();

                    //Check values
                    if (official_id == "") {
                      alert ("Si us plau indiqueu abans un NIF correcte!");
                      return false;
                    }

                    if (username == "") {
                      alert ("Si us plau indiqueu abans un nom d'usuari correcte!");
                      return false;
                    }

                    if (givenName == "") {
                      alert ("Si us plau indiqueu abans un nom d'usuari!");
                      return false;
                    }

                    if (givenName == "") {
                      var r = confirm("El primer cognom és buit. Esteu segurs que voleu pujar la imatge igualment?");
                      if (r != true) {
                          return false;
                      }
                    }


                    //please modify submit_url accordingly
                    var submit_url = '<?php echo base_url("index.php/enrollment/upload_photo");?>';
                    var deferred;


                    //if value is empty, means no valid files were selected
                    //but it may still be submitted by the plugin, because "" (empty string) is different from previous non-empty value whatever it was
                    //so we return just here to prevent problems
                    var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
                    if(!value || value.length == 0) {
                      deferred = new $.Deferred
                      deferred.resolve();
                      return deferred.promise();
                    }
                    
                    

                    var $form = $('#avatar').next().find('.editableform:eq(0)');
                    $form.append('<input type="hidden" name="username" value="'+username+'" />');
                    $form.append('<input type="hidden" name="official_id" value="'+official_id+'" />');
                    var file_input = $form.find('input[type=file]:eq(0)');

                    //user iframe for older browsers that don't support file upload via FormData & Ajax
                    if( !("FormData" in window) ) {
                      deferred = new $.Deferred

                      var iframe_id = 'temporary-iframe-'+(new Date()).getTime()+'-'+(parseInt(Math.random()*1000));
                      $form.after('<iframe id="'+iframe_id+'" name="'+iframe_id+'" frameborder="0" width="0" height="0" src="about:blank" style="position:absolute;z-index:-1;"></iframe>');
                      $form.append('<input type="hidden" name="temporary-iframe-id" value="'+iframe_id+'" />');
                      

                      $form.next().data('deferrer' , deferred);//save the deferred object to the iframe
                      $form.attr({'method' : 'POST', 'enctype' : 'multipart/form-data',
                            'target':iframe_id, 'action':submit_url});

                      $form.get(0).submit();

                      //if we don't receive the response after 60 seconds, declare it as failed!
                      setTimeout(function(){
                        var iframe = document.getElementById(iframe_id);
                        if(iframe != null) {
                          iframe.src = "about:blank";
                          $(iframe).remove();
                          
                          deferred.reject({'status':'fail','message':'Timeout!'});
                        }
                      } , 60000);
                    }
                    else {
                      var fd = null;
                      try {
                        fd = new FormData($form.get(0));
                      } catch(e) {
                        //IE10 throws "SCRIPT5: Access is denied" exception,
                        //so we need to add the key/value pairs one by one
                        fd = new FormData();
                        $.each($form.serializeArray(), function(index, item) {
                          fd.append(item.name, item.value);
                        });
                        //and then add files because files are not included in serializeArray()'s result
                        $form.find('input[type=file]').each(function(){
                          if(this.files.length > 0) fd.append(this.getAttribute('name'), this.files[0]);
                        });
                      }
                      
                      //if file has been drag&dropped , append it to FormData
                      if(file_input.data('ace_input_method') == 'drop') {
                        var files = file_input.data('ace_input_files');
                        if(files && files.length > 0) {
                          fd.append(file_input.attr('name'), files[0]);
                        }
                      }

                      deferred = $.ajax({
                        url: submit_url,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        data: fd,
                        xhr: function() {
                          var req = $.ajaxSettings.xhr();
                          /*if (req && req.upload) {
                            req.upload.addEventListener('progress', function(e) {
                              if(e.lengthComputable) {  
                                var done = e.loaded || e.position, total = e.total || e.totalSize;
                                var percent = parseInt((done/total)*100) + '%';
                                //bar.css('width', percent).parent().attr('data-percent', percent);
                              }
                            }, false);
                          }*/
                          return req;
                        },
                        beforeSend : function() {
                          //bar.css('width', '0%').parent().attr('data-percent', '0%');
                        },
                        success : function() {
                          //bar.css('width', '100%').parent().attr('data-percent', '100%');
                        }
                      })
                    }



                    deferred.done(function(res){
                      if(res.status == 'OK') {
                        $('#avatar').get(0).src = res.url;
                        $('#person_photo').val (res.person_photo);
                      }
                      else alert(res.message);
                    }).fail(function(res){
                      alert("Failure");
                    });


                    return deferred.promise();




              // ***UPDATE AVATAR HERE*** //
              /*
              //You can replace the contents of this function with examples/profile-avatar-update.js for actual upload
      
              var deferred = new $.Deferred
      
              //if value is empty, means no valid files were selected
              //but it may still be submitted by the plugin, because "" (empty string) is different from previous non-empty value whatever it was
              //so we return just here to prevent problems
              var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
              if(!value || value.length == 0) {
                deferred.resolve();
                return deferred.promise();
              }
      
              //dummy upload
              setTimeout(function(){
                if("FileReader" in window) {
                  //for browsers that have a thumbnail of selected image
                  var thumb = $('#avatar').next().find('img').data('thumb');
                  if(thumb) $('#avatar').get(0).src = thumb;
                }
                
                deferred.resolve({'status':'OK'});
      
                if(last_gritter) $.gritter.remove(last_gritter);
                last_gritter = $.gritter.add({
                  title: "Foto actualitzada correctament!",
                  text: "El avatar de l'usuari s'ha modificat correctament!",
                  time: 3000,
                  class_name: 'gritter-info gritter-center'
                });
                
               } , parseInt(Math.random() * 800 + 800))
      
              return deferred.promise();

              */

            },
            
            success: function(response, newValue) {
            }
          })
        }catch(e) {}

      }

jQuery(function($) {

        editableAvatar();

        $('input:radio[name=official_id_type]').val(['1']);

        /* VALIDAR DNI */

        jQuery.validator.addMethod( "student_official_id", function ( value, element ) {
         "use strict";
         
         /*
         var _placeholder=element.placeholder;
         
         if (_placeholder.search("DNI") == -1) {
          return true;
         }*/

         //var official_id_type_value = $('input:radio[name=official_id_type]').val();
         var student_official_id_type_value = $("input[name$='official_id_type']:checked").val();
         //console.debug("student_official_id_type_value: " + student_official_id_type_value);
         if (student_official_id_type_value != 1) {
            return true;
         }

         value = value.toUpperCase();
         
         // Basic format test
         if ( !value.match('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)') ) {
          return false;
         }
         
         // Test NIF
         if ( /^[0-9]{8}[A-Z]{1}$/.test( value ) ) {
          return ( "TRWAGMYFPDXBNJZSQVHLCKE".charAt( value.substring( 8, 0 ) % 23 ) === value.charAt( 8 ) );
         }
         // Test specials NIF (starts with K, L or M)
         if ( /^[KLM]{1}/.test( value ) ) {
          return ( value[ 8 ] === String.fromCharCode( 64 ) );
         }
         
         return false;
        
        }, "Especifiqueu un NIF vàlid!.");
        /* END /Validar dni */

    $.extend($.validator.messages, {
          required: "Aquest camp és obligatori.",
          remote: "Si us plau, omple aquest camp.",
          email: "Si us plau, escriu una adreça de correu-e vàlida",
          url: "Si us plau, escriu una URL vàlida.",
          date: "Si us plau, escriu una data vàlida.",
          dateISO: "Si us plau, escriu una data (ISO) vàlida.",
          number: "Si us plau, escriu un número enter vàlid.",
          digits: "Si us plau, escriu només dígits.",
          creditcard: "Si us plau, escriu un número de tarjeta vàlid.",
          equalTo: "Si us plau, escriu el maateix valor de nou.",
          extension: "Si us plau, escriu un valor amb una extensió acceptada.",
          maxlength: $.validator.format("Si us plau, no escriguis més de {0} caracters."),
          minlength: $.validator.format("Si us plau, no escriguis menys de {0} caracters."),
          rangelength: $.validator.format("Si us plau, escriu un valor entre {0} i {1} caracters."),
          range: $.validator.format("Si us plau, escriu un valor entre {0} i {1}."),
          max: $.validator.format("Si us plau, escriu un valor menor o igual a {0}."),
          min: $.validator.format("Si us plau, escriu un valor major o igual a {0}.")
        });

        $('#validation-form').validate({
          errorElement: 'div',
          errorClass: 'help-inline',
          focusInvalid: false,
          rules: {
            student_official_id: {
              required: true,
              student_official_id: 'required',
            },
            person_givenName: {
              required: true
            },
            person_sn1: {
              required: true
            },
            person_email: {
              required: false,
              email:true
            },
            person_secondary_email: {
              required: false,
              email:true
            },
            person_password: {
              required: false,
              minlength: 6
            },
            person_verify_password: {
              required: false,
              minlength: 6,
              equalTo: "#person_password"
            },
            
            person_telephoneNumber: {
              required: false
            },
            
            gender: 'required'
          },
      
          messages: {
            person_email: {
              required: "Si us plau especifiqueu un email vàlid.",
              email: "Si us plau especifiqueu un email vàlid."
            },
            person_secondary_email: {
              required: "Si us plau especifiqueu un email vàlid.",
              email: "Si us plau especifiqueu un email vàlid."
            },
            person_password: {
              required: "És obligatori especificar una paraula de pas",
              minlength: "Si us plau especifiqueu una paraula de pas segura."
            },
            subscription: "Si us plau escolliu almenys una opció",
            gender: "Si us plau escolliu el gènere"
          },
      
          invalidHandler: function (event, validator) { //display error alert on form submit   
            $('.alert-danger', $('.login-form')).show();
          },
      
          highlight: function (e) {
            $(e).closest('.control-group').removeClass('info').addClass('error');
          },
      
          success: function (e) {
            $(e).closest('.control-group').removeClass('error').addClass('info');
            $(e).remove();
          },
      
          errorPlacement: function (error, element) {
            if(element.is(':checkbox') || element.is(':radio')) {
              var controls = element.closest('div[class*="col-"]');
              if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
              else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            }
            else if(element.is('.select2')) {
              error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            }
            else if(element.is('.chosen-select')) {
              error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            }
            else error.insertAfter(element);
          },
      
          submitHandler: function (form) {
          },
          invalidHandler: function (form) {
          }
        });

    $('.date-picker').datepicker({"autoclose": true});
    $('.input-mask-date').mask('99-99-9999'); 
    $('.input-mask-postalcode').mask('99999');

    $('#postalcode_code').change(function () {
        postalcode = $('#postalcode_code').val();
        //console.debug("Postal code: " + postalcode);
        _person_locality_id =  $('#person_locality_id');              
        value_to_select= $('#locality_postal_code_' + postalcode).val(); 
        //console.debug("value_to_select: " + value_to_select);

        if (typeof value_to_select === "undefined") {
         alert("El codi postal no correspon a cap població");
        }

        _person_locality_id.val(value_to_select);
        _person_locality_id.select2();


    });

  var availableTags = <?php echo json_encode($all_person_official_ids);?>;
  student_official_id = $('#student_official_id');
  student_official_id.autocomplete({
    source: availableTags
  });

  $.gritter.add({
    title: 'Modificació de dades personals i matrícula per NIF/Passaport/NIE',
    text: 'Escriviu el NIF/Passaport/NIE de l\'alumne i tabuleu per cercar les dades de matrícula' ,
    class_name: 'gritter-warning'
  });

  student_official_id = "";

  

  $("#save_modify_person_button").click(function(){

    //FIRST VALIDATE FORM. IS NOT VALID DONT FORWARD STEP
    if (! $('#validation-form').valid() ) {
      console.debug("Form not valid!");
    } else {
      //console.debug("Form valid!");
      //AJAX SAVE
      var student = get_student_object_from_form_data();
      insert_update_user(student,"update");
    }
  });


  $("#student_official_id").change(function(){
    //console.debug("change event");
    student = $(this).val();

    //Check if is a valid DNI

        $.ajax({
          url:'<?php echo base_url("index.php/enrollment/check_student");?>',
          type: 'post',
          data: {
              student_official_id : student
          },
          datatype: 'json',
          statusCode: {
            404: function() {
              $.gritter.add({
                title: 'Error connectant amb el servidor!',
                text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/check_student ' ,
                class_name: 'gritter-error gritter-center'
              });
            },
            500: function() {
              $("#response").html('A server-side error has occurred.');
              $.gritter.add({
                title: 'Error connectant amb el servidor!',
                text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/check_student ' ,
                class_name: 'gritter-error gritter-center'
              });
            }
          },
          error: function() {
            $.gritter.add({
                title: 'Error!',
                text: 'Ha succeït un error!' ,
                class_name: 'gritter-error gritter-center'
              });
          },
        }).done(function(data){

          /* Student Exists */
          if(data != false) {
   
            $.gritter.add({
              // (string | mandatory) the heading of the notification
              title: 'S\'ha trobat la persona!',
              // (string | mandatory) the text inside the notification
              text: "<i class='icon-exclamation-sign'></i> Us hem omplert tots els camps amb les dades de la persona. <button class='close' data-dismiss='alert' type='button'><i class='icon-remove'></i></button>",
            });
          
            var all_data = $.parseJSON(data);
            //console.debug(JSON.stringify(all_data));
            $.each(all_data, function(idx,obj) {
              
              /* Fill form with student data from Database */
              //console.debug("idx:" + idx);
              //console.debug("set value to:" + obj);
              $("input[name$="+idx+"]").val(obj);
              
              if(idx=='person_locality_id') {
                  //console.debug("test");
                  $('#person_locality_id').val(obj);
                  $('#person_locality_id').select2();
              }

              student_full_name = $('#student_full_name').find("span.white");
              if(idx=='person_photo'){
                var student_photo = $('#student_photo');

                //Sergi Tur: change only img source not all span!!
                //student_photo.html('<span class="profile-picture"><img id="avatar" style="height: 150px;" class="editable img-responsive editable-click" src="<?php echo base_url('uploads/person_photos'); ?>/'+obj+'" alt="'+ obj +'"/></span>');
                $('#avatar').attr("src","<?php echo base_url('uploads/person_photos');?>/"+obj);
              }
              if(idx=='person_gender'){
                if(obj == 'M'){
                  $('input:radio[name=sexe]').val(['M']);  
                } else if(obj == 'F'){
                  $('input:radio[name=sexe]').val(['F']);  
                }
              }

              if(idx=='person_official_id_type'){
                if(obj == 1){
                   $('input:radio[name=official_id_type]').val(['1']);
                } else if(obj == 2){
                   $('input:radio[name=official_id_type]').val(['2']);
                } else if(obj == 3){
                  $('input:radio[name=official_id_type]').val(['3']);
                }
              }


                student_full_name.text(all_data['person_givenName']+" "+all_data['person_sn1']+" "+all_data['person_sn2']);
            });
           
          /* Student doesn't exists, clear form data */
          } else {
              $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'NO s\'ha trobat la persona!',
                // (string | mandatory) the text inside the notification
                text: "<i class='icon-exclamation-sign'></i> No s'ha trobat cap persona amb el DNI/NIF/Passaport indicat!. <button class='close' data-dismiss='alert' type='button'><i class='icon-remove'></i></button>",
                class_name: 'gritter-error gritter-center'
              });
              empty_student = {"person_id":"",
              "person_photo":"","person_secondary_official_id":"","person_givenName":"",
              "person_sn1":"","person_sn2":"","person_email":"","person_secondary_email":"","person_date_of_birth":"",
              "person_gender":"","person_homePostalAddress":"","postalcode_code":"","person_locality_id":"","username":"",
              "person_telephoneNumber":"","person_mobile":""}

              /*value_to_select= $('#locality_postal_code_' + postalcode).val(); 
              $('#person_locality_id').val(value_to_select);
              $('#person_locality_id').select2();*/

              
              student_photo = $('#student_photo');
              student_photo.html('<span class="profile-picture"><img id="avatar" style="height: 150px;" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url('assets/img/alumnes/foto.png'); ?>" alt="photo"/></span>');                  
              student_full_name = $('#student_full_name').find("span.white");
              student_full_name.text('Alumne');
              $('input:radio[name=official_id_type]').val(['1']);

              $.each(empty_student, function(idx,obj) {
                $("input[name$='"+idx+"']").val(obj);
              });
          }

        });

  //editableAvatar();          

  });

});

</script>

<div style="height: 35px;"></div>    
