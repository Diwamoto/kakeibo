<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MstWithdraws Model
 *
 * @method \App\Model\Entity\MstWithdraw newEmptyEntity()
 * @method \App\Model\Entity\MstWithdraw newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MstWithdraw[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MstWithdraw get($primaryKey, $options = [])
 * @method \App\Model\Entity\MstWithdraw findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MstWithdraw patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MstWithdraw[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MstWithdraw|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MstWithdraw saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MstWithdraw[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MstWithdraw[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MstWithdraw[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MstWithdraw[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MstWithdrawsTable extends Table
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

        $this->setTable('mst_withdraws');
        $this->setDisplayField('value');
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
