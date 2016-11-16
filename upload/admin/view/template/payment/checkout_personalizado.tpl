<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-checkout-personalizado" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
      </div>

      <h1>
        <?php echo $heading_title; ?>
        <span class="badge"><?php echo $version; ?></span>
      </h1>

      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb): ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php endforeach ?>
      </ul>

    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-checkout-personalizado" class="form-horizontal">

          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-geral" data-toggle="tab"><?php echo $tab_geral; ?></a></li>
            <li><a href="#tab-api" data-toggle="tab"><?php echo $tab_api; ?></a></li>
            <li><a href="#tab-situacoes" data-toggle="tab"><?php echo $tab_situacoes; ?></a></li>
            <li><a href="#tab-finalizacao" data-toggle="tab"><?php echo $tab_finalizacao; ?></a></li>
          </ul>

          <div class="tab-content">

            <div class="tab-pane active" id="tab-geral">

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-total">
                  <span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span>
                </label>
                <div class="col-sm-10">
                  <input type="text" name="<?php echo $modification_code; ?>_total" value="<?php echo $checkoutp_total ?>" placeholder="<?php echo $entry_total ?>" id="input-total" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone ?></label>
                <div class="col-sm-10">
                  <select name="mundipagg_boleto_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status ?></label>
                <div class="col-sm-10">
                  <select name="mundipagg_boleto_status" id="input-status" class="form-control">
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="mundipagg_boleto_sort_order" value="" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>

            </div><!-- / #tab-geral -->

            <div class="tab-pane" id="tab-api">
            </div><!-- / #tab-api -->

            <div class="tab-pane" id="tab-situacoes">
            </div><!-- / #tab-situacoes -->

            <div class="tab-pane" id="tab-finalizacao">
            </div><!-- / #tab-finalizacao -->

          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>
