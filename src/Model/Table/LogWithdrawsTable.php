<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LogWithdraws Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\MstWithdrawsTable&\Cake\ORM\Association\BelongsTo $MstWithdraws
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 * @property \App\Model\Table\MstPaymentMethodsTable&\Cake\ORM\Association\BelongsTo $MstPaymentMethods
 *
 * @method \App\Model\Entity\LogWithdraw newEmptyEntity()
 * @method \App\Model\Entity\LogWithdraw newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\LogWithdraw[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LogWithdraw get($primaryKey, $options = [])
 * @method \App\Model\Entity\LogWithdraw findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\LogWithdraw patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LogWithdraw[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LogWithdraw|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LogWithdraw saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LogWithdraw[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LogWithdraw[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\LogWithdraw[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LogWithdraw[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LogWithdrawsTable extends Table
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

        $this->setTable('log_withdraws');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('MstWithdraws', [
            'foreignKey' => 'withdraw_id',
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
        ]);
        $this->belongsTo('MstPaymentMethods', [
            'foreignKey' => 'payment_method_id',
            'joinType' => 'INNER',
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
            ->scalar('place')
            ->allowEmptyString('place');

        $validator
            ->integer('amount')
            ->allowEmptyString('amount');

        $validator
            ->requirePresence('fix_flg', 'create')
            ->notEmptyString('fix_flg');

        $validator
            ->scalar('comment')
            ->requirePresence('comment', 'create');

        return $validator;
    }
}
