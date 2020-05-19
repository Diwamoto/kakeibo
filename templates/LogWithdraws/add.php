<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LogWithdraw $logWithdraw
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Log Withdraws'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="logWithdraws form content">
            <?= $this->Form->create($logWithdraw) ?>
            <fieldset>
                <legend><?= __('Add Log Withdraw') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('place');
                    echo $this->Form->control('withdraw_id', ['options' => $mstWithdraws, 'empty' => true]);
                    echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => true]);
                    echo $this->Form->control('amount');
                    echo $this->Form->control('payment_method_id', ['options' => $mstPaymentMethods]);
                    echo $this->Form->control('fix_flg');
                    echo $this->Form->control('comment');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
