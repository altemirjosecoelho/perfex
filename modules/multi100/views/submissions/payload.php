<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <h4>Dados da resposta</h4>
        <div class="panel_s tw-mt-2 sm:tw-mt-4">
          <div class="panel-body">
            <pre>
            <?= $payload; ?>
            </pre>
            <hr>
            <a href="<?= admin_url('multi100/submissions') ?>" class="btn btn-primary pull-right">Voltar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>