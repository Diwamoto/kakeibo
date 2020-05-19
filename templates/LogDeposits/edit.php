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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $logDeposit->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $logDeposit->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Log Deposits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="logDeposits form content">
            <?= $this->Form->create($logDeposit) ?>
            <fieldset>
                <legend><?= __('Edit Log Deposit') ?></legend>
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
