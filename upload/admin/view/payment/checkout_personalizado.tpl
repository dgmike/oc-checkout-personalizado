<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"></div>

      <h1><?php echo $heading_title; ?></h1>

      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb): ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php endforeach ?>
      </ul>

    </div>
  </div>
</div>

<?php echo $footer; ?>
