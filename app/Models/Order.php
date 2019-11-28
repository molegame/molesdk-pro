<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * 订单状态
     */
    const STATE_PAYING      = 0;    // 支付中
    const STATE_PAID        = 1;    // 已支付
    const STATE_COMPLETE    = 2;    // 完成
    const STATE_FAILED      = 3;    // 失败
    /**
     * 支付类型
     */
    const PAYTYPE_APPLEPAY  = 1;    // 苹果支付
    const PAYTYPE_UNIONPAY  = 2;    // 银联支付
    const PAYTYPE_ALIPAY    = 3;    // 阿里支付
    const PAYTYPE_WECHATPAY = 4;    // 微信支付

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'game_id',
        'channel_id',
        'player_id',
        'currency',
        'amount',
        'state',
        'product_id',
        'product_name',
        'transaction_id',
        'cp_order_id',
        'callback_url',
        'callback_info',
    ];
}
