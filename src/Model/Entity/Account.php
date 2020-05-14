<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Account Entity
 *
 * @property int $id
 * @property int|null $account_type
 * @property string|null $name
 * @property int $user_id
 * @property int|null $amount
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\LogDeposit[] $log_deposits
 * @property \App\Model\Entity\LogWithdraw[] $log_withdraws
 */
class Account extends Entity
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
        'account_type' => true,
        'name' => true,
        'user_id' => true,
        'amount' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'log_deposits' => true,
        'log_withdraws' => true,
    ];
}
