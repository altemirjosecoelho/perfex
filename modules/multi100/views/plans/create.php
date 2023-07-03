<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <h4>Adicionar novo Plano</h4>
        <!-- csrf -->
        <input type="hidden" name="csrf_token" value="<?= $this->security->get_csrf_hash(); ?>" />
        <div class="row">
          <div class="col-md-12">
            <div class="panel_s">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label" for="name">Nome</label>
                      <input id="name" name="name" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label" for="amount">Valor</label>
                      <input id="amount" name="amount" type="number" step="0.01" class="form-control" value="0">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel_s">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="trial">Teste Grátis</label>
                      <select id="trial" name="trial" class="form-control">
                        <option value="true">Sim</option>
                        <option value="false" selected>Não</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="trialDays">Dias Grátis</label>
                      <input id="trialDays" name="trialDays" type="number" class="form-control" value="0">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="recurrence">Recorrência</label>
                      <select id="recurrence" name="recurrence" class="form-control">
                        <option value="SEMANAL">Semanal</option>
                        <option value="QUIZENAL">Quinzenal</option>
                        <option value="MENSAL" selected>Mensal</option>
                        <option value="TRIMESTRAL">Trimestral</option>
                        <option value="SEMESTRAL">Semestral</option>
                        <option value="ANUAL">Anual</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel_s">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="users">Usuários</label>
                      <input id="users" name="users" type="number" class="form-control" value="0">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="connections">Conexões</label>
                      <input id="connections" name="connections" type="number" class="form-control" value="0">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="queues">Departamentos</label>
                      <input id="queues" name="queues" type="number" class="form-control" value="0">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="panel_s">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="useWhatsapp">Whatsapp</label>
                      <select id="useWhatsapp" name="useWhatsapp" class="form-control">
                        <option value="true">Sim</option>
                        <option value="false">Não</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="useFacebook">Facebook</label>
                      <select id="useFacebook" name="useFacebook" class="form-control">
                        <option value="true">Sim</option>
                        <option value="false">Não</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="useInstagram">Instagram</label>
                      <select id="useInstagram" name="useInstagram" class="form-control">
                        <option value="true">Sim</option>
                        <option value="false">Não</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="useCampaigns">Campanhas</label>
                      <select id="useCampaigns" name="useCampaigns" class="form-control">
                        <option value="true">Sim</option>
                        <option value="false">Não</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="useSchedules">Agendamentos</label>
                      <select id="useSchedules" name="useSchedules" class="form-control">
                        <option value="true">Sim</option>
                        <option value="false">Não</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="useInternalChat">Chat Interno</label>
                      <select id="useInternalChat" name="useInternalChat" class="form-control">
                        <option value="true">Sim</option>
                        <option value="false">Não</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="useExternalApi">API Externa</label>
                      <select id="useExternalApi" name="useExternalApi" class="form-control">
                        <option value="true">Sim</option>
                        <option value="false">Não</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel_s">
          <div class="panel-body">
            <div class="form-group">
              <button type="button" class="btn btn-primary pull-right" id="save">Salvar</button>
              <a href=" <?= admin_url('multi100/plans') ?>" class="btn btn-default pull-left">Voltar</a>
            </div>
          </div>
        </div>
      </div>
      </form>
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
    const amount = $('#amount').val();
    const users = $('#users').val();
    const connections = $('#connections').val();
    const queues = $('#queues').val();
    const useWhatsapp = $('#useWhatsapp').val();
    const useFacebook = $('#useFacebook').val();
    const useInstagram = $('#useInstagram').val();
    const useCampaigns = $('#useCampaigns').val();
    const useSchedules = $('#useSchedules').val();
    const useInternalChat = $('#useInternalChat').val();
    const useExternalApi = $('#useExternalApi').val();
    const trial = $('#trial').val();
    const trialDays = $('#trialDays').val();
    const recurrence = $('#recurrence').val();

    if (
      !name ||
      !amount ||
      !users ||
      !connections ||
      !queues ||
      !useWhatsapp ||
      !useFacebook ||
      !useInstagram ||
      !useCampaigns ||
      !useSchedules ||
      !useInternalChat ||
      !useExternalApi ||
      !trial ||
      !trialDays ||
      !recurrence) {
      alert_float('danger', 'Preencha todos os campos');
      $('#save').attr('disabled', false);
      return;
    }

    const data = {
      name,
      amount,
      users,
      connections,
      queues,
      useWhatsapp,
      useFacebook,
      useInstagram,
      useCampaigns,
      useSchedules,
      useInternalChat,
      useExternalApi,
      trial,
      trialDays,
      recurrence,
    };

    $.ajax({
      type: 'POST',
      url: '<?= admin_url('multi100/plans/create') ?>',
      data: data,
      success: function(response) {
        if (response.success) {
          alert_float('success', response.message);
          $('#save').attr('disabled', false);

          setTimeout(() => {
            window.location.href = '<?= admin_url('multi100/plans') ?>';
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