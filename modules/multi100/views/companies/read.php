<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <h4>Detalhes do Cliente</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="panel_s tw-mt-2 sm:tw-mt-4">
                  <div class="panel-body">
                    <table class="table table-striped">
                      <tr>
                        <th>Nome</th>
                        <td><?= $get_company->name ?></td>
                      </tr>
                      <tr>
                        <th>Plano</th>
                        <td><?= $get_company->planId ?> - <?= $get_company->plan->name ?></td>
                      </tr>
                      <tr>
                        <th>Parceiro</th>
                        <td><?= $get_company->partner->name ?></td>
                      </tr>
                      <tr>
                        <th>Telefone</th>
                        <td><?= $get_company->phone ?></td>
                      </tr>
                      <tr>
                        <th>Email</th>
                        <td><?= $get_company->email ?></td>
                      </tr>
                      <tr>
                        <th>Documento</th>
                        <td><?= $get_company->document ?></td>
                      </tr>
                      <tr>
                        <th>Recorrência</th>
                        <td><?= $get_company->recurrence ?></td>
                      </tr>
                      <tr>
                        <th>Vencimento</th>
                        <td><?= date_fmt($get_company->dueDate) ?></td>
                      </tr>
                      <tr>
                        <th>Último Login</th>
                        <td><?= date_fmt($get_company->lastLogin) ?></td>
                      </tr>
                      <tr>
                        <th>Data cadastro</th>
                        <td><?= date_fmt($get_company->createdAt); ?></td>
                      </tr>
                      <tr>
                        <th>Data alteração</th>
                        <td><?= date_fmt($get_company->updatedAt) ?></td>
                      </tr>
                      <!--    -->
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="panel_s tw-mt-2 sm:tw-mt-4">
                  <div class="panel-body">
                    <table class="table table-striped">
                      <tr>
                        <th>Formulario</th>
                        <td><?= $get_submission->id ?> - <?= $get_submission->form_name ?></td>
                      </tr>
                      <tr>
                        <th>Assinatura Asaas</th>
                        <td><?= $get_subscription->id ?> - <?= $get_subscription->description ?></td>
                      </tr>
                      <tr>
                        <th>Cliente Asaas</th>
                        <td><?= $get_customer->id ?> - <?= $get_customer->name ?></td>
                      </tr>
                      <tr>
                        <th>Cliente Perfex</th>
                        <td><?= $get_perfex_client->userid ?> - <?= $get_perfex_client->company ?></td>
                      </tr>
                      <tr>
                        <th>Contato Perfex</th>
                        <td><?= $get_perfex_contact->id ?> - <?= $get_perfex_contact->firstname ?></td>
                      </tr>
                      <tr>
                        <th>Lead Perfez</th>
                        <td><?= $get_perfex_lead->id ?> - <?= $get_perfex_lead->name ?></td>
                      </tr>
                      <!--    -->
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <a href="<?= admin_url('multi100/companies') ?>" class="btn btn-primary pull-right">
              Voltar
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>