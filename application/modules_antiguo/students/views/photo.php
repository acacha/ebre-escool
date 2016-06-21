<?php foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<center>
<table border=1 cellpadding=5 cellspacing=0>
<tr>
	<td rowspan="3">
	<?php
		echo $output;
	?>
	</td>
	<td width="250px">Nom: </td>
</tr>
<tr>
	<td>Cognoms: </td>
</tr>
<tr>
	<td>ID: </td>
</tr>

</table>
</center>