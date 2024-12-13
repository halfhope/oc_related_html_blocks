<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<style>
html {
	overflow-y: scroll;
}
.input-code {
	min-height: 250px;
}
.btn-divider {
	display: inline-block;
	width: 1px;
	padding: 7px 0px;
	margin: 0px 5px;
	background: #cdcdcd;
	border: none;
}
.form-group .ui-switcher {
	margin-top: 9px;
}
</style>
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-module" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3><h3 class="panel-title pull-right">v<?php echo $version; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $save; ?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">

					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
						<div class="col-sm-10">
							<input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
							<?php if ($error_name) { ?>
								<div class="text-danger"><?php echo $error_name; ?></div>
							<?php } ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
						<div class="col-sm-10">
							<input type="checkbox" class="switcher ui-switcher form-control" data-target="hidden-status" <?php echo ($status == 1) ? 'checked' : ''; ?> >
							<input type="hidden" id="hidden-status" name="status" value="<?php echo $status ?>">
						</div>
					</div>
					
					<ul class="nav nav-tabs" id="language">
						<?php foreach ($languages as $language) { ?>
							<li><a href="#language<?php echo $language['language_id'] ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
						<?php } ?>
					</ul>

					<div class="tab-content">
						<?php foreach ($languages as $language) { ?>
						<div class="tab-pane" id="language<?php echo $language['language_id'] ?>">

							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-code-<?php echo $language['language_id'] ?>"><?php echo $entry_code_module; ?></label>
								<div class="col-sm-10">
									<pre id="input-code-<?php echo $language['language_id'] ?>" class="input-code"></pre>
									<input type="hidden" name="code[<?php echo $language['language_id'] ?>]" id="hidden-code-<?php echo $language['language_id'] ?>" value="<?php echo $code[$language['language_id']]; ?>">
									<div class="help-block" role="alert"><?php echo $entry_code_module_desc; ?></div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-file_name-<?php echo $language['language_id'] ?>"><span data-toggle="tooltip" title="<?php echo $entry_file_name_help; ?>"><?php echo $entry_file_name; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="file_name[<?php echo $language['language_id'] ?>]" value="<?php echo $file_name[$language['language_id']]; ?>" placeholder="<?php echo $entry_file_name; ?>" id="input-file_name-<?php echo $language['language_id'] ?>" class="form-control" />
									<div class="help-block" role="alert"><?php echo $entry_file_name_desc; ?></div>
								</div>
							</div>

						</div>
						<?php } ?>
					</div>
					
				</form>
			</div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.9.6/ace.min.js" integrity="sha512-U2JKYiHG3ixOjmdycNbi4Xur8q4Nv73CscCGEopBeiVyzDR5ErC6jmHNr0pOB8CUVWb0aQXLgL0wYXhoMU6iqw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
<?php foreach ($languages as $language) { ?>
let jsEditorWrapper<?php echo $language['language_id'] ?>;
let jsEditor<?php echo $language['language_id'] ?>;
<?php } ?>
$(document).ready(function() {

	window.ace.config.set('basePath', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.9.6/');
	<?php foreach ($languages as $language) { ?>
	jsEditorWrapper<?php echo $language['language_id'] ?> = document.querySelector('#input-code-<?php echo $language['language_id'] ?>');
	jsEditor<?php echo $language['language_id'] ?> = window.ace.edit(jsEditorWrapper<?php echo $language['language_id'] ?>);
	jsEditor<?php echo $language['language_id'] ?>.setTheme('ace/theme/textmate');
	jsEditor<?php echo $language['language_id'] ?>.session.setMode('ace/mode/html');

	jsEditor<?php echo $language['language_id'] ?>.setValue($('#hidden-code-<?php echo $language['language_id'] ?>').val(), -1);
	jsEditor<?php echo $language['language_id'] ?>.focus();
	<?php } ?>

	$('#form-module').on('submit', function(e) {
		<?php foreach ($languages as $language) { ?>
		$('#hidden-code-<?php echo $language['language_id'] ?>').val(jsEditor<?php echo $language['language_id'] ?>.getValue());
		<?php } ?>
		return true;
	});

	$('.switcher').on('change', function(e) {
		$('#' + $(e.target).data('target')).val(Number($(e.target).prop('checked')));
	});

	$('#language a:first').tab('show');

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