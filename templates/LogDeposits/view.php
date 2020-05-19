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
            <?= $this->Html->link(__('Edit Log Deposit'), ['action' => 'edit', $logDeposit->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Log Deposit'), ['action' => 'delete', $logDeposit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $logDeposit->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Log Deposits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Log Deposit'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="logDeposits view content">
            <h3><?= h($logDeposit->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $logDeposit->has('user') ? $this->Html->link($logDeposit->user->id, ['controller' => 'Users', 'action' => 'view', $logDeposit->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $logDeposit->has('account') ? $this->Html->link($logDeposit->account->name, ['controller' => 'Accounts', 'action' => 'view', $logDeposit->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Mst Deposit') ?></th>
                    <td><?= $logDeposit->has('mst_deposit') ? $this->Html->link($logDeposit->mst_deposit->value, ['controller' => 'MstDeposits', 'action' => 'view', $logDeposit->mst_deposit->key]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($logDeposit->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($logDeposit->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fix Flg') ?></th>
                    <td><?= $this->Number->format($logDeposit->fix_flg) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($logDeposit->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($logDeposit->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Comment') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($logDeposit->comment)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
