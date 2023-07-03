<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="_buttons">
          <a href="<?= admin_url('multi100/partners/create'); ?>" class="btn btn-primary mright5 test pull-left display-block">
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
                  <th>Nome</th>
                  <th>Telefone</th>
                  <th>Documento</th>
                  <th>Comissão</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($get_partners->partners as $get_partner) :  ?>
                  <tr>
                    <td><?= $get_partner->id ?></td>
                    <td><?= $get_partner->name ?></td>
                    <td><?= $get_partner->phone ?></td>
                    <td><?= $get_partner->document ?></td>
                    <td><?= ($get_partner->typeCommission == 'percentualValue') ? number_format($get_partner->commission, 2, ',', '.') . ' %' : number_format($get_partner->commission, 2, ',', '.') ?></td>
                    <td>
                      <a class="btn btn-info" href="<?= admin_url('multi100/partners/read/' . $get_partner->id); ?>">
                        <i class="fa fa-search"></i>
                      </a>
                      <a class="btn btn-warning" href=" <?= admin_url('multi100/partners/update/' . $get_partner->id); ?> ">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn btn-danger" href="<?= admin_url('multi100/partners/delete/' . $get_partner->id); ?>" onclick="javasciprt: return confirm('Confirmar exclusão?')">
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