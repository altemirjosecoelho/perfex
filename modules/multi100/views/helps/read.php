<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        <h4>Detalhes da Ajuda</h4>
        <div class="panel_s tw-mt-2 sm:tw-mt-4">
          <div class="panel-body">
            <table class="table table-striped">
              <tr>
                <th>Titulo</th>
                <td><?= $get_help->title ?></td>
              <tr>
                <th>Video</th>
                <td><?= $get_help->video ?></td>
              </tr>
              <tr>
                <th>Link</th>
                <td><?= $get_help->link ?></td>
              </tr>
              <tr>
                <th>Descrição</th>
                <td><?= $get_help->description ?></td>
              </tr>
              <tr>
                <th>Data cadastro</th>
                <td><?= _dt($get_help->createdAt) ?></td>
              </tr>
              <tr>
                <th>Data alteração</th>
                <td><?= _dt($get_help->updatedAt) ?></td>
              </tr>
            </table>
            <a href=" <?= admin_url('multi100/helps') ?>" class="btn btn-primary pull-right">Voltar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>