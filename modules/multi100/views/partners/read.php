<?php init_head();

?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-offset-3 col-md-6">
        <h4>Detalhes do Parceiro</h4>
        <div class="panel_s tw-mt-2 sm:tw-mt-4">
          <div class="panel-body">
            <table class="table table-striped">
              <tr>
                <th>Nome</th>
                <td><?= $get_partner->name ?></td>
              <tr>
              <tr>
                <th>Tipo de Comissão</th>
                <td><?= $get_partner->typeCommission ?></td>
              </tr>
              <tr>
                <th>Comissão</th>
                <td><?= number_format($get_partner->commission, 2, ',', '.') ?></td>
              </tr>
              <tr>
                <th>ID da Carteira</th>
                <td><?= $get_partner->walletId ?></td>
              </tr>
                <th>Telefone</th>
                <td><?= $get_partner->phone ?></td>
              </tr>
              <tr>
                <th>Documento</th>
                <td><?= $get_partner->document ?></td>
              </tr>
              <tr>
                <th>Data cadastro</th>
                <td><?= _dt($get_partner->createdAt) ?></td>
              </tr>
              <tr>
                <th>Data alteração</th>
                <td><?= _dt($get_partner->updatedAt) ?></td>
              </tr>
            </table>
            <a href=" <?= admin_url('multi100/partners') ?>" class="btn btn-primary pull-right">Voltar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>