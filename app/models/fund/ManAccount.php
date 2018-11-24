<?php

/**
 * Account Management
 *
 * @author white
 */
class ManAccount extends Account {

    protected static $cacheUseParentClass = true;

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'username',
        'is_tester',
        'balance',
        'frozen',
        'available',
        'withdrawable',
        'prohibit_amount',
    ];
    public static $totalColumns = [
        'balance',
        'frozen',
        'available',
//        'withdrawable',
        'prohibit_amount',
    ];
    public static $listColumnMaps = [
        'is_tester' => 'is_tester_formatted',
        'balance' => 'balance_formatted',
        'frozen' => 'frozen_formatted',
        'available' => 'available_formatted',
        'withdrawable' => 'withdrawable_formatted',
        'prohibit_amount' => 'prohibit_amount_formatted',
    ];
    public static $viewColumnMaps = [
        'balance' => 'balance_formatted',
        'frozen' => 'frozen_formatted',
        'available' => 'available_formatted',
        'withdrawable' => 'withdrawable_formatted',
        'prohibit_amount' => 'prohibit_amount_formatted',
    ];
    public static $ignoreColumnsInView = [
        'id',
        'user_id',
        'locked',
        'status',
    ];

    protected function getIsTesterFormattedAttribute() {
        return __('_basic.' . strtolower(Config::get('var.boolean')[$this->attributes['is_tester']]));
    }

}
