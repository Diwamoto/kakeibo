<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * User Entity
 *
 
 * @property int $id
 * @property string $line_user_id
 * @property string $name
 * @property string $password
 * @property string|null $token
 * @property int|null $authority
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Account[] $accounts
 * @property \App\Model\Entity\LogDeposit[] $log_deposits
 * @property \App\Model\Entity\LogWithdraw[] $log_withdraws
 */
class User extends Entity
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
        'line_user_id' => true,
        'name' => true,
        'password' => true,
        'authority' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'accounts' => true,
        'log_deposits' => true,
        'log_withdraws' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
    
    protected function _setPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }
}
