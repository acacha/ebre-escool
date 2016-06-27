<div class="main-content">

    <style TYPE="text/css">
        .row-highlight {
            background-color: #e4efc9;
        }
        #reportrange {
            background: #ffffff;
            -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.25), inset 0 -1px 0 rgba(0,0,0,.1);
            -moz-box-shadow: 0 1px 3px rgba(0,0,0,.25), inset 0 -1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 3px rgba(0,0,0,.25), inset 0 -1px 0 rgba(0,0,0,.1);
            color: #333333;
            padding: 8px;
            line-height: 18px;
            cursor: pointer;
        }
        #reportrange .caret {
            margin-top: 8px;
            margin-left: 2px;
        }
        #reportrange span {
            padding-left: 3px;
        }
    </style>

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
            <li class="active"><?php echo lang('reports');?></li>
        </ul>
    </div>

    <div class="page-content">

        <div class="page-header position-relative">
            <h1>
                <?php echo lang('reports');?>
                <small>
                    <i class="icon-double-angle-right"></i>
                    <?php echo "Llençol general de centre per període acadèmic"; ?>
                </small>
            </h1>
        </div>




        <div class="space-5"></div>
        <div style="margin:10px;">
            <div class="container">


                <div class="row-fluid">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="table_filter" width="90%">
                        <thead style="background-color: #d9edf7;">
                        <tr>
                            <td colspan="3" style="text-align: center;"> <strong>Filtres
                                </strong></td>
                        </tr>
                        <tr>
                            <td><?php echo "Indiqueu el període acadèmic"?>:</td>
                            <td>
                                <select id="select_class_list_academic_period_filter">
                                    <?php foreach ($academic_periods as $academic_period_key => $academic_period_value) : ?>
                                        <?php if ( $selected_academic_period_id) : ?>
                                            <?php if ( $academic_period_key == $selected_academic_period_id) : ?>
                                                <option selected="selected" value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if ( $academic_period_value->current == 1) : ?>
                                                <option selected="selected" value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-mini btn-success" id="show_report">
                                    <i class="icon-bolt"></i>
                                    Mostrar informe
                                    <i class="icon-arrow-right icon-on-right"></i>
                                </button>
                            </td>
                        </tr>
                        </thead>
                    </table>

                </div>







            </div>



        </div>

        <script>

            $(function() {

                $("#select_all").click(function() {

                    $('input:checkbox[name="student-checkbox"]').map(function () {
                        this.checked = true;
                    }).get();

                });

                $("#unselect_all").click(function() {

                    $('input:checkbox[name="student-checkbox"]').map(function () {
                        this.checked = false;
                    }).get();

                });


                $("#select_class_list_academic_period_filter").select2();

                $("#academic_period_text").text( $("#select_class_list_academic_period_filter").select2("data").text);


                $("#show_report").click(function() {
                    var selectedValue = $("#select_class_list_academic_period_filter").select2("val");
                    console.log(selectedValue);
                    var pathArray = window.location.pathname.split( '/' );
                    var secondLevelLocation = pathArray[1];
                    var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/reports/general_sheet";
                    window.location.href = baseURL + "/" + selectedValue;

                });


            });


        </script>