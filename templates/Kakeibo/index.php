<?php
$termStrings = [];
foreach($terms as $term){
    $termStrings[] = $term['year'] . '年'. $term['month'] . '月';
}
?>
<div class="container">
<div class="row">
    <div class="col s12 l4 offset-l4">
        <h3 class="center-align">収支一覧</h3>
    </div>
</div>
<?=$this->Form->create(null,['id' => 'account_form']);?>
<div class="row">
<div class="input-field col s12 m4 offset-m4">
<?=$this->Form->select(
    'terms',
    $termStrings,
    ['id' => 'terms', 'class' => 'browser-default']
);?> 
<?=$this->Form->select(
    'account_name',
    $names,
    ['id' => 'account_name', 'class' => 'browser-default']
);?> 
    </div>
</div>
<?php if(!empty($token)):?>
<?=$this->Form->hidden('token', ['value' => $token]);?>
<?php endif;?>
<?=$this->Form->end();?>
<?php if($data):?>
<?php if($amount > 0):?>
    <h4 class="center-align green-text">今月の収益: +<?=$amount?></h4>
<?php else:?>
    <h4 class="center-align red-text">今月の収益: -<?=str_replace('-', '', $amount)?></h4>
<?php endif;?>
<div class="row">
    <h5 class="col s3">取引日</h5>
    <h5 class="col s3">金額</h5>
    <h5 class="col s3">場所</h5>
    <h5 class="col s3">種類</h5>
</div>
<?php foreach($data as $obj):?>
<?php 
    if(!is_null($obj->withdraw_id)) {
        $type = 'withdraw';
        $class = 'red';
        $modifer = '-';
        $summary = $wdConfig[$obj->withdraw_id];
    }else{
        $type = 'deposit';
        $class = 'green';
        $modifer = '+';
        $summary = $dpConfig[$obj->deposit_id];
    }
    ?>
<div class="divider"></div>
<div class="row">
    <div class="col s3 flow-text"><?= $obj->created?></div>
    <div class="col s3 flow-text"><span class="<?=$class?>-text"><?= $modifer . $obj->amount?></span></div>
    <div class="col s3 flow-text"><?= $obj->place?></div>
    <div class="col s3 flow-text"><?= $summary?></div>
</div>
<?php endforeach;?>
<?php else:?>
<h5 class="center-align">まだ取引記録はありません。</h5>
<?php endif;?>
</div>