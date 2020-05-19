<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LogDeposit $logDeposit
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Log Deposits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="logDeposits form content">
            <?= $this->Form->create($logDeposit) ?>
            <fieldset>
                <legend><?= __('Add Log Deposit') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('amount');
                    echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => true]);
                    echo $this->Form->control('deposit_id', ['options' => $mstDeposits, 'empty' => true]);
                    echo $this->Form->control('fix_flg');
                    echo $this->Form->control('comment');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
