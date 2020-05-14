<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LogDeposits Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\MstPaymentMethodsTable&\Cake\ORM\Association\BelongsTo $MstPaymentMethods
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 * @property \App\Model\Table\MstDepositsTable&\Cake\ORM\Association\BelongsTo $MstDeposits
 *
 * @method \App\Model\Entity\LogDeposit newEmptyEntity()
 * @method \App\Model\Entity\LogDeposit newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\LogDeposit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LogDeposit get($primaryKey, $options = [])
 * @method \App\Model\Entity\LogDeposit findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\LogDeposit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LogDeposit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LogDeposit|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LogDeposit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LogDeposit[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LogDeposit[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\LogDeposit[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LogDeposit[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LogDepositsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('log_deposits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
        ]);
        $this->belongsTo('MstDeposits', [
            'foreignKey' => 'deposit_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('amount')
            ->allowEmptyString('amount');

        $validator
            ->allowEmptyString('fix_flg');

        $validator
            ->scalar('comment')
            ->allowEmptyString('comment');

        return $validator;
    }

}
