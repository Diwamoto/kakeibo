<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccountLog $accountLog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Account Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="accountLogs form content">
            <?= $this->Form->create($accountLog) ?>
            <fieldset>
                <legend><?= __('Add Account Log') ?></legend>
                <?php
                    echo $this->Form->control('account_id');
                    echo $this->Form->control('name');
                    echo $this->Form->control('amount');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
