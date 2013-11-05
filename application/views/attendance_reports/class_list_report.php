<!-- TITLE -->
<div style='height:30px;'></div>
	<div style="margin:10px;">
		<h2><?php echo lang('reports_group_reports_class_list'); ?></h2>
	</div>	


	<!-- FORM -->    
	<div style="width:40%; margin:0px auto;">
		<form method="post" action="#" class="form-horizontal" role="form">
			<table class="table table-bordered" cellspacing="10" cellpadding="5">
				<div class="form-group ui-widget">
					<tr>
						<td><label for="grup">Selecciona el grup:</label></td>
						<td><select class="chosen-select" data-place_holder="TODO" style="width:400px;" id="grup" name="grup" data-size="5" data-live-search="true">
							<?php foreach ($grups as $key => $value) { ?>
								<option value="<?php echo $key ?>" ><?php echo $value ?></option>
							<?php } ?>
							</select>	
						</td>
					</tr>	
				</div>
				<div class="form-group">
					<tr>
						<td colspan="2" style="text-align:center;"><input type="checkbox" name="incident" value="foto" checked> Amb foto</input></td>
					</tr>					
					<tr>
						<td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td>
					</tr>
			</table>
		</form>

	</div>	