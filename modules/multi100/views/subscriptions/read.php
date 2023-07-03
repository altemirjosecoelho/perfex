<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s tw-mt-2 sm:tw-mt-4">
          <div class="panel-body">
            <table class="table table-bordered dt-table">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Status</th>
                  <th>Meio de pagamento</th>
                  <th>Valor</th>
                  <th>Vencimento</th>
                  <th>Vencimento original</th>
                  <th>Data de pagamento</th>
                  <th>Data de pagamento cliente</th>
                  <th>Data criação</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($get_subscription_payments->data as $get_subscription_payment) :  ?>
                  <tr>
                    <td><?= $get_subscription_payment->id ?></td>
                    <td><?= get_payment_status_name($get_subscription_payment->status) ?></td>
                    <td><?= get_payment_method($get_subscription_payment->billingType) ?></td>
                    <td><?= app_format_money($get_subscription_payment->value, 'BRL') ?></td>
                    <td><?= _d($get_subscription_payment->dueDate) ?></td>
                    <td><?= _d($get_subscription_payment->originalDueDate) ?></td>
                    <td><?= _d($get_subscription_payment->paymentDate) ?></td>
                    <td><?= _d($get_subscription_payment->clientPaymentDate) ?></td>
                    <td><?= _d($get_subscription_payment->dateCreated) ?></td>
                    <td>
                      <a class="btn btn-info" href="<?= $get_subscription_payment->invoiceUrl ?>" target="_blank">
                        <i class="fa fa-search"></i>
                        Fatura
                      </a>
                      <?php if ($get_subscription_payment->transactionReceiptUrl) : ?>
                        <a class="btn btn-info" href="<?= $get_subscription_payment->transactionReceiptUrl ?>" target="_blank">
                          <i class="fa fa-search"></i>
                          Recibo
                        </a>
                      <?php endif; ?>
                    </td>
                  <?php endforeach; ?>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>