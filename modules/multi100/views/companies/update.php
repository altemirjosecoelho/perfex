<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-offset-3 col-md-6">
            <h4>Editar Cliente</h4>
            <div class="panel_s">
              <div class="panel-body">
                <!-- csrf -->
                <input type="hidden" name="csrf_token" value="<?= $this->security->get_csrf_hash(); ?>" />
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label" for="partnerId">Parceiro</label>
                      <select id="partnerId" name="partnerId" class="form-control">
                        <option value="0" <?= (is_null($get_company->partnerId)) ? "selected" : null ?>>Sem parceiro</option>
                        <?php foreach ($get_partners->partners as $get_partner) :  ?>
                          <option value="<?= $get_partner->id ?>" <?= ($get_partner->id == $get_company->partnerId) ? "selected" : null ?>><?= $get_partner->name ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label" for="planId">Plano</label>
                      <select id="planId" name="planId" class="form-control">
                        <?php foreach ($get_plans->plans as $app_plan) :  ?>
                          <option value="<?= $app_plan->id ?>" <?= ($app_plan->id == $get_company->planId) ? "selected" : null ?>><?= $app_plan->name ?></option>
                        <?php endforeach;  ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <label class="control-label" for="name">Nome</label>
                    <input id="name" name="name" type="text" class="form-control" value="<?= $get_company->name ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label class="control-label" for="phone">Telefone</label>
                    <input id="phone" name="phone" type="text" class="form-control" value="<?= $get_company->phone ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label class="control-label" for="email">Email</label>
                    <input id="email" name="email" type="text" class="form-control" value="<?= $get_company->email ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label class="control-label" for="document">Documento</label>
                    <input id="document" name="document" type="text" class="form-control" value="<?= $get_company->document ?>">
                  </div>
                </div>
                <div class="form-group">
                  <button type="button" class="btn btn-primary pull-right" id="save">Salvar</button>
                  <a href=" <?= admin_url('multi100/companies') ?>" class="btn btn-default pull-left">Voltar</a>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php init_tail(); ?>

<script type="application/javascript">
  $('#save').on('click', function() {
    $('#save').attr('disabled', true);

    const partnerId = $('#partnerId').val();
    const planId = $('#planId').val();
    const name = $('#name').val();
    const phone = $('#phone').val();
    const email = $('#email').val();
    const document = $('#document').val();

    if (!name || !phone || !email || !document || !planId) {
      alert_float('danger', 'Preencha todos os campos');
      $('#save').attr('disabled', false);
      return;
    }

    const data = {
      partnerId,
      planId,
      name,
      phone,
      email,
      document,
    };

    $.ajax({
      type: 'POST',
      url: '<?= admin_url('multi100/companies/update/' . $get_company->id) ?>',
      data: data,
      success: function(response) {
        if (response.success) {
          alert_float('success', response.message);
          $('#save').attr('disabled', false);

          setTimeout(() => {
            window.location.href = '<?= admin_url('multi100/companies') ?>';
          }, 1000);
        }
      },
      error: function(error) {
        $('#save').attr('disabled', false);
        alert_float('danger', JSON.parse(error.responseText));
      }
    });
  });
</script>