<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 15:51
 */
namespace App\Services;

use App\Helpers\QueryHelper;
use App\Models\ChannelColumn;
use App\Models\ColumnGoodsRel;
use App\Models\Goods;

/**
 * 商品栏目
 * Class ChannelColumnService
 * @package App\Services
 */
class ChannelColumnService
{
    /**
     * 通过栏目代码查询栏目
     * @param $columnCode
     * @return mixed
     */
    public function getByCode($columnCode){
        return ChannelColumn::where('code', $columnCode)->first();
    }
}