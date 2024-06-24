<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Tarefa extends ActiveRecord
{
    public static function tableName()
    {
        return 'tarefas'; // Nome real da sua tabela no banco de dados
    }

    public function rules()
    {
        return [
            [['Id'], 'required'],
            [['TituloTarefa',], 'string', 'max' => 255],
            [['DataCriacao'], 'date', 'format' => 'php:Y-m-d'],
            [['DataConclusao'], 'date', 'format' => 'php:Y-m-d'],
            [['Estado'], 'boolean'],
            [['Descricao'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'TituloTarefa' => 'Título da Tarefa',
            'DataCriacao' => 'Data de Criação',
            'DataConclusao' => 'Data de Conclusão',
            'Estado' => 'Estado',
            'Descricao' => 'Descrição',
        ];
    }
}
