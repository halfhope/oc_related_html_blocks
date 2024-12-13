<style>
html {
	overflow-y: scroll;
}
.related_html_widget .well-sm {
	padding: 7px;
	margin-bottom: 10px;
	max-height: 200px;
	overflow-y: scroll;
	min-height: 36.56px!important;
}
.related_html_widget .well-sm .checkbox {
	min-height: unset;
	padding-top: 0px;
	padding-bottom: 0;
	border: 0;
}
.related_html_widget .well-sm .checkbox label {
	display: flex;
	justify-content: flex-start;
	align-items: center;
	padding-left: 15px;
}
.related_html_widget .well-sm .checkbox label input[type="checkbox"] {
	margin-right: 5px;
}
.related_html_widget .well-sm .table {
	margin: 0;
}
.related_html_widget .well-sm .table tbody tr {
	background: none;
}
</style>

<script>
function invertSelection(sender) {
	$.each($(sender).closest('.form-group').find('input[type=checkbox]'), function(index, value){
		$(value).prop('checked', !$(value).prop('checked'));
	});
}
</script>

<div class="form-group related_html_widget">
	<label class="col-sm-2 control-label" for="input-process-status"><span data-toggle="tooltip" title="<?php echo $entry_related_html_help; ?>"><?php echo $entry_related_html; ?></span></label>
	<div class="col-sm-10">
		<div class="well well-sm">
			<table class="table table-striped">
				<?php foreach ($htmls as $html) { ?> 
				<tr>
					<td class="checkbox">
						<label>
							<?php if (in_array($html['html_id'], $related_htmls)) { ?>
							<input type="checkbox" name="related_htmls[]" value="<?php echo $html['html_id']; ?>" checked="checked" />
							<?php echo $html['name']; ?>
							<?php } else { ?>
							<input type="checkbox" name="related_htmls[]" value="<?php echo $html['html_id']; ?>" />
							<?php echo $html['name']; ?>
							<?php } ?>
						</label>
					</td>
				</tr>
				<?php } ?>
			</table>
		</div>
		<a href="#" onclick="$(this).parent().find(':checkbox').prop('checked', true);return false;"><?php echo $text_select_all ?></a> / <a href="#" onclick="$(this).parent().find(':checkbox').prop('checked', false);return false;"><?php echo $text_unselect_all ?></a> / <a href="#" onclick="invertSelection(this);return false;"><?php echo $text_invert_selection ?></a> / <a href="<?php echo $add ?>" target="_blank"><?php echo $text_add ?></a>
	</div>
</div>