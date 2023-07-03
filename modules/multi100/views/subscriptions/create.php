<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12"> <?= form_open(admin_url('multi100/subscriptions/create')); ?>
        <div class="row">
          <div class="col-md-offset-3 col-md-6">
            <h4>Adicionar nova Assinatura</h4>
            <div class="panel_s">
              <div class="panel-body">
                <div class="form-group">
                  <label class="control-label" for="description">Descrição</label>
                  <input id="description" name="description" type="text" class="form-control">
                  <!--   <span class="help-block">help</span>  -->

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
                      <!--   <span class="help-block">help</span>  -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label" for="planId">Plano</label>
                      <select id="planId" name="planId" class="form-control">
                        <?php foreach ($get_plans->plans as $get_plan) :  ?>
                          <option value="<?= $get_plan->id ?>"><?= $get_plan->name ?></option>
                        <?php endforeach; ?>
                      </select>
                      <!--   <span class="help-block">help</span>  -->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
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
                      <!--   <span class="help-block">help</span>  -->
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label" for="billingType">Meio de pagamento</label>
                      <select id="billingType" name="billingType" class="form-control">
                        <option value="BOLETO">Boleto Bancário</option>
                        <option value="CREDIT_CARD">Cartão de Crédito</option>
                        <option value="PIX">Pix</option>
                      </select>
                      <!--   <span class="help-block">help</span>  -->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label" for="nextDueDate">Proximo vencimento</label>
                      <input id="nextDueDate" name="nextDueDate" type="date" class="form-control">
                      <!--   <span class="help-block">help</span>  -->
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label" for="endDate">Data final</label>
                      <input id="endDate" name="endDate" type="date" class="form-control">
                      <!--   <span class="help-block">help</span>  -->
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label" for="maxPayments">Maximo de pagamentos</label>
                      <input id="maxPayments" name="maxPayments" type="number" class="form-control">
                      <!--   <span class="help-block">help</span>  -->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label" for="fine_value">Valor multa por atraso</label>
                      <input id="fine_value" name="fine_value" type="text" class="form-control">
                      <!--   <span class="help-block">help</span>  -->
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label" for="interest_value">Valor juros por atraso</label>
                      <input id="interest_value" name="interest_value" type="text" class="form-control">
                      <!--   <span class="help-block">help</span>  -->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label" for="split">Split</label>
                      <select id="split" name="split" class="form-control">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                      </select>
                      <!--   <span class="help-block">help</span>  -->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label" for="split_type">Tipo de Split</label>
                      <select id="split_type" name="split_type" class="form-control">
                        <option value="fixed">Valor fixo </option>
                        <option value="percentual">Percentual</option>
                      </select>
                      <!--   <span class="help-block">help</span>  -->
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label" for="split_value">Valor do Split</label>
                      <input id="split_value" name="split_value" type="number" class="form-control">
                      <!--   <span class="help-block">help</span>  -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label" for="split_wallet">Carteira Asaas</label>
                      <input id="split_wallet" name="split_wallet" type="text" class="form-control" value="<?= $walletId ?>">
                      <!--   <span class="help-block">help</span>  -->
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
</div>
</div>
</form>
</div>
<?php init_tail(); ?>