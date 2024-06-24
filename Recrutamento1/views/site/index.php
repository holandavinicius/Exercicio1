<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\GridViewAsset;

use function PHPUnit\Framework\isNull;

$this->title = 'Lista de Tarefas';
$this->params['breadcrumbs'][] = $this->title;
GridViewAsset::register($this);
?>

<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'TituloTarefa',
            'Descricao',
            'DataCriacao',
            'DataConclusao',
            [
                'attribute' => 'Estado',
                'format' => 'raw',
                'value' => function ($model) {
                    if (is_null($model->Estado)) {
                        return '';
                    } else {
                        $estadoClass = '';
                        switch ($model->Estado) {
                            case 'Em Curso':
                                $estadoClass = 'badge badge-pill badge-success';
                                break;
                            case 'Finalizado':
                                $estadoClass = 'badge badge-pill badge-dark';
                                break;
                            case 'Pendente':
                                $estadoClass = 'badge badge-pill badge-warning';
                                break;
                            default:
                                $estadoClass = 'badge badge-pill badge-secondary';
                                break;
                        }
                    }
                    return '<span class="' . $estadoClass . '">' . Html::encode($model->Estado) . '</span>';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span>Editar</span>', '#bt-editar', [
                            'title' => 'Editar',
                            'data-bs-toggle' => 'modal',
                            'data-bs-target' => '#modal',
                            'data-id' => $model->Id,
                            'class' => 'btn btn-primary btn-xs',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span>Eliminar</span>', '#bt-eliminar', [
                            'title' => 'Eliminar',
                            'data-toggle' => '',
                            'data-target' => '',
                            'data-id' => $model->Id,
                            'class' => 'btn btn-danger btn-xs',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

    <div class="text-right">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-adicionar">
            Adicionar Tarefa
        </button>
        <!-- O modal editar -->
        <div class="modal fade" id="modal-adicionar" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Adicionar Tarefa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-adicionar">
                            <div class="mb-3">
                                <label for="tituloTarefa" class="form-label">Título da Tarefa</label>
                                <input type="text" class="form-control" id="tituloTarefa" name="tituloTarefa" required>
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <input type="text" class="form-control" id="descricao" name="descricao">
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="dataCriacao" class="form-label">Data Criação</label>
                                    <input type="date" class="form-control" id="dataCriacao" name="dataCriacao">
                                </div>
                                <div class="col">
                                    <label for="dataConclusao" class="form-label">Data Conclusão</label>
                                    <input type="date" class="form-control" id="dataConclusao" name="dataConclusao">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado">
                                    <option value="Em Curso">Em Curso</option>
                                    <option value="Finalizado">Finalizado</option>
                                    <option value="Pendente">Pendente</option>
                                </select>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Adicionar Tarefa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).on('submit', '#form-adicionar', function(e) {
                e.preventDefault();

                var formData = {
                    tituloTarefa: $('#tituloTarefa').val(),
                    descricao: $('#descricao').val(),
                    dataCriacao: $('#dataCriacao').val(),
                    dataConclusao: $('#dataConclusao').val(),
                    estado: $('#estado').val()
                };

                $.ajax({
                    type: 'POST',
                    url: 'site/adicionar-tarefa', 
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        console.log('Tarefa adicionada com sucesso:', response);

                        $('#form-adicionar')[0].reset();


                        $.pjax.reload({
                            container: '#grid-view'
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao adicionar tarefa:', error);
                    }
                });
            });
        </script>

    </div>

</div>
</div>