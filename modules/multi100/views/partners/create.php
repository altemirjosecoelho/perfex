<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-offset-3 col-md-6">
            <h4>Adicionar novo Parceiro</h4>
            <div class="panel_s tw-mt-2 sm:tw-mt-4">
              <div class="panel-body">
                <!-- csrf -->
                <input type="hidden" name="csrf_token" value="<?= $this->security->get_csrf_hash(); ?>" />
                <div class="form-group">
                  <label class="control-label" for="name">Nome</label>
                  <input id="name" name="name" type="text" class="form-control">
                </div>
                <div class="form-group">
                  <label class="control-label" for="phone">Telefone</label>
                  <input id="phone" name="phone" type="text" class="form-control">
                </div>
                <div class="form-group">
                  <label class="control-label" for="email">Email</label>
                  <input id="email" name="email" type="email" class="form-control">
                </div>
                <div class="form-group">
                  <label class="control-label" for="document">Documento</label>
                  <input id="document" name="document" type="text" class="form-control">
                </div>
                <div class="form-group">
                  <label class="control-label" for="walletId">ID da Carteira</label>
                  <input id="walletId" name="walletId" type="text" class="form-control">
                </div>
                <div class="form-group">
                      <label class="control-label" for="typeCommission">Tipo de Comissão</label>
                      <select id="typeCommission" name="typeCommission" class="form-control">
                        <option value="percentualValue">Porcentagem</option>
                        <option value="fixedValue">Valor Fixo</option>
                      </select>
                    </div>
                <div class="form-group">
                  <label class="control-label" for="commission">Comissão</label>
                  <input id="commission" name="commission" type="number" step="0.01" class="form-control">
                </div>
                <div class="form-group">
                  <button type="button" class="btn btn-primary pull-right" id="save">Salvar</button>
                  <a href=" <?= admin_url('multi100/partners') ?>" class="btn btn-default pull-left">Voltar</a>
                </div>
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
    const name = $('#name').val();
    const phone = $('#phone').val();
    const email = $('#email').val();
    const document = $('#document').val();
    const walletId = $('#walletId').val();
    const typeCommission = $('#typeCommission').val();
    const commission = $('#commission').val();

    if (!name || !phone || !email || !document || !walletId || !typeCommission || !commission) {
      alert_float('danger', 'Preencha todos os campos');
      $('#save').attr('disabled', false);
      return;
    }

    const data = {
      name,
      phone,
      email,
      document,
      walletId,
      typeCommission,
      commission
    };

    $.ajax({
      type: 'POST',
      url: '<?= admin_url('multi100/partners/create') ?>',
      data: data,
      success: function(response) {
        if (response.success) {
          alert_float('success', response.message);
          $('#save').attr('disabled', false);

          setTimeout(() => {
            window.location.href = '<?= admin_url('multi100/partners') ?>';
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