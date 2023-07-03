<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <h4>Detalhes do Plano</h4>
        <div class="row">
          <div class="col-md-6">
            <div class="panel_s tw-mt-2 sm:tw-mt-4">
              <div class="panel-body">
                <table class="table table-striped">
                  <tr>
                    <th>Nome</th>
                    <td><?= $get_plan->name ?></td>
                  </tr>
                  <tr>
                    <th>Valor</th>
                    <td><?= number_format($get_plan->amount, 2, ',', '.') ?></td>
                  </tr>
                  <tr>
                    <th>Usuários</th>
                    <td><?= $get_plan->users ?></td>
                  </tr>
                  <tr>
                    <th>Conexões</th>
                    <td><?= $get_plan->connections ?></td>
                  </tr>
                  <tr>
                    <th>Departamentos</th>
                    <td><?= $get_plan->queues ?></td>
                  </tr>
                  <tr>
                    <th>Data cadastro</th>
                    <td><?= _dt($get_plan->createdAt); ?></td>
                  </tr>
                  <tr>
                    <th>Data alteração</th>
                    <td><?= _dt($get_plan->updatedAt) ?></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="panel_s tw-mt-2 sm:tw-mt-4">
              <div class="panel-body">
                <table class="table table-striped">
                  <tr>
                    <th>Whatsapp</th>
                    <td><?= get_conditional_name($get_plan->useWhatsapp) ?></td>
                  </tr>

                  <th>Facebook</th>
                  <td><?= get_conditional_name($get_plan->useFacebook) ?></td>
                  </tr>
                  <tr>
                    <th>Instagram</th>
                    <td><?= get_conditional_name($get_plan->useInstagram) ?></td>
                  </tr>
                  <tr>
                    <th>Campanhas</th>
                    <td><?= get_conditional_name($get_plan->useCampaigns) ?></td>
                  </tr>
                  <tr>
                    <th>Agendamentos</th>
                    <td><?= get_conditional_name($get_plan->useSchedules) ?></td>
                  </tr>
                  <tr>
                    <th>Chat Interno</th>
                    <td><?= get_conditional_name($get_plan->useInternalChat) ?></td>
                  </tr>
                  <tr>
                    <th>API Externa</th>
                    <td><?= get_conditional_name($get_plan->useExternalApi) ?></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        <a href="<?= admin_url('multi100/plans') ?>" class="btn btn-primary pull-right">
          Voltar
        </a>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<?php init_tail(); ?>