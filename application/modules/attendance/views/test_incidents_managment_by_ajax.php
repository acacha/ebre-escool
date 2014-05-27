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
  <li class="active"><?php echo lang('attendance_managment');?></li>
 </ul>
</div>



        <div class="page-header position-relative">
                        <h1>
                            <?php echo lang("attendance_managment");?>
                            <small>
                                <i class="icon-double-angle-right"></i>
                                test_incidents_managment_by_ajax
                            </small>
                        </h1>
        </div><!-- /.page-header -->
		<div style='height:10px;'></div>
		<div style="margin:10px;">


		<div style='margin:0 0 .5em 0;'>
			<!-- when clicked, it will show the user's list -->
			<div id='viewUsers' class='customBtn'>View Incidents</div>

			<!-- when clicked, it will load the add user form -->
			<div id='addUser' class='customBtn'>+ New Incident</div>
			
			<!-- this is the loader image, hidden at first -->
			<div id='loaderImage'><img src='<?php echo base_url();?>assets/img/ajax-loader.gif' /></div>
			
			<div style='clear:both;'></div>
		</div>

		<!-- this is wher the contents will be shown. -->
		<div id='pageContent'></div>


	
</div>
</div>

<script type='text/javascript'>
$(document).ready(function(){
	
	// VIEW USERS on load of the page
	$('#loaderImage').show();
	showIncidents();
	
	// clicking the 'VIEW USERS' button
	$('#viewUsers').click(function(){
		// show a loader img
		$('#loaderImage').show();
		
		showIncidents();
	});
	
	// clicking the '+ NEW USER' button
	$('#addUser').click(function(){
		showCreateUserForm();
	});

	// clicking the EDIT button
	$(document).on('click', '.editBtn', function(){ 
	
		var user_id = $(this).closest('td').find('.userId').text();
		console.log(user_id);
		
		// show a loader image
		$('#loaderImage').show();

		// read and show the records after 1 second
		// we use setTimeout just to show the image loading effect when you have a very fast server
		// otherwise, you can just do: $('#pageContent').load('update_form.php?user_id=" + user_id + "', function(){ $('#loaderImage').hide(); });
		setTimeout("$('#pageContent').load('update_form.php?user_id=" + user_id + "', function(){ $('#loaderImage').hide(); });",1000);
		
	});	
	
	
	// when clicking the DELETE button
    $(document).on('click', '.deleteBtn', function(){ 
        if(confirm('Are you sure?')){
		
            // get the id
			var user_id = $(this).closest('td').find('.userId').text();
			
			// trigger the delete file
			$.post("delete.php", { id: user_id })
				.done(function(data) {
					// you can see your console to verify if record was deleted
					console.log(data);
					
					$('#loaderImage').show();
					
					// reload the list
					showIncidents();
					
				});

        }
    });
	
	
    // CREATE FORM IS SUBMITTED
     $(document).on('submit', '#addUserForm', function() {

		// show a loader img
		$('#loaderImage').show();
		
		// post the data from the form
		$.post("<?php echo base_url()?>index.php/attendance/insert_incidents", $(this).serialize())
			.done(function(data) {
				// 'data' is the text returned, you can do any conditions based on that
				//TODO: treat errors!!!!!!!!!!!!!!!!!!!
				showIncidents();
			});
	 			
        return false;
    });
	
    // UPDATE FORM IS SUBMITTED
     $(document).on('submit', '#updateUserForm', function() {

		// show a loader img
		$('#loaderImage').show();
		
		// post the data from the form
		$.post("update.php", $(this).serialize())
			.done(function(data) {
				// 'data' is the text returned, you can do any conditions based on that
				showIncidents();
			});
	 			
        return false;
    });
	
});

// READ USERS
function showIncidents(){
	// read and show the records after at least a second
	// we use setTimeout just to show the image loading effect when you have a very fast server
	// otherwise, you can just do: $('#pageContent').load('read.php', function(){ $('#loaderImage').hide(); });
	// THIS also hides the loader image
	setTimeout("$('#pageContent').load('attendance/read_test_incidents_managment_by_ajax', function(){ $('#loaderImage').hide(); });", 1000);
}

// CREATE USER FORM
function showCreateUserForm(){
	// show a loader image
	$('#loaderImage').show();
	
	// read and show the records after 1 second
	// we use setTimeout just to show the image loading effect when you have a very fast server
	// otherwise, you can just do: $('#pageContent').load('read.php');
	setTimeout("$('#pageContent').load('attendance/create_test_incidents_managment_by_ajax', function(){ $('#loaderImage').hide(); });",1000);
}
</script>

