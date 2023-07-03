<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="_buttons">
          <a href="<?= admin_url('multi100/helps/create'); ?>" class="btn btn-primary mright5 test pull-left display-block">
            <i class="fa fa-plus"></i> Adicionar novo
          </a>
        </div>
        <div class="clearfix"></div>
        <div class="panel_s tw-mt-2 sm:tw-mt-4">
          <div class="panel-body">
            <table class="table table-bordered dt-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Titulo</th>
                  <th>Descrição</th>
                  <th>Video</th>
                  <th>Link</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($get_helps->records as $get_help) :  ?>
                  <tr>
                    <td><?= $get_help->id ?></td>
                    <td><?= $get_help->title ?></td>
                    <td><?= substr($get_help->description, 0, 100) ?></td>
                    <td><?= $get_help->video ?></td>
                    <td><?= $get_help->link ?></td>
                    <td>
                      <a class="btn btn-info" href="<?= admin_url('multi100/helps/read/' . $get_help->id); ?>">
                        <i class="fa fa-search"></i>
                      </a>
                      <a class="btn btn-warning" href=" <?= admin_url('multi100/helps/update/' . $get_help->id); ?> ">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn btn-danger" href="<?= admin_url('multi100/helps/delete/' . $get_help->id); ?>" onclick="javasciprt: return confirm('Confirmar exclusão?')">
                        <i class="fa fa-times"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>