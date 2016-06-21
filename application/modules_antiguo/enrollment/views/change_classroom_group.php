<div class="main-content" >
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
  <li class="active"><?php echo lang('enrollment');?></li>
 </ul>
</div>



        <div class="page-header position-relative">
                        <h1>
                            <?php echo lang("enrollment");?>
                            <small>
                                <i class="icon-double-angle-right"></i>
                                <?php echo "Canviar grup de classe";?>
                            </small>
                        </h1>
        </div><!-- /.page-header -->
<div style='height:10px;'></div>
	<div style="margin:10px;">
      <div class="container">
        


        <table class="table table-striped table-bordered table-hover table-condensed" id="TODO_filter">
          <thead style="background-color: #d9edf7;">
            <tr>
              <td colspan="6" style="text-align: center;"> <strong>Modificació de grup de classe per alumne</strong><br/> <font size="-3">NOTA: Només es possible canviar entre grups de classe del mateix estudi. Per fer un altre tipus de canvi de grup s'ha de fer una modificació sencera de matrícula).</font>
                </td>
            </tr>
            <tr> 
              <td><strong><?php echo "DNI/NIF/NIE"?>:</td>
              <td>
                <input type="text" id="student_official_id" name="student_official_id" placeholder="Escriu el <?php echo lang('wizzard_official_DNI');?>" style="width:100px;"/>   
              </td>


               <td><strong><?php echo "Nom complet"?></strong>:</td>
               <td width="20%">
                <div id="full_name_div"><div/>
               </td>
               <td width="15%"><strong><?php echo "Grup de classe actual"?></strong>:</td>
               <td width="40%">
                <div id="classroom_group_name"><div/>
               </td>
            </tr>
            <tr>
              <td><strong><?php echo "Nou grup de classe"?>:</td>
              <td colspan="3">
                <select id="select_class_room_to_change">
                  <option value=""></option>
                </select>    
              </td>              
              <td colspan="2" >
                <div style="display:none;" id="enrollment_id"></div>
                <div style="display:none;" id="current_group_id"></div>
                <button class="btn btn-mini btn-info" id="change_classroom_group">
                 <i class="icon-group"></i>
                    Canviar grup de classe
                     <i class="icon-arrow-right icon-on-right"></i>
                </button>
              </td>
            </tr>
          </thead>  
        </table> 






      </div> 

	</div>	
</div>

<script type="text/javascript">

jQuery(function($) {

  $("#select_class_room_to_change").select2( {width: 'resolve'});

  var availableTags = <?php echo json_encode($all_person_official_ids);?>;
  student_official_id = $('#student_official_id');
  student_official_id.autocomplete({
    source: availableTags
  });

  $("#change_classroom_group").click(function() {

    enrollment_id = $("#enrollment_id").text();
    current_group = $("#current_group_id").text();
    new_group = $('#select_class_room_to_change').val();

    //console.debug("enrollment_id:"+enrollment_id);
    //console.debug("current_group:"+current_group);
    //console.debug("new_group:"+new_group);  



    $.ajax({
      url:'<?php echo base_url("index.php/enrollment/change_classroom_group_action");?>',
      type: 'post',
      data: {
          enrollment_id : enrollment_id,
          current_group : current_group,
          new_group : new_group,
      },
      datatype: 'json',
      statusCode: {
        404: function() {
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/change_classroom_group_action ' ,
            class_name: 'gritter-error gritter-center'
          });
        },
        500: function() {
          $("#response").html('A server-side error has occurred.');
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/change_classroom_group_action ' ,
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
    }).done(function(data) {

        var all_data = $.parseJSON(data);

        console.debug(all_data);

        if (all_data == "Ok") {
            $.gritter.add({
              title: 'Operació correcte!',
              text: 'Grup canviat correctament!' ,
            });
        } else {
            $.gritter.add({
              title: 'Error!',
              text: 'Ha succeït un error al executar la modificació a la base de dades!' ,
              class_name: 'gritter-error gritter-center'
            });
        }
    });













  });



  $("#student_official_id").change(function(){
    //console.debug("change event");
    student = $(this).val();

        $.ajax({
          url:'<?php echo base_url("index.php/enrollment/check_student_change_classroomgroup");?>',
          type: 'post',
          data: {
              student_official_id : student
          },
          datatype: 'json',
          statusCode: {
            404: function() {
              $.gritter.add({
                title: 'Error connectant amb el servidor!',
                text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/check_student_change_classroomgroup ' ,
                class_name: 'gritter-error gritter-center'
              });
            },
            500: function() {
              $("#response").html('A server-side error has occurred.');
              $.gritter.add({
                title: 'Error connectant amb el servidor!',
                text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/check_student_change_classroomgroup ' ,
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
              title: 'S\'ha trobat l\'alumne!',
              // (string | mandatory) the text inside the notification
              text: "<i class='icon-exclamation-sign'></i> L'alumne té una matrícula per al període acadèmic actual</i></button>",
            });
          
            var all_data = $.parseJSON(data);
            
            full_name = all_data.person_sn1 + " " + all_data.person_sn2 + ", " + all_data.person_givenName;
            group_id = all_data.enrollment_group_id;
            classroom_group_name = all_data.classroom_group_code + " - " + all_data.classroom_group_shortName + "." + all_data.classroom_group_name + " ( " + group_id +")";
            
            //console.debug('fullname: ' + fullname);
            //console.debug('group: ' + classroom_group_name);
            //console.debug('group id: ' + group_id);

            $("#classroom_group_name").text(classroom_group_name);
            $("#current_group_id").text(group_id);            
            $("#full_name_div").text(full_name);
            $("#enrollment_id").text(all_data.enrollment_id);
            

            //charge possible new classroomgroups in select_class_room_to_change depending on current classroom_group
            current_group= all_data.enrollment_group_id;
            //console.debug("current_group:"  + current_group);
              $.ajax({
                  url:'<?php echo base_url("index.php/enrollment/get_classroom_groups_from_same_study");?>',
                  type: 'post',
                  data: {
                      current_group : current_group
                  },
                  datatype: 'json',
                  statusCode: {
                    404: function() {
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/get_classroom_groups_from_same_study ' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    },
                    500: function() {
                      $("#response").html('A server-side error has occurred.');
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/get_classroom_groups_from_same_study ' ,
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
                    var all_data = $.parseJSON(data);
                    var j=1;

                    $('#select_class_room_to_change').empty();
                    $.each(all_data, function(idx,obj) {
                      group_full_name = obj.classroom_group_code + " - " + obj.classroom_group_shortName + ". " + obj.classroom_group_name ; 
                      //console.debug ("classroom_group_id: " + obj.classroom_group_id);
                      //console.debug ("group_full_name: " + group_full_name);
                      if (current_group != obj.classroom_group_id) {
                        if (j==1) {
                          $('#select_class_room_to_change').append($("<option></option>").attr("selected","selected").attr("value",obj.classroom_group_id).text(group_full_name));     
                        } else {
                          $('#select_class_room_to_change').append($("<option></option>").attr("value",obj.classroom_group_id).text(group_full_name));       
                        }
                        j++;
                      }
                      
                      
                    });
                    //Add options to select select_class_room_to_change                    
                    $("#select_class_room_to_change").select2({width: 'resolve' });                
                  }
                });
        
          } else {
              $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'NO s\'ha trobat l\'alumne!',
                // (string | mandatory) the text inside the notification
                text: "<i class='icon-exclamation-sign'></i> No s'ha trobat cap alumne amb el DNI/NIF/Passaport indicat o no té cap matrícula al període acadèmic actual!. <button class='close' data-dismiss='alert' type='button'><i class='icon-remove'></i></button>",
                class_name: 'gritter-error'
              });
              
          }
        });
  });

});

</script>