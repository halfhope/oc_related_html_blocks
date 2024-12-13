<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<style>
html {
	overflow-y: scroll;
}
.btn-divider {
	display: inline-block;
	width: 1px;
	padding: 7px 0px;
	margin: 0px 5px;
	background: #cdcdcd;
	border: none;
}
table > tbody > tr > td:nth-child(2) {
	cursor: pointer;
}
</style>
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a href="<?php echo $add_block ?>" data-toggle="tooltip" title="<?php echo $button_add ?>" class="btn btn-success"><i class="fa fa-plus"></i></a>
				<span type="button" class="btn-divider">&nbsp;</span>
				<button type="submit" form="form-module" formaction="<?php echo $clone ?>" data-toggle="tooltip" title="<?php echo $button_clone ?>" class="btn btn-default form-action"><i class="fa fa-copy"></i></button>
				<button type="submit" form="form-module" formaction="<?php echo $multiple_edit ?>" data-toggle="tooltip" title="<?php echo $text_multiple ?>" class="btn btn-primary form-action"><i class="fa fa-pencil"></i></button>
				<button type="submit" form="form-module" formaction="<?php echo $delete ?>" data-toggle="tooltip" title="<?php echo $button_delete ?>" class="btn btn-danger form-action" disabled id="button-delete"><i class="fa fa-trash"></i></button>
				<span type="button" class="btn-divider">&nbsp;</span>
				<div class="btn-group" data-toggle="tooltip" title="<?php echo $button_modules; ?>">
					<a href="<?php echo $modules_link; ?>" type="button" class="btn btn-success"><?php echo $button_modules; ?></a>
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="<?php echo $add_module; ?>"><?php echo $button_add; ?></a></li>
						<?php if (!empty($modules)) { ?>
						<li role="separator" class="divider"></li>
						<li class="dropdown-header"><?php echo $button_modules; ?></li>
						<?php foreach ($modules as $module) { ?> 
						<li><a href="<?php echo $module['edit']; ?>"><?php echo $module['name']; ?></a></li>
						<?php } ?>
						<?php } ?>
					</ul>
				</div>
				<div class="btn-group" data-toggle="tooltip" title="<?php echo $text_list; ?>">
					<a href="<?php echo $list; ?>" type="button" class="btn btn-success"><?php echo $text_list; ?></a>
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="<?php echo $add_block; ?>"><?php echo $button_add; ?></a></li>
						<?php if (!empty($htmls_top)) { ?>
						<li role="separator" class="divider"></li>
						<li class="dropdown-header"><?php echo $text_list; ?></li>
						<?php foreach ($htmls_top as $html) { ?> 
						<li><a href="<?php echo $html['edit']; ?>"><?php echo $html['name']; ?></a></li>
						<?php } ?>
						<?php } ?>
					</ul>
				</div>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?> 
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger alert-dismissible" data-countdown><i class="fa fa-exclamation-circle"></i> <span class="countdown">[2]</span> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if ($success) { ?>
		<div class="alert alert-success alert-dismissible" data-countdown><i class="fa fa-check-circle"></i> <span class="countdown">[2]</span> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3><h3 class="panel-title pull-right">v<?php echo $version; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=selected]').prop('checked', this.checked);" /></td>
									<td class="text-left"><?php if (($sort == 'name')) { ?><a href="<?php echo $sort_name; ?>" class="<?php echo mb_strtolower($order); ?>"><?php echo $column_name; ?></a><?php } else { ?><a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a><?php } ?></td>
									<td class="text-left"><?php if (($sort == 'sort_order')) { ?><a href="<?php echo $sort_sort_order; ?>" class="<?php echo mb_strtolower($order); ?>"><?php echo $column_sort_order; ?></a><?php } else { ?><a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a><?php } ?></td>
									<td class="text-left"><?php if (($sort == 'date_added')) { ?><a href="<?php echo $sort_date_added; ?>" class="<?php echo mb_strtolower($order); ?>"><?php echo $column_date_added; ?></a><?php } else { ?><a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a><?php } ?></td>
									<td class="text-left"><?php if (($sort == 'date_edited')) { ?><a href="<?php echo $sort_date_edited; ?>" class="<?php echo mb_strtolower($order); ?>"><?php echo $column_date_edited; ?></a><?php } else { ?><a href="<?php echo $sort_date_edited; ?>"><?php echo $column_date_edited; ?></a><?php } ?></td>
									<td class="text-left" width="1"><?php echo $column_status; ?></td>
									<td class="text-right" width="1"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($htmls) { ?>
								<?php foreach ($htmls as $html) { ?> 
								<tr>
									<td class="text-center"><?php if (in_array($html['html_id'], $selected)) { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $html['html_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $html['html_id']; ?>" />
										<?php } ?>
									</td>
									<td class="text-left"><?php echo $html['name']; ?></td>
									<td class="text-left"><?php echo $html['sort_order']; ?></td>
									<td class="text-left"><?php echo $html['date_added']; ?></td>
									<td class="text-left"><?php echo $html['date_edited']; ?></td>
									<td class="text-left">
										<input type="checkbox" class="switcher ui-switcher"" value="<?php echo $html['html_id']; ?>" <?php echo ((($html['status'] == 1)) ? ('checked') : ('')); ?>>
									</td>
									<td class="text-right">
										<a href="<?php echo $html['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
									</td>
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr>
									<td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</form>
				<div class="row">
					<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
					<div class="col-sm-6 text-right"><?php echo $results; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {

	$('table > tbody > tr > td:nth-child(2)').on('click', function() {
		let $checkbox = $(this).parent('tr').find('input[type=checkbox]');
		$checkbox.prop('checked', !$checkbox.prop('checked'));
	});

	$('.form-action').on('click', function(e) {
		$('#form-module').attr('action', $(this).attr('formaction')).submit();
	});

	$('.switcher').on('change', function(e) {
		let html_id = $(e.target).val();
		let value = $(e.target).prop('checked');
		$.ajax({
			type: "POST",
			url: "<?php echo $change_status; ?>",
			data: {
				html_id: html_id,
				value: Number(value)
			},
			dataType: "json",
			success: function (response) {
				console.log(response);
			}
		});
	});

	$('#form-module input[type="checkbox"]').click(function(event) {
		var checked = $('input[type="checkbox"][name^="selected"]:checked').length;
		if (checked >= 1) {
			$('#button-delete').attr('disabled', false);
		}else{
			$('#button-delete').attr('disabled', true);
		}
	});

	$.switcher('input[type=checkbox].switcher');

	$('[data-countdown]').each(function(index, value) {
		let tid = setInterval(() => {
			let current = parseInt($(value).find('.countdown').text().match(/(\d+)/));
			$(value).find('.countdown').text('[' + (current - 1) + ']');
			if (current == 1) {
				clearInterval(tid);
				$(value).remove();
			}
		}, 1000);
	});

});
</script>
<?php echo $footer; ?>