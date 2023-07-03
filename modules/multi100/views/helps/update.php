<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-offset-2 col-md-8">
            <h4>Editar Ajuda</h4>
            <div class="panel_s">
              <div class="panel-body">
                <!-- csrf -->
                <input type="hidden" name="csrf_token" value="<?= $this->security->get_csrf_hash(); ?>" />
                <div class="form-group">
                  <label class="control-label" for="title">Titulo</label>
                  <input id="title" name="title" type="text" class="form-control" value="<?= $get_help->title ?>">
                </div>
                <div class="form-group">
                  <label class="control-label" for="video">Video</label>
                  <input id="video" name="video" type="text" class="form-control" value="<?= $get_help->video ?>">
                </div>
                <div class="form-group">
                  <label class="control-label" for="link">Link</label>
                  <input id="link" name="link" type="text" class="form-control" value="<?= $get_help->link ?>">
                </div>
                <div class="form-group">
                  <label class="control-label" for="description">Descrição</label>
                  <textarea id="description" name="description" class="form-control"><?= $get_help->description ?></textarea>
                </div>
                <div class="form-group">
                  <button type="button" class="btn btn-primary pull-right" id="save">Salvar</button>
                  <a href=" <?= admin_url('multi100/helps') ?>" class="btn btn-default pull-left">Voltar</a>
                </div>
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
    const title = $('#title').val();
    const video = $('#video').val();
    const link = $('#link').val();
    const description = $('#description').val();

    if (!title || !video || !link || !description) {
      alert_float('danger', 'Preencha todos os campos');
      $('#save').attr('disabled', false);
      return;
    }

    const data = {
      title,
      video,
      link,
      description
    };

    $.ajax({
      type: 'POST',
      url: '<?= admin_url('multi100/helps/update/' . $get_help->id) ?>',
      data: data,
      success: function(response) {
        if (response.success) {
          alert_float('success', response.message);
          $('#save').attr('disabled', false);

          setTimeout(() => {
            window.location.href = '<?= admin_url('multi100/helps') ?>';
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