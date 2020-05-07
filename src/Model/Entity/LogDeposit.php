<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LogDeposit Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $paymentmethod_id
 * @property int|null $amount
 * @property int|null $account_id
 * @property int|null $deposit_id
 * @property int|null $fix_flg
 * @property string|null $comment
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\MstPaymentMethod $mst_payment_method
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\MstDeposit $mst_deposit
 */
class LogDeposit extends Entity
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
        'paymentmethod_id' => true,
        'amount' => true,
        'account_id' => true,
        'deposit_id' => true,
        'fix_flg' => true,
        'comment' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'mst_payment_method' => true,
        'account' => true,
        'mst_deposit' => true,
    ];
}
