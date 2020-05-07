<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LogWithdrow Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $place
 * @property int|null $withdrow_id
 * @property int|null $account_id
 * @property int|null $amount
 * @property int $payment_method_id
 * @property int $fix_flg
 * @property string $comment
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\MstWithdraw $mst_withdraw
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\MstPaymentMethod $mst_payment_method
 */
class LogWithdrow extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'place' => true,
        'withdrow_id' => true,
        'account_id' => true,
        'amount' => true,
        'payment_method_id' => true,
        'fix_flg' => true,
        'comment' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'mst_withdraw' => true,
        'account' => true,
        'mst_payment_method' => true,
    ];
}
