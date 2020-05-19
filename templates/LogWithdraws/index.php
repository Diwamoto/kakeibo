<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LogWithdraw[]|\Cake\Collection\CollectionInterface $logWithdraws
 */
?>
<div class="logWithdraws index content">
    <?= $this->Html->link(__('New Log Withdraw'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Log Withdraws') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th>出金理由</th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th>支払方法</th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logWithdraws as $logWithdraw): ?>
                <tr>
                    <td><?= $this->Number->format($logWithdraw->id) ?></td>
                    <td><?= $logWithdraw->has('user') ? $this->Html->link($logWithdraw->user->id, ['controller' => 'Users', 'action' => 'view', $logWithdraw->user->id]) : '' ?></td>
                    <td><?= $withdrawConfig[$logWithdraw->withdraw_id] ?></td>
                    <td><?= $logWithdraw->has('account') ? $this->Html->link($logWithdraw->account->name, ['controller' => 'Accounts', 'action' => 'view', $logWithdraw->account->id]) : '' ?></td>
                    <td><?= $this->Number->format($logWithdraw->amount) ?></td>
                    <td><?= $paymentMethods[$logWithdraw->payment_method_id]?></td>
                    <td><?= h($logWithdraw->created) ?></td>
                    <td><?= h($logWithdraw->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $logWithdraw->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $logWithdraw->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $logWithdraw->id], ['confirm' => __('Are you sure you want to delete # {0}?', $logWithdraw->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
