<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccountLog[]|\Cake\Collection\CollectionInterface $accountLogs
 */
?>
<div class="accountLogs index content">
    <?= $this->Html->link(__('New Account Log'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Account Logs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accountLogs as $accountLog): ?>
                <tr>
                    <td><?= $this->Number->format($accountLog->id) ?></td>
                    <td><?= $this->Number->format($accountLog->account_id) ?></td>
                    <td><?= $this->Number->format($accountLog->amount) ?></td>
                    <td><?= h($accountLog->created) ?></td>
                    <td><?= h($accountLog->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $accountLog->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $accountLog->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $accountLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountLog->id)]) ?>
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
