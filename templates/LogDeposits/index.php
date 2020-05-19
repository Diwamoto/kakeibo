<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LogDeposit[]|\Cake\Collection\CollectionInterface $logDeposits
 */
?>
<div class="logDeposits index content">
    <?= $this->Html->link(__('新規作成'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Log Deposits') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th>入金方法</th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logDeposits as $logDeposit): ?>
                <tr>
                    <td><?= $this->Number->format($logDeposit->id) ?></td>
                    <td><?= $logDeposit->has('user') ? $this->Html->link($logDeposit->user->id, ['controller' => 'Users', 'action' => 'view', $logDeposit->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($logDeposit->amount) ?></td>
                    <td><?= $logDeposit->has('account') ? $this->Html->link($logDeposit->account->name, ['controller' => 'Accounts', 'action' => 'view', $logDeposit->account->id]) : '' ?></td>
                    <td><?= $logDeposit->has('mst_deposit') ? $this->Html->link($logDeposit->mst_deposit->value, ['controller' => 'MstDeposits', 'action' => 'view', $logDeposit->mst_deposit->key]) : '' ?></td>
                    <td><?= h($logDeposit->created) ?></td>
                    <td><?= h($logDeposit->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('詳細'), ['action' => 'view', $logDeposit->id]) ?>
                        <?= $this->Html->link(__('編集'), ['action' => 'edit', $logDeposit->id]) ?>
                        <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $logDeposit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $logDeposit->id)]) ?>
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
