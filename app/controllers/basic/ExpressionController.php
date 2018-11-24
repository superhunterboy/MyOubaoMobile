<?php

class ExpressionController extends AdminBaseController {

    /**
     * 资源视图目录
     * @var string
     */
    // protected $resourceView = 'admin.admin';
    protected $customViewPath = 'expression';
    protected $customViews = ['create', 'edit', 'view'];

    /**
     * 资源模型名称，初始化后转为模型实例
     * @var string|Illuminate\Database\Eloquent\Model
     */
    protected $modelName = 'Expression';

    /**
     * 在渲染前执行，为视图准备变量
     */
    protected function beforeRender() {
        parent::beforeRender();
        switch ($this->action) {
            case 'create':
            case 'edit':
            case 'view':
                $this->setVars('aMode', Bank::$aMode);
                break;
        }
    }

    /**
     * 手续费编辑页
     * @param type $id 银行ID
     * @return Response
     */
    public function create($id = null) {
        $oExpression = null;
        if (!is_null($id)) {
            $oExpression = Expression::find($id);
            $aExpressions = $oExpression->getExpressionsArray();
            $this->setVars(compact('oExpression', 'id', 'aExpressions'));
        }
        if (Request::method() == 'POST') { // 处理提交的数据
            if (is_null($oExpression)) {
                $oExpression = new Expression;
            }
            $aExpressionSet = $this->params['expression_set'];
            if (isset($aExpressionSet)) {
//                return $this->goBack('error', '保存失败：SAVE ERROR #01');

                $aExpSetRules = [
                    'amount_left' => 'required|regex:/^[0-9]+(.[0-9]{1,2})?$/',
                    'amount_right' => 'regex:/^[0-9]+(.[0-9]{1,2})?$/',
                    'operator' => 'required|in:%,=',
                    'value' => 'required|regex:/^[0-9]+(.[0-9]{1,2})?$/',
                ];
                $aNewExpSet = [];
                $oExpression->fill($this->params);
                foreach ($aExpressionSet as $aExp) {
                    $validator = Validator::make($aExp, $aExpSetRules);
                    if (!$validator->passes()) {
                        return $this->goBack('error', '保存失败：SAVE ERROR #02');
                    }
                    if (array_get($aExp, 'amount_right') != '' && $aExp['amount_right'] <= $aExp['amount_left']) {
                        // 金额范围开始值必须小于结束值
                        return $this->goBack('error', '保存失败：SAVE ERROR #03');
                    }
                    if (isset($fLastAmount) && $fLastAmount > $aExp['amount_left']) {
                        // 条件金额范围开始值要大于等于上一范围的结束值
                        return $this->goBack('error', '保存失败：SAVE ERROR #04');
                    }
                    /**
                     * ['x'=>['>='=>100, '<'=>'200'], 'y'=>['='=>5]],
                     * ['x'=>['>='=>200, '<'=>'500'], 'y'=>['%'=>5]],
                     */
                    $aXSet = ['>=' => $aExp['amount_left']];
                    if (array_get($aExp, 'amount_right') != '') {
                        $aXSet['<'] = $aExp['amount_right'];
                    }
                    $aNewExpSet[] = [
                        'x' => $aXSet,
                        'y' => [$aExp['operator'] => $aExp['value']]
                    ];
                    $fLastAmount = array_get($aExp, 'amount_right', 0);
                }
                $oExpression->setExpressions($aNewExpSet);
            }
            if (!$oExpression->save()) {
                return $this->goBack('error', '保存失败：SAVE ERROR #05');
            } else {
                return $this->goBackToIndex('success', 'save success');
            }
        }
        return $this->render();
    }

    /**
     * 显示银行手续费返还公式详情
     * @param type $id 银行ID
     * @return Response
     */
    public function view($id) {
        $oExpression = Expression::find($id);
        $aExpressions = $oExpression->getExpressionsArray();
        $this->setVars(compact('oExpression', 'id', 'aExpressions'));
        return $this->render();
    }

    /**
     * 显示银行手续费返还公式详情
     * @param type $id 银行ID
     * @return Response
     */
    public function edit($id) {
        $oExpression = Expression::find($id);
        $aExpressions = $oExpression->getExpressionsArray();
        $this->setVars(compact('oExpression', 'id', 'aExpressions'));
        return $this->render();
    }
    
}
