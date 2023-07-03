<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12"> <?= form_open(admin_url('multi100/subscriptions/update/' . $get_subscription->id)); ?>
        <div class="row">
          <div class="col-md-offset-3 col-md-6">
            <h4>Editar Assinatura</h4>
            <div class="panel_s">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-3 pull-right">
                        <div class="form-group">
                          <label class="control-label" for="updatePendingPayments">Atualizar pagamentos</label>
                          <select id="updatePendingPayments" name="updatePendingPayments" class="form-control">
                            <option value="true">Sim</option>
                            <option value="false">Não</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3 pull-right">
                        <div class="form-group">
                          <label class="control-label" for="status">Status</label>
                          <select id="status" name="status" class="form-control">
                            <option value="ACTIVE">Ativo</option>
                            <option value="EXPIRED">Expirado</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label" for="description">Descrição</label>
                      <input id="description" name="description" type="text" class="form-control" value="<?= $get_subscription->description ?>">
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label" for="customer">Cliente</label>
                          <select id="customer" name="customer" class="form-control">
                            <?php foreach ($get_customers->data as $get_customer) :  ?>
                              <option value="<?= $get_customer->id ?>"><?= $get_customer->name ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label" for="planId">Plano</label>
                          <select id="planId" name="planId" class="form-control">
                            <?php foreach ($get_plans->plans as $get_plan) :  ?>
                              <option value="<?= $get_plan->id ?>"><?= $get_plan->name ?></option>
                            <?php endforeach;  ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label" for="cycle">Periodo</label>
                          <select id="cycle" name="cycle" class="form-control">
                            <option value="WEEKLY">Semanal</option>
                            <option value="BIWEEKLY">Quinzenal (2 semanas)</option>
                            <option value="MONTHLY">Mensal</option>
                            <option value="QUARTERLY">Trimestral</option>
                            <option value="SEMIANNUALLY">Semestral</option>
                            <option value="YEARLY">Anual</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label" for="billingType">Meio de pagamento</label>
                          <select id="billingType" name="billingType" class="form-control">
                            <option value="BOLETO">Boleto Bancário</option>
                            <option value="CREDIT_CARD">Cartão de Crédito</option>
                            <option value="PIX">Pix</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="nextDueDate">Proximo vencimento</label>
                          <input id="nextDueDate" name="nextDueDate" type="date" class="form-control" value="<?= $get_subscription->nextDueDate ?>">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="endDate">Data final</label>
                          <input id="endDate" name="endDate" type="date" class="form-control" value="<?= $get_subscription->endDate ?>">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="maxPayments">Maximo de pagamentos</label>
                          <input id="maxPayments" name="maxPayments" type="number" class="form-control" value="<?= $get_subscription->maxPayments ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="fine_value">Valor multa por atraso</label>
                          <input id="fine_value" name="fine_value" type="text" class="form-control" value="<?= $get_subscription->fine->value ?>">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="interest_value">Valor juros por atraso</label>
                          <input id="interest_value" name="interest_value" type="text" class="form-control" value="<?= $get_subscription->interest->value ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="split">Split</label>
                          <select id="split" name="split" class="form-control">
                            <option value="1" <?= ($split == '1') ? "selected" : null ?>>
                              Sim
                            </option>
                            <option value="0" <?= ($split == '0') ? "selected" : null ?>>
                              Não
                            </option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="split_type">Tipo de Split</label>
                          <select id="split_type" name="split_type" class="form-control">
                            <option value="fixed" <?= ($split_type == 'fixed') ? "selected" : null ?>>
                              Valor fixo
                            </option>
                            <option value="percentual" <?= ($split_type == 'percentual') ? "selected" : null ?>>
                              Percentual
                            </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" for="split_value">Valor do Split</label>
                          <input id="split_value" name="split_value" type="number" class="form-control" value="<?= $split_value ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label" for="split_wallet">Carteira Asaas</label>
                          <input id="split_wallet" name="split_wallet" type="number" class="form-control" value="<?= $split_wallet ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </form>
</div>
<?php init_tail(); ?>