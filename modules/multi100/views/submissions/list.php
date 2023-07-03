<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="_buttons"> </div>
        <div class="clearfix"></div>
        <div class="panel_s tw-mt-2 sm:tw-mt-4">
          <div class="panel-body">
            <table class="table table-bordered dt-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Formulario</th>
                  <th>Plano Multi100</th>
                  <th>Lead Perfex</th>
                  <th>Cliente Perfex</th>
                  <th>Contato Perfex</th>
                  <th>Cliente Asaas</th>
                  <th>Assinatura Asaas</th>
                  <th>Cliente Multi100</th>
                  <th>Data</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($get_submissions as $get_submission) :  ?>
                  <tr>
                    <td><?= $get_submission->id ?></td>
                    <td><?= $get_submission->form_name ?></td>
                    <td><?= get_conditional_name($get_submission->multi100_plan); ?></td>
                    <td><?= get_conditional_name($get_submission->perfex_lead); ?></td>
                    <td><?= get_conditional_name($get_submission->perfex_client); ?></td>
                    <td><?= get_conditional_name($get_submission->perfex_contact); ?></td>
                    <td><?= get_conditional_name($get_submission->asaas_customer); ?></td>
                    <td><?= get_conditional_name($get_submission->asaas_subscription); ?></td>
                    <td><?= get_conditional_name($get_submission->multi100_client); ?></td>
                    <td><?= date_fmt($get_submission->created_at); ?></td>
                    <td>
                      <a class="btn btn-info" href="<?= admin_url('multi100/submissions/read/' . $get_submission->id); ?>">
                        <i class="fa fa-search"></i>
                      </a>
                      <a class="btn btn-warning" href=" <?= admin_url('multi100/submissions/update/' . $get_submission->id); ?> ">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a class="btn btn-danger" href="<?= admin_url('multi100/submissions/delete/' . $get_submission->id); ?>" onclick="javasciprt: return confirm('Confirmar exclusão?')">
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