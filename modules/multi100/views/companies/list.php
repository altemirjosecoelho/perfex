<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="_buttons">
          <a href="<?= admin_url('multi100/companies/create'); ?>" class="btn btn-primary mright5 test pull-left display-block">
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
                  <th>Email</th>
                  <th>Documento</th>
                  <th>Vencimento</th>
                  <th>Plano</th>
                  <th>Paceiro</th>
                  <th>Data</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($get_companies->companies as $get_company) :  ?>
                  <tr>
                    <td><?= $get_company->id ?></td>
                    <td><?= $get_company->name ?></td>
                    <td><?= $get_company->phone ?></td>
                    <td><?= $get_company->email ?></td>
                    <td><?= $get_company->document ?></td>
                    <td><?= date_fmt($get_company->dueDate) ?></td>
                    <td><?= $get_company->plan->name ?? null ?></td>
                    <td><?= $get_company->partner->name ?? null ?></td>
                    <td><?= date_fmt($get_company->createdAt); ?></td>
                    <td>
                      <a class="btn btn-info" href="<?= admin_url('multi100/companies/read/' . $get_company->id); ?>">
                        <i class="fa fa-search"></i>
                      </a>
                      <a class="btn btn-warning" href=" <?= admin_url('multi100/companies/update/' . $get_company->id); ?> ">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn btn-danger" href="<?= admin_url('multi100/companies/delete/' . $get_company->id); ?>" onclick="javasciprt: return confirm('Confirmar exclusão?')">
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