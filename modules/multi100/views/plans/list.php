<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="_buttons"> <a href="<?= admin_url('multi100/plans/create'); ?>" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            Adicionar novo
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
                  <th>Usuários</th>
                  <th>Conexões</th>
                  <th>Departamentos</th>
                  <th>Valor</th>
                  <th>Teste Grátis</th>
                  <th>Dias</th>
                  <th>Recorrência</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($get_plans->plans as $get_plan) :  ?>
                  <tr>
                    <td><?= $get_plan->id ?></td>
                    <td><?= $get_plan->name ?></td>
                    <td><?= $get_plan->users ?></td>
                    <td><?= $get_plan->connections ?></td>
                    <td><?= $get_plan->queues ?></td>
                    <td><?= number_format($get_plan->amount, 2, ',', '.')  ?></td>
                    <td><?= get_conditional_name($get_plan->trial) ?></td>
                    <td><?= $get_plan->trialDays ?></td>
                    <td><?= $get_plan->recurrence ?></td>
                    <td>
                      <a class="btn btn-info" href="<?= admin_url('multi100/plans/read/' . $get_plan->id); ?>">
                        <i class="fa fa-search"></i>
                      </a>
                      <a class="btn btn-warning" href=" <?= admin_url('multi100/plans/update/' . $get_plan->id); ?> ">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn btn-danger" href="<?= admin_url('multi100/plans/delete/' . $get_plan->id); ?>" onclick="javasciprt: return confirm('Confirmar exclusão?')">
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