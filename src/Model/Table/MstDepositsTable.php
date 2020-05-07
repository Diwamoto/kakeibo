<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MstDeposits Model
 *
 * @method \App\Model\Entity\MstDeposit newEmptyEntity()
 * @method \App\Model\Entity\MstDeposit newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MstDeposit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MstDeposit get($primaryKey, $options = [])
 * @method \App\Model\Entity\MstDeposit findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MstDeposit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MstDeposit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MstDeposit|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MstDeposit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MstDeposit[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MstDeposit[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MstDeposit[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MstDeposit[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MstDepositsTable extends Table
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

        $this->setTable('mst_deposits');
        $this->setDisplayField('key');
        $this->setPrimaryKey('key');
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
            ->integer('key')
            ->allowEmptyString('key', null, 'create');

        $validator
            ->scalar('value')
            ->allowEmptyString('value');

        return $validator;
    }
}
