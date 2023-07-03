<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <h4 class="no-margin"> Configurar campos</h4>
            <hr class="hr-panel-heading" />
            <div class="panel_s">
              <div class="panel-body"> <?= form_open(admin_url('multi100/fields')); ?>
                <div class="row">
                  <div class="col-md-6">
                    <p>Campos do modulo</p>
                  </div>
                  <div class="col-md-6">
                    <p>Campos personalizados</p>
                  </div>
                </div>
                <hr>
                <?php foreach ($module_fields as $module_field) : ?>
                  <div class="row">
                    <div class="col-md-6">
                      <p><?= $module_field ?></p>
                      <input type="hidden" value="<?= $module_field ?>">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Selecione o campo personalizado</label>
                        <select class="form-control selectpicker" id="customfield" name="customfield[<?= $customfield->name ?>]">
                          <?php foreach ($customfields as $customfield) : ?>
                            <option value="<?= $customfield->id ?>"><?= $customfield->name ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
                <div class="form-group">
                  <button class="btn btn-primary pull-right" type="submit">Salvar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php init_tail(); ?>