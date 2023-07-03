<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-offset-4 col-md-4">
        <h4>Atualizar dados</h4>
        <div class="panel_s tw-mt-2 sm:tw-mt-4">
          <div class="panel-body"> <?= form_open(admin_url('multi100/update/' . $get_submission->id), ['id' => 'myform']); ?>
            <div class="form-group">
              <label class="control-label" for="plan_id">Plano</label>
              <select id="plan_id" name="plan_id" class="form-control">
                <?php foreach ($get_plans->plans as $get_plan) :  ?>
                  <option value="<?= $get_plan->id ?>" <?= ($get_submission->plan_id->value == $get_plan->id) ? "selected" : null ?>>
                    <?= $get_plan->name ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label" for="payment_method">Meio de pagamento</label>
              <select id="payment_method" name="payment_method" class="form-control">
                <option value="BOLETO" <?= ($get_submission->payment_method->value == "BOLETO") ? "selected" : null ?>>
                  Boleto Bancário
                </option>
                <option value="CREDIT_CARD" <?= ($get_submission->payment_method->value == "CREDIT_CARD") ? "selected" : null ?>>
                  Cartão de Crédito
                </option>
                <option value="PIX" <?= ($get_submission->payment_method->value == "PIX") ? "selected" : null ?>>
                  Pix
                </option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label" for="name">Vencimento</label>
              <input id="name" name="name" type="date" class="form-control" value="<?= $get_submission->due_date->value ?>">
            </div>
            <div class="form-group">
              <label class="control-label" for="name">Nome</label>
              <input id="name" name="name" type="text" class="form-control" value="<?= $get_submission->name->value ?>">
            </div>
            <div class="form-group">
              <label class="control-label" for="phone">Telefone</label>
              <input id="phone" name="phone" type="text" class="form-control" value="<?= $get_submission->phone->value ?>">
            </div>
            <div class="form-group">
              <label class="control-label" for="email">Email</label>
              <input id="email" name="email" type="text" class="form-control" value="<?= $get_submission->email->value ?>">
            </div>
            <div class="form-group">
              <label class="control-label" for="document">Documento</label>
              <input id="document" name="document" type="text" class="form-control" value="<?= $get_submission->document->value ?>">
            </div>
            <div class="form-group">
              <label class="control-label" for="zip_code">Cep</label>
              <input id="zip_code" name="zip_code" type="text" class="form-control" value="<?= $get_submission->zip_code->value ?>">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary pull-right">Salvar</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>