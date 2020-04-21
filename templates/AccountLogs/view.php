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
            <?= $this->Html->link(__('Edit Account Log'), ['action' => 'edit', $accountLog->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Account Log'), ['action' => 'delete', $accountLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountLog->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Account Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Account Log'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="accountLogs view content">
            <h3><?= h($accountLog->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($accountLog->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Account Id') ?></th>
                    <td><?= $this->Number->format($accountLog->account_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($accountLog->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($accountLog->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($accountLog->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Name') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($accountLog->name)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
