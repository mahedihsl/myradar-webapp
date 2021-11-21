<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Complain;

/**
 * Class ComplainExportTransformer.
 *
 * @package namespace App\Transformers;
 */
class ComplainExportTransformer extends TransformerAbstract
{
    /**
     * Transform the Complain entity.
     *
     * @param \App\Entities\Complain $model
     *
     * @return array
     */
    public function transform(Complain $model)
    {
        $teams = ['N/A', 'CCD', 'Eng - Ops'];
        $getComment = function($list, $i) {
            if (gettype($list) == 'string') {
                return $i == 0 ? $list : '--';
            }
            if (gettype($list) == 'array') {
                if ($i >= count($list)) {
                    return '--';
                }
                return $list[$i]['body'];
            }
            return '--';
        };

        $complainer = 'N/A';
        if ($model->car && $model->car->user) {
            $complainer = $model->car->user->name;
        }

        return [
            'Status' => $model->status,
			'Token'  => $model->token,
			'Car'    => $model->reg_no,
			'Complainer' => $complainer,
            'Creator' => $model->emp,
            'Responsible' => $teams[$model->responsible],
            'When' => $model->when->diffForHumans(),
            'Closed Within' => $model->getDurationBeforeClosing(),
            'Type' => $model->type,
            'Description' => $model->body,
            'Comment #1' => $getComment($model->comment, 0),
            'Comment #2' => $getComment($model->comment, 1),
            'Comment #3' => $getComment($model->comment, 2),
        ];
    }
}
