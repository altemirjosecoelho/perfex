<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="_buttons">
          <a href="<?= admin_url('multi100/subscriptions/create'); ?>" class="btn btn-primary mright5 test pull-left display-block">
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
                  <th>status</th>
                  <th>Meio de pagamento</th>
                  <th>Valor</th>
                  <th>Descrição</th>
                  <th>Proximo vencimento</th>
                  <th>Periodo</th>
                  <th>Cliente Asaas</th>
                  <th>Data criação</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($get_subscriptions->data as $get_subscription) :  ?>
                  <tr>
                    <td><?= $get_subscription->id ?></td>
                    <td><?= get_status_name($get_subscription->status) ?></td>
                    <td><?= get_payment_method($get_subscription->billingType) ?></td>
                    <td><?= app_format_money($get_subscription->value, 'BRL') ?></td>
                    <td><?= $get_subscription->description ?></td>
                    <td><?= date_fmt($get_subscription->nextDueDate) ?></td>
                    <td><?= get_cycle_name($get_subscription->cycle) ?></td>
                    <td><?= $get_subscription->customer ?></td>
                    <td><?= date_fmt($get_subscription->dateCreated) ?></td>
                    <td>
                      <a class="btn btn-info" href="<?= admin_url('multi100/subscriptions/read/' . $get_subscription->id); ?>">
                        <i class="fa fa-search"></i>
                      </a>
                      <a class="btn btn-warning" href=" <?php echo admin_url('multi100/subscriptions/update/' . $get_subscription->id); ?> ">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn btn-danger" href="<?php echo admin_url('multi100/subscriptions/delete/' . $get_subscription->id); ?>" onclick="javasciprt: return confirm('Confirmar exclusão?')">
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