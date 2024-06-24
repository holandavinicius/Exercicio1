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
                            'data-bs-target' => '#reg-modal',
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
    <!-- O modal editar -->
    <div class="modal fade" id="reg-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Editar Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="tituloTarefa" class="form-label">Título da Tarefa</label>
                    <input type="text" class="form-control" id="tituloTarefa" name="tituloTarefa">
                    <label for="tituloTarefa" class="form-label">Descricao</label>
                    <input type="text" class="form-control" id="descricao" name="descricao">
                    <label for="tituloTarefa" class="form-label">Data Criação</label>
                    <input type="text" class="form-control" id="dataCriacao" name="dataCriacao">
                    <label for="tituloTarefa" class="form-label">Data Conclusão</label>
                    <input type="text" class="form-control" id="dataConclusao" name="dataConclusao">
                    <label for="tituloTarefa" class="form-label">Estado</label>
                    <input type="text" class="form-control" id="estado" name="estado">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '#bt-editar', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            console.log('ID da tarefa:', id);
            var url = '/site/modalEditar?id=' + id;

            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    $('#tituloTarefa').val(data.TituloTarefa);
                    $('#descricao').val(data.Descricao);
                    $('#dataCriacao').val(data.DataCriacao);
                    $('#dataConclusao').val(data.DataConclusao);
                    $('#estado').val(data.Estado);
                    $('#reg-modal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    </script>

</div>
<div class="text-right">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-add">
        Adicionar Tarefa
    </button>
</div>
</div>