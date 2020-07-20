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
            if ($i >= count($list)) {
                return '--';
            }
            return $list[$i]['body'];
        };

        return [
            'Status' => $model->status,
			'Token'  => $model->token,
			'Car'    => $model->reg_no,
			'Complainer' => $model->car->user->name,
            'Creator' => $model->emp,
            'Responsible' => $teams[$model->responsible],
            'When' => $model->when->diffForHumans(),
            'Comment #1' => $getComment($model->comments, 0),
            'Comment #2' => $getComment($model->comments, 1),
            'Comment #3' => $getComment($model->comments, 2),
        ];
    }
}
