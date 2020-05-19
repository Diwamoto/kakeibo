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
            <?= $this->Html->link(__('Edit Log Withdraw'), ['action' => 'edit', $logWithdraw->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Log Withdraw'), ['action' => 'delete', $logWithdraw->id], ['confirm' => __('Are you sure you want to delete # {0}?', $logWithdraw->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Log Withdraws'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Log Withdraw'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="logWithdraws view content">
            <h3><?= h($logWithdraw->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $logWithdraw->has('user') ? $this->Html->link($logWithdraw->user->id, ['controller' => 'Users', 'action' => 'view', $logWithdraw->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Mst Withdraw') ?></th>
                    <td><?= $logWithdraw->has('mst_withdraw') ? $this->Html->link($logWithdraw->mst_withdraw->value, ['controller' => 'MstWithdraws', 'action' => 'view', $logWithdraw->mst_withdraw->key]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $logWithdraw->has('account') ? $this->Html->link($logWithdraw->account->name, ['controller' => 'Accounts', 'action' => 'view', $logWithdraw->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Mst Payment Method') ?></th>
                    <td><?= $logWithdraw->has('mst_payment_method') ? $this->Html->link($logWithdraw->mst_payment_method->value, ['controller' => 'MstPaymentMethods', 'action' => 'view', $logWithdraw->mst_payment_method->key]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($logWithdraw->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($logWithdraw->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fix Flg') ?></th>
                    <td><?= $this->Number->format($logWithdraw->fix_flg) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($logWithdraw->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($logWithdraw->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Place') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($logWithdraw->place)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Comment') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($logWithdraw->comment)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
