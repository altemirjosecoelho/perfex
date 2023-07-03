<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        <h4>Detalhes do envio </h4>
        <div class="panel_s tw-mt-2 sm:tw-mt-4">
          <div class="panel-body">
            <table class="table table-striped">
              <tr>
                <th>Lead</th>
                <td><?= $get_submission->name ?></td>
              </tr>
              <tr>
                <th>Data</th>
                <td><?= _dt($get_submission->created_at); ?></td>
              </tr>
              <tr>
                <th>Plano</th>
                <td><?php if ($get_submission->perfex_client == 0) : ?>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/retry/' . $get_submission->id . '/multi100_plan'); ?>">
                      Reenviar
                    </a>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/payload/' . $get_submission->id . '/multi100_plan'); ?>">
                      Dados retorno
                    </a>
                  <?php else : ?>
                    <button type="button" class="btn btn-success">OK</button>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th>Lead perfex</th>
                <td><?php if ($get_submission->perfex_lead == 0) : ?>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/retry/' . $get_submission->id); ?>">
                      Reenviar
                    </a>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/payload/' . $get_submission->id); ?>">
                      Dados retorno
                    </a>
                  <?php else : ?>
                    <button type="button" class="btn btn-success">OK</button>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th>Cliente perfex</th>
                <td><?php if ($get_submission->multi100_plan == 0) : ?>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/retry/' . $get_submission->id); ?>">
                      Reenviar
                    </a>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/payload/' . $get_submission->id); ?>">
                      Dados retorno
                    </a>
                  <?php else : ?>
                    <button type="button" class="btn btn-success">OK</button>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th>Contato perfex</th>
                <td><?php if ($get_submission->perfex_contact == 0) : ?>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/retry/' . $get_submission->id); ?>">
                      Reenviar
                    </a>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/payload/' . $get_submission->id); ?>">
                      Dados retorno
                    </a>
                  <?php else : ?>
                    <button type="button" class="btn btn-success"> OK</button>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th>Cliente asaas</th>
                <td><?php if ($get_submission->asaas_customer == 0) : ?>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/retry/' . $get_submission->id . '/asaas_customer'); ?>">
                      Reenviar
                    </a>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/payload/' . $get_submission->id . '/asaas_customer'); ?>">
                      Dados retorno
                    </a>
                  <?php else : ?>
                    <button type="button" class="btn btn-success">OK</button>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th>Assinatura Asaas</th>
                <td><?php if ($get_submission->asaas_subscription == 0) : ?>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/retry/' . $get_submission->id . '/asaas_subscription'); ?>">
                      Reenviar
                    </a>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/payload/' . $get_submission->id . '/asaas_subscription'); ?>">
                      Dados retorno
                    </a>
                  <?php else : ?>
                    <button type="button" class="btn btn-success">OK</button>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th>Cliente multi100</th>
                <td><?php if ($get_submission->multi100_client == 0) : ?>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/retry/' . $get_submission->id . '/multi100_customer'); ?>">
                      Reenviar
                    </a>
                    <a class="btn btn-default" href="<?= admin_url('multi100/submissions/payload/' . $get_submission->id . '/multi100_customer'); ?>">
                      Dados retorno
                    </a>
                  <?php else : ?>
                    <button type="button" class="btn btn-success">OK</button>
                  <?php endif; ?>
                </td>
              </tr>
            </table>
            <a href="<?= admin_url('multi100/submissions') ?>" class="btn btn-primary pull-right">Voltar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>