<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12"> <?= form_open(admin_url('multi100/config')); ?>
        <div class="row">
          <div class="col-md-6">
            <h4 class="no-margin"> Configurações Multi100 API </h4>
            <hr class="hr-panel-heading" />
            <div class="panel_s">
              <div class="panel-body">
                <div class="form-group">
                  <label control-label for="multi100_api_token">Api Token</label>
                  <input id="multi100_api_token" name="multi100_api_token" type="text" value="<?= $multi100_api_token ?>" class="form-control">
                </div>
                <div class="form-group">
                  <label control-label for="multi100_api_url"> Api Url</label>
                  <input id="multi100_api_url" name="multi100_api_url" type="text" value="<?= $multi100_api_url ?>" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <h4 class="no-margin"> Configurações integração Formulários</h4>
            <hr class="hr-panel-heading" />
            <div class="panel_s">
              <div class="panel-body">
                <div class="form-group">
                  <label control-label for="elementor_api_assigned"> O lead deverá ser atribuido ao colaborador</label>
                  <select id="elementor_api_assigned" name="elementor_api_assigned" class="form-control">
                    <?php foreach ($staffs as $staff) : ?>
                      <option value="<?= $staff["staffid"] ?>" <?= ($staff["staffid"] == $elementor_api_source) ? "selected" : null ?>>
                        <?= $staff["firstname"] ?> <?= $staff["lastname"] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label control-label for="elementor_api_source"> Fonte do lead recebido</label>
                  <select id="elementor_api_source" name="elementor_api_source" class="form-control">
                    <?php foreach ($sources as $source) : ?>
                      <option value="<?= $source["id"] ?>" <?= ($source["id"] == $elementor_api_source) ? 'selected' : null ?>>
                        <?= $source["name"] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <h4 class="no-margin"> Configurações Asaas</h4>
            <hr class="hr-panel-heading" />
            <div class="panel_s">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label control-label for="asaas_sandbox"> Sandbox</label>
                      <select id="asaas_sandbox" name="asaas_sandbox" class="form-control">
                        <option value="1" <?= ($asaas_sandbox == 1) ? "selected" : null ?>>
                          Sim
                        </option>
                        <option value="0" <?= ($asaas_sandbox == 0) ? "selected" : null ?>>
                          Não
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label control-label for="asaas_api_key"> Api Key</label>
                  <input id="asaas_api_key" name="asaas_api_key" type="text" value="<?= $asaas_api_key ?>" class="form-control">
                </div>
                <div class="form-group">
                  <label control-label for="asaas_api_key_sandbox"> Api Key Sandbox</label>
                  <input id="asaas_api_key_sandbox" name="asaas_api_key_sandbox" type="text" value="<?= $asaas_api_key_sandbox ?>" class="form-control">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel_s">
          <div class="panel-body">
            <div class="form-group">
              <button type="submit" class="btn btn-primary pull-right">Salvar</button>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>
</body>

</html>